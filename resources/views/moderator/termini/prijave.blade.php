@extends('moderator.layout')

@section('content')
<h4 style="font-weight:800;color:#1C1C1E;margin-bottom:1.5rem;">
    <a href="{{ route('moderator.termini') }}" style="color:#8E8E93;text-decoration:none;">Termini</a>
    <span style="color:#ccc;margin:0 8px;">/</span> Prijave za: {{ $termin->naziv }}
</h4>

<div class="glass-card p-4 mb-3">
    <div class="d-flex flex-wrap gap-4" style="font-size:14px;">
        <div>
            <span style="color:#8E8E93;">Važi od:</span>
            <strong>{{ \Carbon\Carbon::parse($termin->datum_od)->format('d.m.Y') }}</strong>
        </div>
        <div>
            <span style="color:#8E8E93;">Dani:</span>
            @php $daniNazivi = [1=>'Pon',2=>'Uto',3=>'Sri',4=>'Čet',5=>'Pet',6=>'Sub',7=>'Ned']; @endphp
            <strong>{{ collect($termin->dani ?? [])->map(fn($d) => $daniNazivi[$d] ?? $d)->implode(', ') }}</strong>
        </div>
        <div>
            <span style="color:#8E8E93;">Vrijeme:</span>
            <strong>{{ \Carbon\Carbon::parse($termin->vrijeme_od)->format('H:i') }} - {{ \Carbon\Carbon::parse($termin->vrijeme_do)->format('H:i') }}</strong>
        </div>
        <div>
            <span style="color:#8E8E93;">Prijavljeno:</span>
            <strong style="color:#30D158;">{{ $termin->prijavljeniClanovi->count() }} / {{ $termin->max_mjesta }}</strong>
        </div>
    </div>
</div>

@if($termin->prijavljeniClanovi->isEmpty())
<div class="glass-card p-5 text-center">
    <p style="color:#8E8E93;">Nema prijavljenih članova za ovaj termin.</p>
</div>
@else
<div class="glass-card" style="overflow:hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:14px;">
            <thead style="background:#f8f8f8;">
                <tr>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">#</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Ime i prezime</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Email</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Prijavljen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($termin->prijavljeniClanovi as $index => $clan)
                <tr>
                    <td style="padding:14px 16px;color:#8E8E93;">{{ $index + 1 }}</td>
                    <td style="padding:14px 16px;font-weight:600;color:#1C1C1E;">{{ $clan->name }} {{ $clan->surname }}</td>
                    <td style="padding:14px 16px;color:#555;">{{ $clan->email }}</td>
                    <td style="padding:14px 16px;color:#8E8E93;">{{ $clan->pivot->created_at ? \Carbon\Carbon::parse($clan->pivot->created_at)->format('d.m.Y H:i') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
