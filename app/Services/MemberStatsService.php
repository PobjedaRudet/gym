<?php

namespace App\Services;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Statistika dolazaka za mobilni API. Upiti su preuzeti iz
 * MemberPortalController::profile() i ::statistics() bez promjene logike,
 * tako da web portal i aplikacija prikazuju iste brojeve.
 */
class MemberStatsService
{
    private const MJESECI = ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'];

    public function goals(Member $member): array
    {
        return [
            'visits' => max((int) ($member->monthly_goal_visits ?? 20), 1),
            'minutes' => max((int) ($member->monthly_goal_minutes ?? 1800), 1),
        ];
    }

    public function dashboard(Member $member): array
    {
        $id = $member->id;
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $weekStart = $now->copy()->startOfWeek(Carbon::MONDAY);
        $daniNazivi = ['P', 'U', 'S', 'Č', 'P', 'S', 'N'];
        $sedmica = [];
        for ($d = 0; $d < 7; $d++) {
            $dan = $weekStart->copy()->addDays($d);
            $sedmica[] = [
                'label' => $daniNazivi[$d],
                'date' => $dan->toDateString(),
                'count' => DB::table('attendances')->where('member_id', $id)->whereDate('in', $dan->toDateString())->count(),
                'today' => $dan->isToday(),
                'past' => $dan->lt($now->copy()->startOfDay()),
            ];
        }

        $mjeseci = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $mjeseci[] = [
                'label' => self::MJESECI[$date->month - 1],
                'year' => $date->year,
                'month' => $date->month,
                'visits' => $this->visitsInMonth($id, $date),
                'current' => $i === 0,
            ];
        }

        return [
            'total_visits' => DB::table('attendances')->where('member_id', $id)->count(),
            'visits_this_month' => $this->visitsInMonth($id, $now),
            'visits_last_month' => $this->visitsInMonth($id, $lastMonth),
            'time_total' => $this->timeStats($id),
            'time_this_month' => $this->timeStats($id, $now),
            'goals' => $this->goals($member),
            'week' => $sedmica,
            'last_six_months' => $mjeseci,
            'checked_in' => $this->checkedIn($id),
        ];
    }

    /**
     * Clan je trenutno u teretani ako ima dolazak bez odjave iz zadnjih 12 sati
     * (stariji otvoreni dolasci su zaboravljene odjave). Sala je kao u /live:
     * gym = 1 je Gym, ostalo Ladies Gym.
     *
     * @return array{checked_in_at: string, gym: ?string}|null
     */
    private function checkedIn(int $memberId): ?array
    {
        $r = DB::table('attendances')
            ->where('member_id', $memberId)
            ->whereNull('out')
            ->where('in', '>=', Carbon::now()->subHours(12))
            ->orderByDesc('in')
            ->first();

        if (!$r) {
            return null;
        }

        $gym = $r->gym ?? null;

        return [
            'checked_in_at' => Carbon::parse($r->in)->toIso8601String(),
            'gym' => $gym === null ? null : ((int) $gym === 1 ? 'Gym' : 'Ladies Gym'),
        ];
    }

    public function statistics(Member $member): array
    {
        $id = $member->id;
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $mjesecni = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $vrijeme = $this->timeStats($id, $date);
            $mjesecni[] = [
                'label' => self::MJESECI[$date->month - 1] . ' ' . $date->year,
                'short_label' => self::MJESECI[$date->month - 1],
                'visits' => $this->visitsInMonth($id, $date),
                'total_minutes' => $vrijeme['total_minutes'],
                'average_minutes' => $vrijeme['average_minutes'],
                'current' => $i === 0,
            ];
        }

        $trenutnaGodina = $now->year;
        $prethodnaGodina = $trenutnaGodina - 1;
        // Dolasci i minute po mjesecima za sve godine clanstva.
        $godisnjiRaw = DB::table('attendances')
            ->where('member_id', $id)
            ->selectRaw('YEAR(`in`) as godina, MONTH(`in`) as mjesec, COUNT(*) as dolasci, COALESCE(SUM(CASE WHEN `out` IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, `in`, `out`) ELSE 0 END), 0) as ukupno_minuta')
            ->groupBy('godina', 'mjesec')
            ->get()
            ->groupBy('godina');

        // 12 mjeseci jedne godine: broj dolazaka i sati (0 za mjesece bez dolazaka).
        $poMjesecima = function (int $godina) use ($godisnjiRaw): array {
            $visits = [];
            $hours = [];
            for ($m = 1; $m <= 12; $m++) {
                $r = isset($godisnjiRaw[$godina]) ? $godisnjiRaw[$godina]->firstWhere('mjesec', $m) : null;
                $visits[] = $r ? (int) $r->dolasci : 0;
                $hours[] = $r ? round($r->ukupno_minuta / 60, 1) : 0;
            }
            return ['visits' => $visits, 'hours' => $hours];
        };

        $godisnji = [
            'labels' => self::MJESECI,
            'current' => ['year' => $trenutnaGodina] + $poMjesecima($trenutnaGodina),
            'previous' => ['year' => $prethodnaGodina] + $poMjesecima($prethodnaGodina),
        ];

        // Sve godine sa dolascima, od najnovije (pregled prethodnih godina u aplikaciji).
        $godine = [];
        foreach ($godisnjiRaw->keys()->map(fn ($g) => (int) $g)->sortDesc() as $godina) {
            $redovi = $godisnjiRaw[$godina];
            $godine[] = ['year' => $godina] + $poMjesecima($godina) + [
                'total_visits' => (int) $redovi->sum('dolasci'),
                'total_hours' => round($redovi->sum('ukupno_minuta') / 60, 1),
            ];
        }

        $sedmice = [];
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek(Carbon::MONDAY);
            $weekEnd = (clone $weekStart)->endOfWeek(Carbon::SUNDAY);
            $minuta = DB::table('attendances')
                ->where('member_id', $id)
                ->whereNotNull('out')
                ->whereBetween('in', [$weekStart, $weekEnd])
                ->selectRaw('COALESCE(SUM(TIMESTAMPDIFF(MINUTE, `in`, `out`)), 0) as ukupno')
                ->first();
            $sedmice[] = [
                'label' => $weekStart->format('d.m') . ' - ' . $weekEnd->format('d.m'),
                'visits' => DB::table('attendances')->where('member_id', $id)->whereBetween('in', [$weekStart, $weekEnd])->count(),
                'minutes' => (int) ($minuta->ukupno ?? 0),
                'current' => $i === 0,
            ];
        }

        // DAYOFWEEK: 1 = nedjelja ... 7 = subota (isti redoslijed kao web portal)
        $raspodjela = DB::table('attendances')
            ->where('member_id', $id)
            ->selectRaw('DAYOFWEEK(`in`) as dan, COUNT(*) as broj')
            ->groupBy('dan')
            ->pluck('broj', 'dan')
            ->toArray();
        $dani = [];
        foreach (['Ned', 'Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub'] as $idx => $naziv) {
            $dani[] = ['label' => $naziv, 'visits' => (int) ($raspodjela[$idx + 1] ?? 0)];
        }

        return [
            'total_visits' => DB::table('attendances')->where('member_id', $id)->count(),
            'visits_this_month' => $this->visitsInMonth($id, $now),
            'visits_last_month' => $this->visitsInMonth($id, $lastMonth),
            'time_total' => $this->timeStats($id),
            'time_this_month' => $this->timeStats($id, $now),
            'time_last_month' => $this->timeStats($id, $lastMonth),
            'goals' => $this->goals($member),
            'monthly' => $mjesecni,
            'yearly' => $godisnji,
            'years' => $godine,
            'weekly' => $sedmice,
            'weekdays' => $dani,
        ];
    }

    private function visitsInMonth(int $memberId, Carbon $date): int
    {
        return DB::table('attendances')
            ->where('member_id', $memberId)
            ->whereYear('in', $date->year)
            ->whereMonth('in', $date->month)
            ->count();
    }

    /**
     * @return array{average_minutes: int, total_minutes: int}
     */
    private function timeStats(int $memberId, ?Carbon $month = null): array
    {
        $q = DB::table('attendances')->where('member_id', $memberId)->whereNotNull('out');

        if ($month) {
            $q->whereYear('in', $month->year)->whereMonth('in', $month->month);
        }

        $r = $q->selectRaw('COALESCE(ROUND(AVG(TIMESTAMPDIFF(MINUTE, `in`, `out`))), 0) as prosjek, COALESCE(SUM(TIMESTAMPDIFF(MINUTE, `in`, `out`)), 0) as ukupno')->first();

        return [
            'average_minutes' => (int) ($r->prosjek ?? 0),
            'total_minutes' => (int) ($r->ukupno ?? 0),
        ];
    }
}
