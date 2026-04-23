@extends('moderator.layout')

@section('content')
<h4 style="font-weight:800;color:#1C1C1E;margin-bottom:1.5rem;">
    <svg width="24" height="24" fill="none" stroke="#FF375F" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-4px;margin-right:6px;"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
    Dobrodošli, {{ $moderator->name }}
</h4>

<div class="row g-3">
    <div class="col-sm-12 col-md-4">
        <div class="glass-card p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(191,90,242,0.1);display:flex;align-items:center;justify-content:center;">
                    <svg width="24" height="24" fill="none" stroke="#BF5AF2" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4-4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <div>
                    <div style="font-size:13px;color:#8E8E93;font-weight:600;">Registrovanih članova na Gym portalu</div>
                    <div style="font-size:28px;font-weight:800;color:#1C1C1E;">{{ $clanovaCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="glass-card p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,55,95,0.1);display:flex;align-items:center;justify-content:center;">
                    <svg width="24" height="24" fill="none" stroke="#FF375F" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                </div>
                <div>
                    <div style="font-size:13px;color:#8E8E93;font-weight:600;">Ukupno obavijesti</div>
                    <div style="font-size:28px;font-weight:800;color:#1C1C1E;">{{ $obavijestiCount }}</div>
                </div>
            </div>
            <a href="{{ route('moderator.obavijesti') }}" class="btn btn-sm" style="background:rgba(255,55,95,0.1);color:#FF375F;font-weight:600;border-radius:10px;">
                Pregledaj obavijesti →
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="glass-card p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(48,209,88,0.1);display:flex;align-items:center;justify-content:center;">
                    <svg width="24" height="24" fill="none" stroke="#30D158" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                </div>
                <div>
                    <div style="font-size:13px;color:#8E8E93;font-weight:600;">Nadolazeći termini</div>
                    <div style="font-size:28px;font-weight:800;color:#1C1C1E;">{{ $terminiCount }}</div>
                </div>
            </div>
            <a href="{{ route('moderator.termini') }}" class="btn btn-sm" style="background:rgba(48,209,88,0.1);color:#30D158;font-weight:600;border-radius:10px;">
                Pregledaj termine →
            </a>
        </div>
    </div>
</div>
@endsection
