@extends('member.layout')

@section('styles')
<style>
    .termin-card {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.06);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .termin-date-box {
        min-width: 56px; padding: 8px 10px; border-radius: 14px;
        background: rgba(255,55,95,0.08);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .termin-date-day { font-size: 11px; font-weight: 700; color: #FF375F; line-height: 1.4; }
    .termin-date-month { font-size: 10px; font-weight: 700; color: #FF375F; text-transform: uppercase; }
    .termin-naziv { font-weight: 700; font-size: 16px; color: #1C1C1E; }
    .termin-meta { font-size: 13px; color: #8E8E93; }
    .termin-opis { font-size: 13px; color: #666; margin-top: 0.5rem; }
    .spots-bar {
        height: 6px; border-radius: 3px; background: #f0f0f0; overflow: hidden; margin-top: 6px;
    }
    .spots-fill { height: 100%; border-radius: 3px; transition: width 0.3s; }
    .btn-prijava {
        background: #30D158; color: #fff; border: none; font-weight: 700;
        border-radius: 10px; padding: 8px 20px; font-size: 13px;
        transition: all 0.2s; cursor: pointer;
    }
    .btn-prijava:hover { background: #28b84d; color: #fff; }
    .btn-odjava {
        background: rgba(239,68,68,0.1); color: #ef4444; border: none; font-weight: 700;
        border-radius: 10px; padding: 8px 20px; font-size: 13px;
        transition: all 0.2s; cursor: pointer;
    }
    .btn-odjava:hover { background: rgba(239,68,68,0.2); }
    .btn-popunjeno {
        background: #f0f0f0; color: #8E8E93; border: none; font-weight: 600;
        border-radius: 10px; padding: 8px 20px; font-size: 13px;
        cursor: not-allowed;
    }
</style>
@endsection

@section('content')
<h4 style="font-weight:800;color:#1C1C1E;margin-bottom:1.5rem;">
    <svg width="24" height="24" fill="none" stroke="#30D158" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-4px;margin-right:6px;"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
    Termini treninga
</h4>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" style="border-radius:12px;font-size:14px;" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" style="border-radius:12px;font-size:14px;" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($termini->isEmpty())
<div style="background:#fff;border-radius:16px;padding:3rem;text-align:center;border:1px solid rgba(0,0,0,0.06);">
    <svg width="48" height="48" fill="none" stroke="#ccc" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
    <p class="mt-3" style="color:#8E8E93;">Nema dostupnih termina treninga.</p>
</div>
@else
@foreach($termini as $t)
@php
    $prijavljeno = $t->prijave_count;
    $popunjenost = $t->max_mjesta > 0 ? round(($prijavljeno / $t->max_mjesta) * 100) : 100;
    $jePrijavljen = in_array($t->id, $mojePrijave);
    $popunjeno = $prijavljeno >= $t->max_mjesta;
    $barColor = $popunjenost >= 90 ? '#FF375F' : ($popunjenost >= 60 ? '#FF9F0A' : '#30D158');
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
            <div class="spots-bar" style="max-width:200px;">
                <div class="spots-fill" style="width:{{ $popunjenost }}%;background:{{ $barColor }};"></div>
            </div>
        </div>
        <div class="align-self-center">
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
@endforeach
@endif
@endsection
