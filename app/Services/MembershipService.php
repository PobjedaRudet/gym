<?php

namespace App\Services;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Pravilo aktivne clanarine, isto kao u ActiveMember middleware-u i
 * MemberAuthController-u: uzima se uplata sa najvecim `end` i clan je aktivan
 * ako je `end` danas ili kasnije.
 */
class MembershipService
{
    public function latestFee(Member $member): ?object
    {
        return DB::table('fees')
            ->where('member_id', $member->id)
            ->orderBy('end', 'desc')
            ->first();
    }

    public function isActive(Member $member): bool
    {
        $clanarina = $this->latestFee($member);

        return $clanarina && Carbon::parse($clanarina->end)->gte(Carbon::now()->startOfDay());
    }

    /**
     * @return array{active: bool, expires_at: ?string, days_left: ?int}
     */
    public function summary(Member $member): array
    {
        $clanarina = $this->latestFee($member);

        if (!$clanarina) {
            return ['active' => false, 'expires_at' => null, 'days_left' => null];
        }

        $istek = Carbon::parse($clanarina->end)->startOfDay();
        $danas = Carbon::now()->startOfDay();
        $aktivan = $istek->gte($danas);

        return [
            'active' => $aktivan,
            'expires_at' => $istek->toDateString(),
            'days_left' => $aktivan ? $danas->diffInDays($istek) : 0,
        ];
    }
}
