@extends('layouts.report')

@section('content')
<div class="container" style="max-width:920px; padding-top:1.25rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
        <h3 style="margin:0;font-weight:800;color:#1a1a2e;">Uredi portal termin</h3>
        <a href="{{ route('admin.portal.termini') }}" style="text-decoration:none;background:#f3f4f6;color:#374151;border-radius:10px;padding:8px 12px;font-size:12px;font-weight:700;">Nazad</a>
    </div>

    @if($errors->any())
        <div style="margin-bottom:1rem;padding:0.8rem 1rem;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;font-weight:600;">
            {{ $errors->first() }}
        </div>
    @endif

    @php
        $daniNazivi = [1 => 'Ponedjeljak', 2 => 'Utorak', 3 => 'Srijeda', 4 => 'Cetvrtak', 5 => 'Petak', 6 => 'Subota', 7 => 'Nedjelja'];
        $oldDani = old('dani', $termin->dani ?? []);
    @endphp

    <div style="background:#fff;border-radius:16px;box-shadow:0 4px 16px rgba(0,0,0,0.08);padding:1.25rem;">
        <form method="POST" action="{{ route('admin.portal.termini.update', $termin) }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom:10px;">
                <label for="naziv" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Naziv treninga</label>
                <input id="naziv" name="naziv" type="text" value="{{ old('naziv', $termin->naziv) }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
            </div>

            <div style="margin-bottom:10px;">
                <label for="opis" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Opis (opcionalno)</label>
                <textarea id="opis" name="opis" rows="4" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">{{ old('opis', $termin->opis) }}</textarea>
            </div>

            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-4" style="margin-bottom:8px;">
                    <label for="datum_od" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Datum od</label>
                    <input id="datum_od" name="datum_od" type="date" value="{{ old('datum_od', optional($termin->datum_od)->format('Y-m-d')) }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                </div>
                <div class="col-md-4" style="margin-bottom:8px;">
                    <label for="vrijeme_od" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Vrijeme od</label>
                    <input id="vrijeme_od" name="vrijeme_od" type="time" value="{{ old('vrijeme_od', \Carbon\Carbon::parse($termin->vrijeme_od)->format('H:i')) }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                </div>
                <div class="col-md-4" style="margin-bottom:8px;">
                    <label for="vrijeme_do" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Vrijeme do</label>
                    <input id="vrijeme_do" name="vrijeme_do" type="time" value="{{ old('vrijeme_do', \Carbon\Carbon::parse($termin->vrijeme_do)->format('H:i')) }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                </div>
            </div>

            <div style="margin-bottom:10px;">
                <label style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Dani u sedmici</label>
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    @foreach($daniNazivi as $num => $naziv)
                        <label style="display:inline-flex;align-items:center;gap:6px;background:#f3f4f6;padding:7px 10px;border-radius:10px;font-size:12px;color:#374151;cursor:pointer;">
                            <input type="checkbox" name="dani[]" value="{{ $num }}" {{ is_array($oldDani) && in_array($num, $oldDani) ? 'checked' : '' }}>
                            <span>{{ $naziv }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="margin-bottom:14px;max-width:220px;">
                <label for="max_mjesta" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Maksimalan broj mjesta</label>
                <input id="max_mjesta" name="max_mjesta" type="number" min="1" max="100" value="{{ old('max_mjesta', $termin->max_mjesta) }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
            </div>

            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button type="submit" style="border:none;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;cursor:pointer;">Sacuvaj izmjene</button>
                <a href="{{ route('admin.portal.termini') }}" style="text-decoration:none;background:#f3f4f6;color:#374151;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;">Odustani</a>
            </div>
        </form>
    </div>
</div>
@endsection
