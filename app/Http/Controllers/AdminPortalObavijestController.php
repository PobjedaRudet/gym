<?php

namespace App\Http\Controllers;

use App\Models\Obavijest;
use App\Models\Moderator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPortalObavijestController extends Controller
{
    public function index()
    {
        $this->authorizeAdminEmail();

        $obavijesti = Obavijest::query()
            ->select([
                'id',
                'naslov',
                'tip',
                'slika',
                'created_at',
                DB::raw('LEFT(sadrzaj, 220) as sadrzaj_preview'),
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.portal-obavijesti', compact('obavijesti'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdminEmail();

        $validated = $request->validate([
            'naslov' => ['required', 'string', 'max:255'],
            'sadrzaj' => ['required', 'string', 'max:5000'],
            'tip' => ['required', 'in:info,vazno,upozorenje,promo'],
            'slika' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        $slikaPath = null;
        if ($request->hasFile('slika')) {
            $file = $request->file('slika');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/obavijesti'), $filename);
            $slikaPath = $filename;
        }

        $moderator = $this->resolveModeratorForCurrentAdmin();

        Obavijest::create([
            'moderator_id' => $moderator->id,
            'naslov' => $validated['naslov'],
            'sadrzaj' => $validated['sadrzaj'],
            'tip' => $validated['tip'],
            'slika' => $slikaPath,
        ]);

        return redirect()
            ->route('admin.portal.obavijesti')
            ->with('success', 'Obavijest je uspjesno objavljena na portalu.');
    }

    public function edit(Obavijest $obavijest)
    {
        $this->authorizeAdminEmail();

        return view('admin.portal-obavijesti-edit', compact('obavijest'));
    }

    public function update(Request $request, Obavijest $obavijest)
    {
        $this->authorizeAdminEmail();

        $validated = $request->validate([
            'naslov' => ['required', 'string', 'max:255'],
            'sadrzaj' => ['required', 'string', 'max:5000'],
            'tip' => ['required', 'in:info,vazno,upozorenje,promo'],
            'slika' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        $data = [
            'naslov' => $validated['naslov'],
            'sadrzaj' => $validated['sadrzaj'],
            'tip' => $validated['tip'],
        ];

        if ($request->hasFile('slika')) {
            if ($obavijest->slika && file_exists(public_path('images/obavijesti/' . $obavijest->slika))) {
                unlink(public_path('images/obavijesti/' . $obavijest->slika));
            }

            $file = $request->file('slika');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/obavijesti'), $filename);
            $data['slika'] = $filename;
        }

        if ($request->has('ukloni_sliku') && !$request->hasFile('slika')) {
            if ($obavijest->slika && file_exists(public_path('images/obavijesti/' . $obavijest->slika))) {
                unlink(public_path('images/obavijesti/' . $obavijest->slika));
            }
            $data['slika'] = null;
        }

        $obavijest->update($data);

        return redirect()
            ->route('admin.portal.obavijesti')
            ->with('success', 'Obavijest je uspjesno azurirana.');
    }

    public function destroy(Obavijest $obavijest)
    {
        $this->authorizeAdminEmail();

        if ($obavijest->slika && file_exists(public_path('images/obavijesti/' . $obavijest->slika))) {
            unlink(public_path('images/obavijesti/' . $obavijest->slika));
        }

        $obavijest->delete();

        return redirect()
            ->route('admin.portal.obavijesti')
            ->with('success', 'Obavijest je uspjesno obrisana.');
    }

    private function authorizeAdminEmail(): void
    {
        if (!Auth::check() || Auth::user()->email !== 'admin@begsfit.ba') {
            abort(403);
        }
    }

    private function resolveModeratorForCurrentAdmin(): Moderator
    {
        $user = Auth::user();

        return Moderator::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'password' => Hash::make(Str::random(24)),
            ]
        );
    }
}
