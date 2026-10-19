<?php

namespace App\Http\Controllers\Api\V1\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\MemberResource;
use App\Mail\MemberPasswordMail;
use App\Mail\MemberResetPasswordMail;
use App\Models\Member;
use App\Services\MembershipService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Prijava, aktivacija naloga i zaboravljena lozinka za mobilnu aplikaciju.
 * Pravila su ista kao u MemberAuthController (web portal).
 */
class AuthController extends Controller
{
    private $membership;

    public function __construct(MembershipService $membership)
    {
        $this->membership = $membership;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'required|string|max:100',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (!$member || !$member->password || !Hash::check($request->password, $member->password)) {
            return response()->json([
                'message' => 'Neispravan email ili lozinka.',
                'code' => 'invalid_credentials',
            ], 401);
        }

        if (!$this->membership->isActive($member)) {
            return response()->json([
                'message' => 'Vaša članarina je istekla. Obratite se recepciji za produženje.',
                'code' => 'membership_expired',
            ], 403);
        }

        $token = $member->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'member' => new MemberResource($member),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Odjavljeni ste.']);
    }

    public function activate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (!$member) {
            return response()->json([
                'message' => 'Ovaj email nije registrovan u sistemu. Obratite se recepciji.',
                'code' => 'email_not_found',
            ], 422);
        }

        if ($member->password) {
            return response()->json([
                'message' => 'Nalog za ovaj email je već kreiran. Pokušajte se prijaviti.',
                'code' => 'already_activated',
            ], 422);
        }

        if (!$this->membership->isActive($member)) {
            return response()->json([
                'message' => 'Vaša članarina nije aktivna. Obratite se recepciji za produljenje.',
                'code' => 'membership_expired',
            ], 422);
        }

        $plainPassword = Str::random(10);
        $member->password = Hash::make($plainPassword);
        $member->save();

        try {
            Mail::to($member->email)->send(new MemberPasswordMail($member, $plainPassword));
        } catch (Exception $e) {
            $member->password = null;
            $member->save();
            report($e);

            return response()->json([
                'message' => 'Trenutno nije moguće poslati email za registraciju. Pokušajte ponovo za par minuta ili kontaktirajte recepciju.',
                'code' => 'mail_failed',
            ], 503);
        }

        return response()->json(['message' => 'Lozinka je poslana na Vaš email. Provjerite inbox.']);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (!$member || !$member->password) {
            return response()->json([
                'message' => 'Nije pronađen aktivan član sa ovom email adresom.',
                'code' => 'email_not_found',
            ], 422);
        }

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $member->email],
            ['token' => Hash::make($token), 'created_at' => Carbon::now()]
        );

        // Link vodi na postojecu web stranicu za reset lozinke.
        $resetUrl = route('member.password.reset', ['token' => $token, 'email' => $member->email]);

        try {
            Mail::to($member->email)->send(new MemberResetPasswordMail($member, $resetUrl));
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'message' => 'Trenutno nije moguće poslati reset link. Pokušajte ponovo kasnije.',
                'code' => 'mail_failed',
            ], 503);
        }

        return response()->json(['message' => 'Poslali smo link za reset lozinke na Vaš email.']);
    }
}
