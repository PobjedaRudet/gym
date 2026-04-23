@extends('moderator.layout')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 style="font-weight:800;color:#1C1C1E;margin:0;">
        <svg width="24" height="24" fill="none" stroke="#30D158" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-4px;margin-right:6px;"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Termini treninga
    </h4>
    <a href="{{ route('moderator.termini.create') }}" class="btn btn-sm" style="background:#30D158;color:#fff;font-weight:700;border-radius:10px;padding:8px 18px;">
        + Novi termin
    </a>
</div>

@if($termini->isEmpty())
<div class="glass-card p-5 text-center">
    <svg width="48" height="48" fill="none" stroke="#ccc" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
    <p class="mt-3" style="color:#8E8E93;">Nemate kreiranih termina.</p>
</div>
@else
<div class="glass-card" style="overflow:hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:14px;">
            <thead style="background:#f8f8f8;">
                <tr>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Naziv</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Važi od</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Dani</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Vrijeme</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Prijave</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;text-align:right;">Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($termini as $t)
                <tr>
                    <td style="padding:14px 16px;font-weight:600;color:#1C1C1E;">{{ $t->naziv }}</td>
                    <td style="padding:14px 16px;color:#555;">{{ \Carbon\Carbon::parse($t->datum_od)->format('d.m.Y') }}</td>
                    <td style="padding:14px 16px;color:#555;">
                        @php $daniNazivi = [1=>'Pon',2=>'Uto',3=>'Sri',4=>'Čet',5=>'Pet',6=>'Sub',7=>'Ned']; @endphp
                        @foreach($t->dani ?? [] as $d)
                            <span style="background:rgba(48,209,88,0.1);color:#30D158;padding:2px 8px;border-radius:6px;font-size:11px;font-weight:700;">{{ $daniNazivi[$d] ?? $d }}</span>
                        @endforeach
                    </td>
                    <td style="padding:14px 16px;color:#555;">{{ \Carbon\Carbon::parse($t->vrijeme_od)->format('H:i') }} - {{ \Carbon\Carbon::parse($t->vrijeme_do)->format('H:i') }}</td>
                    <td style="padding:14px 16px;">
                        <a href="{{ route('moderator.termini.prijave', $t) }}" style="text-decoration:none;">
                            <span style="background:rgba(48,209,88,0.12);color:#30D158;padding:3px 10px;border-radius:8px;font-size:12px;font-weight:700;">{{ $t->prijave_count }} / {{ $t->max_mjesta }}</span>
                        </a>
                    </td>
                    <td style="padding:14px 16px;text-align:right;">
                        <a href="{{ route('moderator.termini.edit', $t) }}" class="btn btn-sm" style="background:rgba(90,200,250,0.1);color:#5AC8FA;font-weight:600;border-radius:8px;padding:4px 12px;font-size:12px;">Uredi</a>
                        <form action="{{ route('moderator.termini.delete', $t) }}" method="POST" style="display:inline;" onsubmit="return confirm('Obrisati termin?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:#ef4444;font-weight:600;border-radius:8px;padding:4px 12px;font-size:12px;">Obriši</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $termini->links() }}</div>
@endif
@endsection
