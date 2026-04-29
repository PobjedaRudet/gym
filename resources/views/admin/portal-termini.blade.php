@extends('layouts.report')

@section('content')
<div class="container" style="max-width:1140px; padding-top:1.25rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
        <h3 style="margin:0;font-weight:800;color:#1a1a2e;">Portal termini treninga</h3>
        <span style="font-size:12px;color:#6b7280;">Prikazuju se clanovima na /portal/termini</span>
    </div>

    @if(session('success'))
        <div style="margin-bottom:1rem;padding:0.8rem 1rem;border-radius:12px;background:#ecfdf3;border:1px solid #a7f3d0;color:#065f46;font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="margin-bottom:1rem;padding:0.8rem 1rem;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;font-weight:600;">
            {{ $errors->first() }}
        </div>
    @endif

    @php
        $daniNazivi = [1 => 'Ponedjeljak', 2 => 'Utorak', 3 => 'Srijeda', 4 => 'Cetvrtak', 5 => 'Petak', 6 => 'Subota', 7 => 'Nedjelja'];
        $kratkiDani = [1 => 'Pon', 2 => 'Uto', 3 => 'Sri', 4 => 'Cet', 5 => 'Pet', 6 => 'Sub', 7 => 'Ned'];
    @endphp

    <div class="row g-4">
        <div class="col-lg-5">
            <div style="background:#fff;border-radius:16px;box-shadow:0 4px 16px rgba(0,0,0,0.08);padding:1.25rem;">
                <p style="font-size:15px;font-weight:700;color:#111827;margin-bottom:1rem;">Novi termin</p>

                <form method="POST" action="{{ route('admin.portal.termini.store') }}">
                    @csrf
                    <div style="margin-bottom:10px;">
                        <label for="naziv" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Naziv treninga</label>
                        <input id="naziv" name="naziv" type="text" value="{{ old('naziv') }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                    </div>

                    <div style="margin-bottom:10px;">
                        <label for="opis" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Opis (opcionalno)</label>
                        <textarea id="opis" name="opis" rows="3" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">{{ old('opis') }}</textarea>
                    </div>

                    <div class="row" style="margin-bottom:10px;">
                        <div class="col-md-4" style="margin-bottom:8px;">
                            <label for="datum_od" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Datum od</label>
                            <input id="datum_od" name="datum_od" type="date" value="{{ old('datum_od') }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                        </div>
                        <div class="col-md-4" style="margin-bottom:8px;">
                            <label for="vrijeme_od" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Vrijeme od</label>
                            <input id="vrijeme_od" name="vrijeme_od" type="time" value="{{ old('vrijeme_od') }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                        </div>
                        <div class="col-md-4" style="margin-bottom:8px;">
                            <label for="vrijeme_do" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Vrijeme do</label>
                            <input id="vrijeme_do" name="vrijeme_do" type="time" value="{{ old('vrijeme_do') }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                        </div>
                    </div>

                    <div style="margin-bottom:10px;">
                        <label style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Dani u sedmici</label>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            @foreach($daniNazivi as $num => $naziv)
                                <label style="display:inline-flex;align-items:center;gap:6px;background:#f3f4f6;padding:7px 10px;border-radius:10px;font-size:12px;color:#374151;cursor:pointer;">
                                    <input type="checkbox" name="dani[]" value="{{ $num }}" {{ is_array(old('dani')) && in_array($num, old('dani')) ? 'checked' : '' }}>
                                    <span>{{ $naziv }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="margin-bottom:14px;max-width:220px;">
                        <label for="max_mjesta" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Maksimalan broj mjesta</label>
                        <input id="max_mjesta" name="max_mjesta" type="number" min="1" max="100" value="{{ old('max_mjesta', 20) }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                    </div>

                    <button type="submit" style="border:none;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;cursor:pointer;">
                        Objavi termin
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div style="background:#fff;border-radius:16px;box-shadow:0 4px 16px rgba(0,0,0,0.08);padding:1.25rem;">
                <p style="font-size:15px;font-weight:700;color:#111827;margin-bottom:1rem;">Aktivni termini</p>

                @forelse($termini as $termin)
                    @php
                        $prijavljeno = $termin->prijave_count ?? 0;
                        $dani = collect($termin->dani ?? [])->map(function ($d) use ($kratkiDani) {
                            return $kratkiDani[$d] ?? $d;
                        })->implode(', ');
                    @endphp

                    <div style="border:1px solid #e5e7eb;border-radius:12px;padding:0.9rem;margin-bottom:0.75rem;">
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:0.75rem;flex-wrap:wrap;">
                            <strong style="color:#111827;">{{ $termin->naziv }}</strong>
                            <span style="font-size:11px;font-weight:700;padding:3px 8px;border-radius:999px;background:#f0f9ff;color:#0369a1;">{{ $prijavljeno }}/{{ $termin->max_mjesta }} prijava</span>
                        </div>
                        <p style="margin:0.4rem 0 0;color:#4b5563;font-size:13px;">
                            {{ $dani }} | {{ \Carbon\Carbon::parse($termin->vrijeme_od)->format('H:i') }} - {{ \Carbon\Carbon::parse($termin->vrijeme_do)->format('H:i') }}
                        </p>
                        <p style="margin:0.3rem 0 0;color:#6b7280;font-size:12px;">Vazi od: {{ \Carbon\Carbon::parse($termin->datum_od)->format('d.m.Y') }}</p>
                        @if($termin->opis)
                            <p style="margin:0.5rem 0 0;color:#374151;">{{ \Illuminate\Support\Str::limit($termin->opis, 180) }}</p>
                        @endif
                        <div style="margin-top:0.65rem;display:flex;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('admin.portal.termini.edit', $termin) }}" style="display:inline-block;background:#e0f2fe;color:#075985;text-decoration:none;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700;">Uredi</a>
                            <form method="POST" action="{{ route('admin.portal.termini.destroy', $termin) }}" onsubmit="return confirm('Obrisati termin?');" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border:none;background:#fee2e2;color:#991b1b;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700;cursor:pointer;">Obrisi</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="color:#6b7280;margin:0;">Nema kreiranih termina.</p>
                @endforelse

                <div style="margin-top:0.8rem;">
                    {{ $termini->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
