<?php

namespace App\Http\Controllers\Api\V1\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\MemberResource;
use App\Models\Obavijest;
use App\Models\TerminTreninga;
use App\Services\MemberStatsService;
use App\Services\ProfilePhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class ProfileController extends Controller
{
    private $stats;

    public function __construct(MemberStatsService $stats)
    {
        $this->stats = $stats;
    }

    public function me(Request $request)
    {
        return new MemberResource($request->user());
    }

    public function dashboard(Request $request)
    {
        return response()->json(['data' => $this->stats->dashboard($request->user())]);
    }

    public function statistics(Request $request)
    {
        return response()->json(['data' => $this->stats->statistics($request->user())]);
    }

    /**
     * Brojaci "novo" u meniju, isti kao u member/layout.blade.php.
     */
    public function badges(Request $request)
    {
        $member = $request->user();

        return response()->json(['data' => [
            'unread_announcements' => Obavijest::where('created_at', '>', $member->last_seen_obavijesti ?? '2000-01-01')->count(),
            'new_trainings' => TerminTreninga::where('created_at', '>', $member->last_seen_termini ?? '2000-01-01')->count(),
        ]]);
    }

    public function settings(Request $request)
    {
        $goals = $this->stats->goals($request->user());

        return response()->json(['data' => [
            'monthly_goal_visits' => $goals['visits'],
            'monthly_goal_hours' => (int) round($goals['minutes'] / 60),
        ]]);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'monthly_goal_visits' => ['required', 'integer', 'min:1', 'max:60'],
            'monthly_goal_hours' => ['required', 'integer', 'min:1', 'max:300'],
        ]);

        $member = $request->user();
        $member->monthly_goal_visits = (int) $validated['monthly_goal_visits'];
        $member->monthly_goal_minutes = (int) $validated['monthly_goal_hours'] * 60;
        $member->save();

        return response()->json([
            'message' => 'Postavke su uspješno sačuvane.',
            'data' => [
                'monthly_goal_visits' => $member->monthly_goal_visits,
                'monthly_goal_hours' => (int) $validated['monthly_goal_hours'],
            ],
        ]);
    }

    public function updatePhoto(Request $request, ProfilePhotoService $photos)
    {
        $request->validate([
            'profile_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $member = $request->user();

        try {
            $photos->store($member, $request->file('profile_image'));
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage(), 'code' => 'photo_failed'], 422);
        }

        return response()->json([
            'message' => 'Profilna slika je uspješno ažurirana.',
            'data' => new MemberResource($member->fresh()),
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $member = $request->user();

        if (!Hash::check($request->current_password, $member->password)) {
            return response()->json([
                'message' => 'Trenutna lozinka nije ispravna.',
                'errors' => ['current_password' => ['Trenutna lozinka nije ispravna.']],
            ], 422);
        }

        $member->password = Hash::make($request->password);
        $member->save();

        return response()->json(['message' => 'Lozinka je uspješno promijenjena.']);
    }
}
