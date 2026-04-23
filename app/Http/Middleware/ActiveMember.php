<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActiveMember
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('member')->check()) {
            return redirect()->route('member.login');
        }

        $member = Auth::guard('member')->user();

        $clanarina = DB::table('fees')
            ->where('member_id', $member->id)
            ->orderBy('end', 'desc')
            ->first();

        $aktivanClan = $clanarina && Carbon::parse($clanarina->end)->gte(Carbon::now()->startOfDay());

        if (!$aktivanClan) {
            Auth::guard('member')->logout();
            return redirect()->route('member.login')->withErrors(['email' => 'Vaša članarina je istekla. Obratite se recepciji za produljenje.']);
        }

        return $next($request);
    }
}
