<?php

namespace App\Http\Middleware;

use App\Services\MembershipService;
use Closure;
use Illuminate\Http\Request;

/**
 * API verzija ActiveMember middleware-a: clan sa isteklom clanarinom dobija
 * 403 sa kodom membership_expired na svakom zahtjevu, kao sto ga web portal
 * odjavljuje na svakom zahtjevu.
 */
class EnsureActiveMembershipApi
{
    private $membership;

    public function __construct(MembershipService $membership)
    {
        $this->membership = $membership;
    }

    public function handle(Request $request, Closure $next)
    {
        $member = $request->user();

        if (!$member || !$this->membership->isActive($member)) {
            return response()->json([
                'message' => 'Vaša članarina je istekla. Obratite se recepciji za produženje.',
                'code' => 'membership_expired',
            ], 403);
        }

        return $next($request);
    }
}
