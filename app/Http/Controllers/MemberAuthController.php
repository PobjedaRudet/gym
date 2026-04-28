<?php

namespace App\Http\Controllers;

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
