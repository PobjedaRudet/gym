<?php

namespace App\Services;

use App\Models\Member;
use App\Models\PrijavaTreninga;
use App\Models\TerminTreninga;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Pravila prijave na termin, ista kao MemberPortalController::prijaviSe():
 * termin mora biti aktivan (datum_od <= danas), clan ne smije vec biti
 * prijavljen i mora biti slobodnih mjesta. Provjera kapaciteta se radi
 * unutar transakcije sa zakljucanim terminom da dvije istovremene prijave
 * ne predju max_mjesta.
 */
class TrainingSignupService
{
    public const OK = 'ok';
    public const NOT_ACTIVE = 'not_active';
    public const ALREADY_SIGNED_UP = 'already_signed_up';
    public const FULL = 'full';

    public function signUp(TerminTreninga $termin, Member $member): string
    {
        if ($termin->datum_od && $termin->datum_od->gt(Carbon::today())) {
            return self::NOT_ACTIVE;
        }

        return DB::transaction(function () use ($termin, $member) {
            $zakljucan = TerminTreninga::whereKey($termin->id)->lockForUpdate()->first();

            $postoji = PrijavaTreninga::where('termin_id', $zakljucan->id)
                ->where('member_id', $member->id)
                ->exists();

            if ($postoji) {
                return self::ALREADY_SIGNED_UP;
            }

            if (PrijavaTreninga::where('termin_id', $zakljucan->id)->count() >= $zakljucan->max_mjesta) {
                return self::FULL;
            }

            PrijavaTreninga::create([
                'termin_id' => $zakljucan->id,
                'member_id' => $member->id,
            ]);

            return self::OK;
        });
    }

    public function cancel(TerminTreninga $termin, Member $member): void
    {
        PrijavaTreninga::where('termin_id', $termin->id)
            ->where('member_id', $member->id)
            ->delete();
    }
}
