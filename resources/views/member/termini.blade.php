@extends('member.layout')

@section('styles')
<style>
    body { background: #0a0a0a; color: #f4f4f5; }
    .main-content { background: #0a0a0a; }

    .page-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .page-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #f4f4f5;
        margin: 0;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .page-title svg { color: #ffb800; }

    .dash-flash {
        border-radius: 16px;
        font-size: 14px;
        border: 1px solid rgba(255,255,255,0.08);
        background: #131316;
        color: #f4f4f5;
    }
    .dash-flash-success {
        border-color: rgba(255,184,0,0.2);
        box-shadow: inset 0 0 0 1px rgba(255,184,0,0.08);
    }
    .dash-flash-danger {
        border-color: rgba(161,161,170,0.18);
        color: #e4e4e7;
    }

    .termin-card {
        background: linear-gradient(160deg, #131316, #101012);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 18px;
        padding: 1.35rem;
        margin-bottom: 1rem;
        box-shadow: 0 16px 32px rgba(0,0,0,0.24);
    }
    .termin-date-box {
        min-width: 62px; padding: 10px 10px; border-radius: 16px;
        background: rgba(255,184,0,0.12);
        border: 1px solid rgba(255,184,0,0.14);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .termin-date-day { font-size: 11px; font-weight: 800; color: #ffdd8a; line-height: 1.4; }
    .termin-date-month { font-size: 10px; font-weight: 700; color: #ffb800; text-transform: uppercase; }
    .termin-naziv { font-weight: 800; font-size: 17px; color: #f4f4f5; }
    .termin-meta { font-size: 13px; color: #a1a1aa; }
    .termin-opis { font-size: 13px; color: #d4d4d8; margin-top: 0.6rem; line-height: 1.7; }
    .spots-bar {
        height: 7px; border-radius: 999px; background: rgba(255,255,255,0.08); overflow: hidden; margin-top: 10px;
    }
    .spots-fill { height: 100%; border-radius: 3px; transition: width 0.3s; }
    .termin-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 0.95rem;
        border-top: 1px solid rgba(255,255,255,0.08);
        flex-wrap: wrap;
    }
    .termin-occupancy {
        min-width: 180px;
        flex: 1;
    }
    .termin-occupancy-top {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        font-size: 12px;
        color: #8b8b93;
        margin-bottom: 3px;
    }
    .termin-occupancy-top strong {
        color: #f4f4f5;
        font-weight: 700;
    }
    .btn-prijava {
        background: #ffb800; color: #111111; border: none; font-weight: 800;
        border-radius: 999px; padding: 10px 20px; font-size: 13px;
        transition: all 0.2s; cursor: pointer;
        box-shadow: 0 10px 24px rgba(255,184,0,0.2);
    }
    .btn-prijava:hover { background: #ffc933; color: #111111; }
    .btn-odjava {
        background: rgba(255,255,255,0.08); color: #f4f4f5; border: 1px solid rgba(255,255,255,0.12); font-weight: 700;
        border-radius: 999px; padding: 10px 20px; font-size: 13px;
        transition: all 0.2s; cursor: pointer;
    }
    .btn-odjava:hover { background: rgba(255,255,255,0.14); }
    .btn-popunjeno {
        background: rgba(161,161,170,0.16); color: #a1a1aa; border: 1px solid rgba(161,161,170,0.12); font-weight: 700;
        border-radius: 999px; padding: 10px 20px; font-size: 13px;
        cursor: not-allowed;
    }
    .termin-empty {
        background: linear-gradient(160deg, #131316, #101012);
        border-radius: 18px;
        padding: 3rem;
        text-align: center;
        border: 1px dashed rgba(255,255,255,0.12);
        color: #d4d4d8;
    }
    .termin-empty svg { stroke: #6b7280; }

    @media(max-width: 768px) {
        .termin-card {
            padding: 1.15rem;
        }
        .termin-card > .d-flex {
            flex-direction: column;
        }
        .termin-date-box {
            width: 100%;
            flex-direction: row;
            gap: 10px;
            justify-content: center;
        }
        .termin-footer {
            flex-direction: column;
            align-items: stretch;
        }
        .termin-footer form,
        .termin-footer button {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="page-head">
    <h4 class="page-title">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Termini treninga
    </h4>
</div>

@if(session('success'))
<div class="alert alert-dismissible fade show dash-flash dash-flash-success" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-dismissible fade show dash-flash dash-flash-danger" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($termini->isEmpty())
<div class="termin-empty">
    <svg width="48" height="48" fill="none" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
    <p class="mt-3" style="color:#d4d4d8;">Nema dostupnih termina treninga.</p>
</div>
@else
@foreach($termini as $t)
@php
    $prijavljeno = $t->prijave_count;
    $popunjenost = $t->max_mjesta > 0 ? round(($prijavljeno / $t->max_mjesta) * 100) : 100;
    $jePrijavljen = in_array($t->id, $mojePrijave);
    $popunjeno = $prijavljeno >= $t->max_mjesta;
    $barColor = $popunjenost >= 90 ? '#a1a1aa' : ($popunjenost >= 60 ? '#ffdd8a' : '#ffb800');
    $daniNazivi = [1=>'Pon',2=>'Uto',3=>'Sri',4=>'Čet',5=>'Pet',6=>'Sub',7=>'Ned'];
@endphp
<div class="termin-card">
    <div class="d-flex gap-3 align-items-start">
        <div class="termin-date-box">
            @foreach($t->dani ?? [] as $d)
                <div class="termin-date-day">{{ $daniNazivi[$d] ?? $d }}</div>
            @endforeach
        </div>
        <div style="flex:1;">
            <div class="termin-naziv">{{ $t->naziv }}</div>
            <div class="termin-meta">
                <svg width="14" height="14" fill="none" stroke="#8E8E93" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px;"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                {{ \Carbon\Carbon::parse($t->vrijeme_od)->format('H:i') }} - {{ \Carbon\Carbon::parse($t->vrijeme_do)->format('H:i') }}
                &nbsp;·&nbsp;
                <svg width="14" height="14" fill="none" stroke="#8E8E93" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px;"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                {{ $prijavljeno }}/{{ $t->max_mjesta }} mjesta
            </div>
            @if($t->opis)
            <div class="termin-opis">{{ $t->opis }}</div>
            @endif
            <div class="termin-footer">
                <div class="termin-occupancy">
                    <div class="termin-occupancy-top">
                        <span>Popunjenost</span>
                        <strong>{{ $popunjenost }}%</strong>
                    </div>
                    <div class="spots-bar">
                        <div class="spots-fill" style="width:{{ $popunjenost }}%;background:{{ $barColor }};"></div>
                    </div>
                </div>
                <div>
                    @if($jePrijavljen)
                    <form action="{{ route('member.termini.odjava', $t) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-odjava">Odjavi se</button>
                    </form>
                    @elseif($popunjeno)
                    <button class="btn-popunjeno" disabled>Popunjeno</button>
                    @else
                    <form action="{{ route('member.termini.prijava', $t) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-prijava">Prijavi se</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
@endsection
