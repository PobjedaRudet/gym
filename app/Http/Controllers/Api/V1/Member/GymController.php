<?php

namespace App\Http\Controllers\Api\V1\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\AnnouncementResource;
use App\Http\Resources\Api\V1\TrainingResource;
use App\Models\Obavijest;
use App\Models\PrijavaTreninga;
use App\Models\TerminTreninga;
use App\Services\TrainingSignupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Live prisutnost, obavijesti i termini treninga — isti podaci kao
 * MemberPortalController::live(), ::obavijesti(), ::termini().
 */
class GymController extends Controller
{
    public function live()
    {
        $mapiraj = function ($r) {
            return [
                'name' => $r->name,
                'surname' => $r->surname,
                'photo_url' => $r->image_path ? asset('images/' . $r->image_path) : null,
                'checked_in_at' => $r->in,
            ];
        };

        $upit = function () {
            return DB::table('attendances')
                ->join('members', 'attendances.member_id', '=', 'members.id')
                ->whereNull('attendances.out')
                ->select('members.name', 'members.surname', 'members.image_path', 'attendances.in')
                ->orderBy('attendances.in', 'desc');
        };

        return response()->json(['data' => [
            'gym' => $upit()->where('attendances.gym', 1)->get()->map($mapiraj)->values(),
            'ladies_gym' => $upit()->where('attendances.gym', '!=', 1)->get()->map($mapiraj)->values(),
        ]]);
    }

    public function announcements(Request $request)
    {
        $member = $request->user();
        $member->last_seen_obavijesti = now();
        $member->save();

        return AnnouncementResource::collection(
            Obavijest::orderBy('created_at', 'desc')->paginate(10)
        );
    }

    public function announcement(Obavijest $obavijest)
    {
        return new AnnouncementResource($obavijest);
    }

    public function trainings(Request $request)
    {
        $member = $request->user();

        $termini = TerminTreninga::withCount('prijave')
            ->orderBy('datum_od', 'desc')
            ->orderBy('vrijeme_od', 'asc')
            ->get();

        $request->attributes->set('signed_up_ids', $this->signedUpIds($member->id));

        $member->update(['last_seen_termini' => now()]);

        return TrainingResource::collection($termini);
    }

    public function signUp(Request $request, TerminTreninga $termin, TrainingSignupService $signups)
    {
        $rezultat = $signups->signUp($termin, $request->user());

        $greske = [
            TrainingSignupService::NOT_ACTIVE => 'Ovaj termin još nije aktivan.',
            TrainingSignupService::ALREADY_SIGNED_UP => 'Već ste prijavljeni na ovaj termin.',
            TrainingSignupService::FULL => 'Nema slobodnih mjesta za ovaj termin.',
        ];

        if ($rezultat !== TrainingSignupService::OK) {
            return response()->json(['message' => $greske[$rezultat], 'code' => $rezultat], 409);
        }

        return $this->trainingResponse($request, $termin, 'Uspješno ste se prijavili na trening.', 201);
    }

    public function cancel(Request $request, TerminTreninga $termin, TrainingSignupService $signups)
    {
        $signups->cancel($termin, $request->user());

        return $this->trainingResponse($request, $termin, 'Uspješno ste se odjavili sa treninga.');
    }

    private function trainingResponse(Request $request, TerminTreninga $termin, string $poruka, int $status = 200)
    {
        $request->attributes->set('signed_up_ids', $this->signedUpIds($request->user()->id));
        $termin->loadCount('prijave');

        return response()->json([
            'message' => $poruka,
            'data' => (new TrainingResource($termin))->toArray($request),
        ], $status);
    }

    private function signedUpIds(int $memberId): array
    {
        return PrijavaTreninga::where('member_id', $memberId)
            ->pluck('termin_id')
            ->map(function ($id) {
                return (int) $id;
            })
            ->all();
    }
}
