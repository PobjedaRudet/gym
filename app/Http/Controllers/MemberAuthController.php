<?php

namespace App\Http\Controllers;

use App\Mail\MemberResetPasswordMail;
use App\Mail\MemberPasswordMail;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MemberAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('member.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (!$member) {
            return back()->withErrors(['email' => 'Ovaj email nije registrovan u sistemu. Obratite se recepciji.'])->withInput();
        }

        if ($member->password) {
            return back()->withErrors(['email' => 'Nalog za ovaj email je već kreiran. Pokušajte se prijaviti.'])->withInput();
        }

        // Provjeri da li ima aktivnu članarinu
        $clanarina = DB::table('fees')
            ->where('member_id', $member->id)
            ->orderBy('end', 'desc')
            ->first();

        $aktivanClan = $clanarina && Carbon::parse($clanarina->end)->gte(Carbon::now()->startOfDay());

        if (!$aktivanClan) {
            return back()->withErrors(['email' => 'Vaša članarina nije aktivna. Obratite se recepciji za produljenje.'])->withInput();
        }

        $plainPassword = Str::random(10);
        $member->password = Hash::make($plainPassword);
        $member->save();

        Mail::to($member->email)->send(new MemberPasswordMail($member, $plainPassword));

        return redirect()->route('member.login')->with('success', 'Lozinka je poslana na Vaš email. Provjerite inbox.');
    }

    public function showLoginForm()
    {
        return view('member.login');
    }

    public function showForgotPasswordForm()
    {
        return view('member.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (!$member || !$member->password) {
            return back()->withErrors([
                'email' => 'Nije pronađen aktivan član sa ovom email adresom.',
            ])->withInput();
        }

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $member->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        $resetUrl = route('member.password.reset', [
            'token' => $token,
            'email' => $member->email,
        ]);

        Mail::to($member->email)->send(new MemberResetPasswordMail($member, $resetUrl));

        return back()->with('success', 'Poslali smo link za reset lozinke na Vaš email.');
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('member.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $resetRow = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$resetRow || !Hash::check($request->token, $resetRow->token)) {
            return back()->withErrors([
                'email' => 'Link za reset lozinke nije validan.',
            ])->withInput($request->only('email'));
        }

        $expireMinutes = (int) config('auth.passwords.members.expire', 60);
        $createdAt = Carbon::parse($resetRow->created_at);

        if ($createdAt->addMinutes($expireMinutes)->isPast()) {
            DB::table('password_resets')->where('email', $request->email)->delete();

            return back()->withErrors([
                'email' => 'Link za reset lozinke je istekao. Zatražite novi link.',
            ])->withInput($request->only('email'));
        }

        $member = Member::where('email', $request->email)->first();

        if (!$member) {
            return back()->withErrors([
                'email' => 'Član nije pronađen.',
            ])->withInput($request->only('email'));
        }

        $member->password = Hash::make($request->password);
        $member->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('member.login')->with('success', 'Lozinka je uspješno resetovana. Prijavite se novom lozinkom.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        $member = Member::where('email', $credentials['email'])->first();

        if (!$member || !$member->password) {
            return back()->withErrors(['email' => 'Neispravan email ili lozinka.'])->withInput();
        }

        if (!Hash::check($credentials['password'], $member->password)) {
            return back()->withErrors(['email' => 'Neispravan email ili lozinka.'])->withInput();
        }

        // Provjeri da li ima aktivnu članarinu
        $clanarina = DB::table('fees')
            ->where('member_id', $member->id)
            ->orderBy('end', 'desc')
            ->first();

        $aktivanClan = $clanarina && Carbon::parse($clanarina->end)->gte(Carbon::now()->startOfDay());

        if (!$aktivanClan) {
            return back()->withErrors(['email' => 'Vaša članarina je istekla. Obratite se recepciji za produženje.'])->withInput();
        }

        Auth::guard('member')->login($member, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->route('member.profile');
    }

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('member.login');
    }

    public function showChangePasswordForm()
    {
        return view('member.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        /** @var \App\Models\Member $member */
        $member = Auth::guard('member')->user();

        if (!Hash::check($request->current_password, $member->password)) {
            return back()->withErrors(['current_password' => 'Trenutna lozinka nije ispravna.']);
        }

        $member->password = Hash::make($request->password);
        $member->save();

        return back()->with('success', 'Lozinka je uspješno promijenjena.');
    }
}
