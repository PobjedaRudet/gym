@extends('member.layout')
@section('styles')
<style>
  /* ===== APPLE FITNESS MEMBER DASHBOARD ===== */
  .dash { max-width: 960px; }

  /* Hero banner */
  .dash-hero {
    background: linear-gradient(135deg, #111 0%, #1a1a1a 60%, #222 100%);
    border-radius: 22px;
    padding: 2rem 2.25rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    color: #fff;
  }
  .dash-hero::before {
    content: '';
    position: absolute;
    top: -80px; right: -40px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(255,55,95,0.12) 0%, transparent 65%);
    border-radius: 50%;
    pointer-events: none;
  }
  .dash-hero::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -20px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(48,209,88,0.06) 0%, transparent 65%);
    border-radius: 50%;
    pointer-events: none;
  }
  .dash-hero-top {
    display: flex; align-items: center; gap: 18px;
    position: relative; z-index: 1;
  }
  .dash-avatar {
    width: 72px; height: 72px; border-radius: 50%; object-fit: cover;
    border: 3px solid rgba(255,55,95,0.5);
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    flex-shrink: 0;
  }
  .dash-avatar-init {
    width: 72px; height: 72px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #FF375F, #FF6482);
    font-weight: 800; color: #fff; font-size: 22px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    flex-shrink: 0;
  }
  .dash-hero-info { flex: 1; min-width: 0; }
  .dash-hero-name {
    font-size: 1.35rem; font-weight: 800; margin: 0;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .dash-hero-email {
    font-size: 12px; color: rgba(255,255,255,0.45);
    margin-top: 2px; font-weight: 500;
  }
  .dash-hero-badges {
    display: flex; align-items: center; gap: 8px; margin-top: 8px;
    flex-wrap: wrap;
  }
  .dash-badge {
    font-size: 11px; font-weight: 700; padding: 4px 14px;
    border-radius: 20px; letter-spacing: 0.3px;
    display: inline-flex; align-items: center; gap: 5px;
  }
  .dash-badge-active { background: rgba(48,209,88,0.15); color: #30D158; }
  .dash-badge-inactive { background: rgba(255,55,95,0.15); color: #FF375F; }
  .dash-badge-date {
    background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.6);
    font-weight: 600;
  }
  .dash-hero-stats {
    display: flex; gap: 0; margin-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.06);
    padding-top: 1.25rem; position: relative; z-index: 1;
  }
  .dash-hero-stat {
    flex: 1; text-align: center;
    border-right: 1px solid rgba(255,255,255,0.06);
  }
  .dash-hero-stat:last-child { border-right: none; }
  .dash-hero-stat-val {
    font-size: 1.6rem; font-weight: 800; line-height: 1;
    color: #fff;
  }
  .dash-hero-stat-val small {
    font-size: 0.55em; font-weight: 600; color: rgba(255,255,255,0.35);
  }
  .dash-hero-stat-label {
    font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.35);
    text-transform: uppercase; letter-spacing: 0.8px; margin-top: 6px;
  }

  /* Week strip */
  .dash-week {
    display: flex; gap: 6px; margin-bottom: 1.5rem;
  }
  .dash-day {
    flex: 1; text-align: center;
    background: #fff; border-radius: 14px;
    padding: 10px 0 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.04);
    transition: all 0.2s;
  }
  .dash-day.today {
    border-color: rgba(255,55,95,0.3);
    box-shadow: 0 0 0 1px rgba(255,55,95,0.15), 0 2px 8px rgba(255,55,95,0.08);
  }
  .dash-day.attended { background: #FF375F; border-color: #FF375F; }
  .dash-day-lbl {
    font-size: 10px; font-weight: 700; color: #aaa;
    text-transform: uppercase; margin-bottom: 4px;
  }
  .dash-day.today .dash-day-lbl { color: #FF375F; }
  .dash-day.attended .dash-day-lbl { color: rgba(255,255,255,0.7); }
  .dash-day-num {
    font-size: 15px; font-weight: 800; color: #1a1a1a;
  }
  .dash-day.today .dash-day-num { color: #FF375F; }
  .dash-day.attended .dash-day-num { color: #fff; }
  .dash-day-dot {
    width: 5px; height: 5px; border-radius: 50%;
    margin: 4px auto 0; background: transparent;
  }
  .dash-day.attended .dash-day-dot { background: rgba(255,255,255,0.6); }

  /* Card */
  .dash-card {
    background: #fff;
    border-radius: 18px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.04);
  }
  .dash-card-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem;
  }
  .dash-card-title {
    font-size: 15px; font-weight: 800; color: #1a1a1a;
    display: flex; align-items: center; gap: 8px;
  }
  .dash-card-title .icon {
    width: 28px; height: 28px; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
  }

  /* Activity rings */
  .rings-wrap {
    display: flex; align-items: center; gap: 32px;
  }
  .rings-svg { flex-shrink: 0; }
  .rings-legend { flex: 1; }
  .ring-row {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,0.03);
  }
  .ring-row:last-child { border-bottom: none; }
  .ring-color {
    width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
  }
  .ring-info { flex: 1; }
  .ring-info-label { font-size: 13px; font-weight: 600; color: #444; }
  .ring-info-sub { font-size: 10px; color: #aaa; font-weight: 500; }
  .ring-val {
    font-size: 20px; font-weight: 800; text-align: right;
  }
  .ring-val small {
    font-size: 0.6em; font-weight: 600; color: #aaa;
  }

  /* Metric cards */
  .metric {
    background: #fff; border-radius: 18px;
    padding: 1.25rem; height: 100%;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.04);
    display: flex; flex-direction: column;
  }
  .metric-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px;
  }
  .metric-label {
    font-size: 12px; font-weight: 600; color: #999;
    text-transform: uppercase; letter-spacing: 0.5px;
  }
  .metric-val {
    font-size: 2.2rem; font-weight: 900; line-height: 1.1;
    margin-top: 2px;
  }
  .metric-val small { font-size: 0.5em; font-weight: 700; }
  .metric-footer { margin-top: auto; padding-top: 14px; }
  .metric-trend {
    display: inline-flex; align-items: center; gap: 3px;
    font-size: 11px; font-weight: 700; padding: 3px 10px;
    border-radius: 8px;
  }
  .metric-trend.up { background: rgba(48,209,88,0.08); color: #30D158; }
  .metric-trend.down { background: rgba(255,55,95,0.08); color: #FF375F; }
  .metric-trend.neutral { background: rgba(0,0,0,0.03); color: #999; }

  /* Mini bars */
  .mini-bars {
    display: flex; align-items: flex-end; gap: 3px; height: 44px;
    margin-top: 8px;
  }
  .mini-bar {
    flex: 1; border-radius: 3px; min-height: 4px;
    transition: height 0.5s ease;
  }

  /* Progress track */
  .prog-track {
    height: 6px; background: #f0f0f0; border-radius: 3px;
    overflow: hidden; margin-top: 6px;
  }
  .prog-fill {
    height: 100%; border-radius: 3px;
    transition: width 0.8s ease;
  }

  /* Info list */
  .info-item {
    display: flex; align-items: center; padding: 14px 0;
    border-bottom: 1px solid rgba(0,0,0,0.04);
  }
  .info-item:last-child { border-bottom: none; }
  .info-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-right: 14px; flex-shrink: 0;
  }
  .info-label { font-size: 13px; color: #777; font-weight: 500; }
  .info-val {
    margin-left: auto; font-size: 14px; font-weight: 600; color: #1a1a1a;
    text-align: right;
  }

  /* Membership row */
  .mem-row {
    display: flex; align-items: center; padding: 14px 0;
    border-bottom: 1px solid rgba(0,0,0,0.04);
  }
  .mem-row:last-child { border-bottom: none; }
  .mem-icon {
    width: 40px; height: 40px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    margin-right: 14px; flex-shrink: 0;
  }
  .mem-info { flex: 1; }
  .mem-label { font-size: 13px; font-weight: 500; color: #777; }
  .mem-sub { font-size: 10px; color: #bbb; font-weight: 500; }
  .mem-val {
    font-size: 14px; font-weight: 700; color: #1a1a1a;
    text-align: right;
  }

  /* Responsive */
  @media (max-width: 767.98px) {
    .dash-hero { padding: 1.5rem; border-radius: 18px; }
    .dash-hero-name { font-size: 1.15rem; }
    .dash-hero-stat-val { font-size: 1.3rem; }
    .dash-avatar, .dash-avatar-init { width: 56px; height: 56px; font-size: 18px; }
    .rings-wrap { flex-direction: column; gap: 16px; }
    .rings-legend { width: 100%; }
    .ring-row { justify-content: space-between; }
    .metric-val { font-size: 1.7rem; }
    .dash-day { padding: 8px 0 6px; border-radius: 10px; }
    .dash-day-num { font-size: 13px; }
  }
</style>
@endsection

@section('content')
@php
  $now = \Carbon\Carbon::now();
  $progresDolasci = $ciljDolazaka > 0 ? min(round(($trenutniMjesec / $ciljDolazaka) * 100), 100) : 0;
  $satTrenutni = floor(($vrijemeTrenutni->ukupno ?? 0) / 60);
  $minTrenutni = ($vrijemeTrenutni->ukupno ?? 0) % 60;
  $ciljSati = floor($ciljMinuta / 60);
  $progresSati = $ciljMinuta > 0 ? min(round((($vrijemeTrenutni->ukupno ?? 0) / $ciljMinuta) * 100), 100) : 0;
  $promjena = $prethodniMjesec > 0 ? round((($trenutniMjesec - $prethodniMjesec) / $prethodniMjesec) * 100) : ($trenutniMjesec > 0 ? 100 : 0);
  $prosjekTrenutni = $vrijemeTrenutni->prosjek ?? 0;
  $prosjekCilj = 60;
  $progresProsjek = $prosjekCilj > 0 ? min(round(($prosjekTrenutni / $prosjekCilj) * 100), 100) : 0;
  $danaDoIsteka = $istekClanarine ? \Carbon\Carbon::parse($istekClanarine)->diffInDays($now, false) * -1 : 0;
@endphp

<div class="dash">

  {{-- ========== HERO BANNER ========== --}}
  <div class="dash-hero">
    <div class="dash-hero-top">
      @if($member->image_path)
        <img src="{{ asset('images/'.$member->image_path) }}" alt="" class="dash-avatar">
      @else
        <div class="dash-avatar-init">{{ mb_substr($member->name,0,1) }}{{ mb_substr($member->surname,0,1) }}</div>
      @endif
      <div class="dash-hero-info">
        <h1 class="dash-hero-name">{{ $member->name }} {{ $member->surname }}</h1>
        <div class="dash-hero-email">{{ $member->email }}</div>
        <div class="dash-hero-badges">
          @if($aktivanClan)
            <span class="dash-badge dash-badge-active">
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
              Aktivan član
            </span>
          @else
            <span class="dash-badge dash-badge-inactive">
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
              Neaktivan
            </span>
          @endif
          @if($istekClanarine)
            <span class="dash-badge dash-badge-date">
              do {{ \Carbon\Carbon::parse($istekClanarine)->format('d.m.Y') }}
            </span>
          @endif
        </div>
      </div>
    </div>
    <div class="dash-hero-stats">
      <div class="dash-hero-stat">
        <div class="dash-hero-stat-val">{{ $ukupnoDolazaka }}</div>
        <div class="dash-hero-stat-label">Ukupno dolazaka</div>
      </div>
      <div class="dash-hero-stat">
        <div class="dash-hero-stat-val">{{ floor($vrijemeUkupno->ukupno / 60) }}<small>h</small></div>
        <div class="dash-hero-stat-label">Ukupno sati</div>
      </div>
      <div class="dash-hero-stat">
        <div class="dash-hero-stat-val">{{ floor($vrijemeUkupno->prosjek) }}<small>min</small></div>
        <div class="dash-hero-stat-label">Prosjek treninga</div>
      </div>
      <div class="dash-hero-stat">
        <div class="dash-hero-stat-val">{{ $trenutniMjesec }}</div>
        <div class="dash-hero-stat-label">Ovaj mjesec</div>
      </div>
    </div>
  </div>

  {{-- ========== WEEKLY STRIP ========== --}}
  <div class="dash-week">
    @foreach($sedmicniDani as $dan)
    <div class="dash-day {{ $dan['today'] ? 'today' : '' }} {{ $dan['count'] > 0 ? 'attended' : '' }}">
      <div class="dash-day-lbl">{{ $dan['label'] }}</div>
      <div class="dash-day-num">{{ $dan['date'] }}</div>
      <div class="dash-day-dot"></div>
    </div>
    @endforeach
  </div>

  {{-- ========== ACTIVITY RINGS ========== --}}
  <div class="dash-card">
    <div class="dash-card-head">
      <div class="dash-card-title">
        <span class="icon" style="background:rgba(255,55,95,0.08);">
          <svg width="15" height="15" fill="none" stroke="#FF375F" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
        </span>
        Mjesečni ciljevi
      </div>
      <span style="font-size:11px;font-weight:600;color:#bbb;">{{ $now->translatedFormat('F Y') }}</span>
    </div>
    <div class="rings-wrap">
      <div class="rings-svg">
        @php
          $sz = 170; $cx = $sz / 2;
          $r1 = 72; $r2 = 55; $r3 = 38;
          $sw = 14;
          $c1 = 2 * M_PI * $r1; $c2 = 2 * M_PI * $r2; $c3 = 2 * M_PI * $r3;
          $o1 = $c1 - ($progresDolasci / 100) * $c1;
          $o2 = $c2 - ($progresSati / 100) * $c2;
          $o3 = $c3 - ($progresProsjek / 100) * $c3;
        @endphp
        <svg width="{{ $sz }}" height="{{ $sz }}" viewBox="0 0 {{ $sz }} {{ $sz }}">
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r1 }}" fill="none" stroke="rgba(255,55,95,0.12)" stroke-width="{{ $sw }}"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r2 }}" fill="none" stroke="rgba(48,209,88,0.12)" stroke-width="{{ $sw }}"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r3 }}" fill="none" stroke="rgba(90,200,250,0.12)" stroke-width="{{ $sw }}"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r1 }}" fill="none" stroke="#FF375F" stroke-width="{{ $sw }}" stroke-linecap="round" stroke-dasharray="{{ $c1 }}" stroke-dashoffset="{{ $o1 }}" transform="rotate(-90 {{ $cx }} {{ $cx }})" style="transition:stroke-dashoffset 1.2s ease;"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r2 }}" fill="none" stroke="#30D158" stroke-width="{{ $sw }}" stroke-linecap="round" stroke-dasharray="{{ $c2 }}" stroke-dashoffset="{{ $o2 }}" transform="rotate(-90 {{ $cx }} {{ $cx }})" style="transition:stroke-dashoffset 1.2s ease;"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r3 }}" fill="none" stroke="#5AC8FA" stroke-width="{{ $sw }}" stroke-linecap="round" stroke-dasharray="{{ $c3 }}" stroke-dashoffset="{{ $o3 }}" transform="rotate(-90 {{ $cx }} {{ $cx }})" style="transition:stroke-dashoffset 1.2s ease;"/>
          <text x="{{ $cx }}" y="{{ $cx - 6 }}" text-anchor="middle" font-size="22" font-weight="900" fill="#1a1a1a" style="font-family:inherit;">{{ $progresDolasci }}%</text>
          <text x="{{ $cx }}" y="{{ $cx + 10 }}" text-anchor="middle" font-size="9" font-weight="600" fill="#aaa" style="font-family:inherit;text-transform:uppercase;letter-spacing:1px;">OSTVARENO</text>
        </svg>
      </div>
      <div class="rings-legend">
        <div class="ring-row">
          <span class="ring-color" style="background:#FF375F;"></span>
          <div class="ring-info">
            <div class="ring-info-label">Dolasci</div>
            <div class="ring-info-sub">Cilj: {{ $ciljDolazaka }} posjeta</div>
          </div>
          <div class="ring-val" style="color:#FF375F;">{{ $trenutniMjesec }}<small>/{{ $ciljDolazaka }}</small></div>
        </div>
        <div class="ring-row">
          <span class="ring-color" style="background:#30D158;"></span>
          <div class="ring-info">
            <div class="ring-info-label">Vrijeme</div>
            <div class="ring-info-sub">Cilj: {{ $ciljSati }} sati</div>
          </div>
          <div class="ring-val" style="color:#30D158;">{{ $satTrenutni }}<small>h</small></div>
        </div>
        <div class="ring-row">
          <span class="ring-color" style="background:#5AC8FA;"></span>
          <div class="ring-info">
            <div class="ring-info-label">Prosjek po treningu</div>
            <div class="ring-info-sub">Cilj: {{ $prosjekCilj }} minuta</div>
          </div>
          <div class="ring-val" style="color:#5AC8FA;">{{ floor($prosjekTrenutni) }}<small>min</small></div>
        </div>
      </div>
    </div>
  </div>

  {{-- ========== METRIC CARDS ========== --}}
  <div class="row g-3 mb-3">
    <div class="col-md-4 col-6">
      <div class="metric">
        <div class="metric-icon" style="background:rgba(255,55,95,0.08);">
          <svg width="18" height="18" fill="none" stroke="#FF375F" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
        </div>
        <div class="metric-label">Dolasci</div>
        <div class="metric-val" style="color:#FF375F;">{{ $trenutniMjesec }}</div>
        <div class="metric-footer">
          @if($promjena > 0)
            <span class="metric-trend up">
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 15l-6-6-6 6"/></svg>
              +{{ $promjena }}%
            </span>
          @elseif($promjena < 0)
            <span class="metric-trend down">
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
              {{ $promjena }}%
            </span>
          @else
            <span class="metric-trend neutral">—</span>
          @endif
          <span style="font-size:10px;color:#bbb;margin-left:3px;">vs prethodni</span>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-6">
      <div class="metric">
        <div class="metric-icon" style="background:rgba(48,209,88,0.08);">
          <svg width="18" height="18" fill="none" stroke="#30D158" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <div class="metric-label">Vrijeme ovaj mjesec</div>
        <div class="metric-val" style="color:#30D158;">{{ $satTrenutni }}<small>h {{ $minTrenutni }}m</small></div>
        <div class="metric-footer">
          <div style="display:flex;justify-content:space-between;font-size:10px;font-weight:600;color:#bbb;margin-bottom:4px;">
            <span>Cilj</span>
            <span style="color:#30D158;">{{ $progresSati }}%</span>
          </div>
          <div class="prog-track">
            <div class="prog-fill" style="width:{{ $progresSati }}%;background:linear-gradient(90deg,#30D158,#4ADE80);"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-12">
      <div class="metric">
        <div class="metric-icon" style="background:rgba(90,200,250,0.08);">
          <svg width="18" height="18" fill="none" stroke="#5AC8FA" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>
        </div>
        <div class="metric-label">Zadnjih 6 mjeseci</div>
        <div class="mini-bars" style="margin-top:4px;">
          @php $maxMini = max(array_column($mjesecniMini, 'dolasci')) ?: 1; @endphp
          @foreach($mjesecniMini as $mm)
            @php $barH = max(4, round(($mm['dolasci'] / $maxMini) * 40)); @endphp
            <div style="flex:1;text-align:center;">
              <div class="mini-bar" style="height:{{ $barH }}px;background:{{ $mm['tekuci'] ? '#5AC8FA' : 'rgba(90,200,250,0.18)' }};margin:0 auto;border-radius:3px;"></div>
              <div style="font-size:9px;font-weight:600;color:{{ $mm['tekuci'] ? '#5AC8FA' : '#ccc' }};margin-top:4px;">{{ $mm['label'] }}</div>
            </div>
          @endforeach
        </div>
        <div class="metric-footer" style="padding-top:8px;">
          <span style="font-size:11px;color:#aaa;font-weight:500;">Prosjek: {{ floor($vrijemeUkupno->prosjek) }} min/trening</span>
        </div>
      </div>
    </div>
  </div>

  {{-- ========== MEMBERSHIP ========== --}}
  <div class="dash-card">
    <div class="dash-card-head">
      <div class="dash-card-title">
        <span class="icon" style="background:rgba(255,55,95,0.08);">
          <svg width="15" height="15" fill="none" stroke="#FF375F" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </span>
        Članstvo
      </div>
      @if($aktivanClan && $danaDoIsteka > 0 && $danaDoIsteka <= 14)
        <span style="font-size:11px;font-weight:700;color:#FF9F0A;background:rgba(255,159,10,0.08);padding:3px 10px;border-radius:8px;">
          Ističe za {{ $danaDoIsteka }} dana
        </span>
      @endif
    </div>
    <div class="mem-row">
      <div class="mem-icon" style="background:{{ $aktivanClan ? 'rgba(48,209,88,0.08)' : 'rgba(255,55,95,0.08)' }};">
        <svg width="20" height="20" fill="none" stroke="{{ $aktivanClan ? '#30D158' : '#FF375F' }}" stroke-width="2" viewBox="0 0 24 24">
          @if($aktivanClan)
            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/>
          @else
            <circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/>
          @endif
        </svg>
      </div>
      <div class="mem-info">
        <div class="mem-label">Status članstva</div>
      </div>
      <div class="mem-val" style="color:{{ $aktivanClan ? '#30D158' : '#FF375F' }};">
        {{ $aktivanClan ? 'Aktivno' : 'Neaktivno' }}
      </div>
    </div>
    <div class="mem-row">
      <div class="mem-icon" style="background:rgba(255,159,10,0.06);">
        <svg width="20" height="20" fill="none" stroke="#FF9F0A" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
      </div>
      <div class="mem-info">
        <div class="mem-label">Članarina važi do</div>
      </div>
      <div class="mem-val">
        {{ $istekClanarine ? \Carbon\Carbon::parse($istekClanarine)->format('d.m.Y') : '—' }}
      </div>
    </div>
    @if($member->register_date)
    <div class="mem-row">
      <div class="mem-icon" style="background:rgba(90,200,250,0.06);">
        <svg width="20" height="20" fill="none" stroke="#5AC8FA" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>
      </div>
      <div class="mem-info">
        <div class="mem-label">Član od</div>
        <div class="mem-sub">{{ \Carbon\Carbon::parse($member->register_date)->diffForHumans() }}</div>
      </div>
      <div class="mem-val">
        {{ \Carbon\Carbon::parse($member->register_date)->format('d.m.Y') }}
      </div>
    </div>
    @endif
  </div>

  {{-- ========== PERSONAL INFO ========== --}}
  <div class="dash-card">
    <div class="dash-card-head">
      <div class="dash-card-title">
        <span class="icon" style="background:rgba(90,200,250,0.08);">
          <svg width="15" height="15" fill="none" stroke="#5AC8FA" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </span>
        Lični podaci
      </div>
      <a href="{{ route('member.password') }}" style="font-size:12px;font-weight:600;color:#5AC8FA;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
        Promijeni lozinku
      </a>
    </div>
    <div class="info-item">
      <div class="info-icon" style="background:rgba(142,142,147,0.06);">
        <svg width="16" height="16" fill="none" stroke="#8E8E93" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </div>
      <span class="info-label">Ime i prezime</span>
      <span class="info-val">{{ $member->name.' '.$member->surname }}</span>
    </div>
    <div class="info-item">
      <div class="info-icon" style="background:rgba(142,142,147,0.06);">
        <svg width="16" height="16" fill="none" stroke="#8E8E93" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
      </div>
      <span class="info-label">Mobitel</span>
      <span class="info-val">{{ $member->mobile ?? '—' }}</span>
    </div>
    <div class="info-item">
      <div class="info-icon" style="background:rgba(142,142,147,0.06);">
        <svg width="16" height="16" fill="none" stroke="#8E8E93" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
      </div>
      <span class="info-label">E-mail</span>
      <span class="info-val">{{ $member->email ?? '—' }}</span>
    </div>
    <div class="info-item">
      <div class="info-icon" style="background:rgba(142,142,147,0.06);">
        <svg width="16" height="16" fill="none" stroke="#8E8E93" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
      </div>
      <span class="info-label">Adresa</span>
      <span class="info-val">{{ $member->street ?? '—' }}{{ $member->city ? ', '.$member->city : '' }}</span>
    </div>
  </div>

</div>
@endsection
