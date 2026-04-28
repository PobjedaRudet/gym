@extends('member.layout')
@section('styles')
<style>
  /* ===== APPLE FITNESS MEMBER DASHBOARD ===== */
  body { background: #0a0a0a; color: #f4f4f5; }
  .main-content { background: #0a0a0a; }
  .dash { max-width: 960px; }

  /* Hero banner */
  .dash-hero {
    background: linear-gradient(135deg, #0f0f10 0%, #17171a 58%, #202024 100%);
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
    background: radial-gradient(circle, rgba(255,184,0,0.14) 0%, transparent 65%);
    border-radius: 50%;
    pointer-events: none;
  }
  .dash-hero::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -20px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 65%);
    border-radius: 50%;
    pointer-events: none;
  }
  .dash-hero-top {
    display: flex; align-items: center; gap: 18px;
    position: relative; z-index: 1;
  }
  .dash-avatar-stack {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
  }
  .dash-avatar {
    width: 92px; height: 92px; border-radius: 50%; object-fit: cover;
    border: 3px solid rgba(255,255,255,0.9);
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    flex-shrink: 0;
  }
  .dash-avatar-init {
    width: 92px; height: 92px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #ffb800, #ffd66b);
    font-weight: 800; color: #fff; font-size: 28px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    flex-shrink: 0;
  }
  .dash-avatar-form {
    width: 100%;
  }
  .dash-avatar-input {
    display: none;
  }
  .dash-avatar-btn {
    width: 100%;
    border: 1px solid rgba(255,255,255,0.16);
    background: rgba(255,255,255,0.08);
    color: #f4f4f5;
    border-radius: 999px;
    padding: 8px 12px;
    font-size: 11px;
    font-weight: 700;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }
  .dash-avatar-btn:hover {
    background: rgba(255,255,255,0.14);
    border-color: rgba(255,255,255,0.28);
  }
  .dash-avatar-help {
    margin-top: 6px;
    font-size: 10px;
    color: rgba(255,255,255,0.45);
    text-align: center;
  }
  .dash-avatar-status {
    margin-top: 6px;
    font-size: 10px;
    color: #ffdd8a;
    text-align: center;
    display: none;
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
  .dash-badge-active { background: rgba(255,184,0,0.16); color: #ffdd8a; }
  .dash-badge-inactive { background: rgba(161,161,170,0.2); color: #d4d4d8; }
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
    background: #141417; border-radius: 14px;
    padding: 10px 0 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    border: 1px solid #2c2c32;
    transition: all 0.2s;
  }
  .dash-day.today {
    border-color: rgba(255,184,0,0.38);
    box-shadow: 0 0 0 1px rgba(255,184,0,0.22), 0 2px 8px rgba(255,184,0,0.15);
  }
  .dash-day.attended { background: #ffb800; border-color: #ffb800; }
  .dash-day-lbl {
    font-size: 10px; font-weight: 700; color: #8b8b93;
    text-transform: uppercase; margin-bottom: 4px;
  }
  .dash-day.today .dash-day-lbl { color: #ffd66b; }
  .dash-day.attended .dash-day-lbl { color: rgba(255,255,255,0.7); }
  .dash-day-num {
    font-size: 15px; font-weight: 800; color: #f1f1f3;
  }
  .dash-day.today .dash-day-num { color: #ffd66b; }
  .dash-day.attended .dash-day-num { color: #111111; }
  .dash-day-dot {
    width: 5px; height: 5px; border-radius: 50%;
    margin: 4px auto 0; background: transparent;
  }
  .dash-day.attended .dash-day-dot { background: rgba(255,255,255,0.6); }

  /* Card */
  .dash-card {
    background: #111114;
    border-radius: 18px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.22);
    border: 1px solid #2d2d33;
  }
  .dash-card-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem;
  }
  .dash-card-title {
    font-size: 15px; font-weight: 800; color: #f5f5f5;
    display: flex; align-items: center; gap: 8px;
  }
  .monthly-goals-title {
    font-size: 20px;
    letter-spacing: 0.2px;
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
  .ring-info-label { font-size: 16px; font-weight: 700; color: #d4d4d8; }
  .ring-info-sub { font-size: 13px; color: #a1a1aa; font-weight: 600; }
  .ring-val {
    font-size: 26px; font-weight: 900; text-align: right;
  }
  .ring-val small {
    font-size: 0.65em; font-weight: 700; color: #a1a1aa;
  }

  /* Metric cards */
  .metric {
    background: #111114; border-radius: 18px;
    padding: 1.25rem; height: 100%;
    box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    border: 1px solid #2d2d33;
    display: flex; flex-direction: column;
  }
  .metric-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px;
  }
  .metric-label {
    font-size: 12px; font-weight: 600; color: #a1a1aa;
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
  .metric-trend.up { background: rgba(255,184,0,0.15); color: #ffdd8a; }
  .metric-trend.down { background: rgba(161,161,170,0.2); color: #d4d4d8; }
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
    height: 6px; background: #2b2b30; border-radius: 3px;
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
  .info-label { font-size: 13px; color: #a1a1aa; font-weight: 500; }
  .info-val {
    margin-left: auto; font-size: 14px; font-weight: 600; color: #f4f4f5;
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
  .membership-title { font-size: 21px; letter-spacing: 0.2px; }
  .mem-label { font-size: 16px; font-weight: 600; color: #d4d4d8; }
  .mem-sub { font-size: 13px; color: #a1a1aa; font-weight: 600; }
  .mem-val {
    font-size: 19px; font-weight: 800; color: #f4f4f5;
    text-align: right;
  }

  /* Responsive */
  @media (max-width: 767.98px) {
    .dash-hero { padding: 1.5rem; border-radius: 18px; }
    .dash-hero-name { font-size: 1.15rem; }
    .dash-hero-stat-val { font-size: 1.3rem; }
    .dash-avatar, .dash-avatar-init { width: 68px; height: 68px; font-size: 22px; }
    .dash-avatar-stack { width: 84px; }
    .dash-avatar-btn { font-size: 10px; padding: 7px 8px; }
    .rings-wrap { flex-direction: column; gap: 16px; }
    .rings-legend { width: 100%; }
    .ring-row { justify-content: space-between; }
    .ring-info-label { font-size: 14px; }
    .ring-info-sub { font-size: 12px; }
    .ring-val { font-size: 22px; }
    .membership-title { font-size: 18px; }
    .mem-label { font-size: 14px; }
    .mem-sub { font-size: 12px; }
    .mem-val { font-size: 16px; }
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
  $prosjekCilj = 90;
  $progresProsjek = $prosjekCilj > 0 ? min(round(($prosjekTrenutni / $prosjekCilj) * 100), 100) : 0;
  $danaDoIsteka = $istekClanarine ? \Carbon\Carbon::parse($istekClanarine)->diffInDays($now, false) * -1 : 0;
@endphp

<div class="dash">

  @if(session('success'))
    <div class="dash-card" style="padding:0.95rem 1rem;border-color:rgba(255,184,0,0.26);background:linear-gradient(160deg, rgba(255,184,0,0.12), rgba(17,17,20,0.96));color:#f4f4f5;">
      {{ session('success') }}
    </div>
  @endif

  @if(session('photo_error') || $errors->has('profile_image'))
    <div class="dash-card" style="padding:0.95rem 1rem;border-color:rgba(220,38,38,0.35);background:linear-gradient(160deg, rgba(220,38,38,0.10), rgba(17,17,20,0.96));color:#fca5a5;">
      {{ session('photo_error') ?? $errors->first('profile_image') }}
    </div>
  @endif

  {{-- ========== HERO BANNER ========== --}}
  <div class="dash-hero">
    <div class="dash-hero-top">
      <div class="dash-avatar-stack">
        @if($member->image_path)
          <img src="{{ asset('images/'.$member->image_path) }}" alt="" class="dash-avatar">
        @else
          <div class="dash-avatar-init">{{ mb_substr($member->name,0,1) }}{{ mb_substr($member->surname,0,1) }}</div>
        @endif

        <form method="POST" action="{{ route('member.profile.photo') }}" enctype="multipart/form-data" class="dash-avatar-form">
          @csrf
          <input type="file" name="profile_image" id="profile_image" class="dash-avatar-input" accept="image/png,image/jpeg,image/jpg,image/webp">
          <button type="button" class="dash-avatar-btn" onclick="openProfileImagePicker()">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            Promijeni sliku
          </button>
          <div class="dash-avatar-help">JPG, PNG ili WEBP, automatski do 1 MB</div>
          <div class="dash-avatar-status" id="profile-image-status">Upload u toku...</div>
        </form>
      </div>

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
        <div class="dash-hero-stat-val">{{ floor($vrijemeUkupno->ukupno / 60) }} <small>h</small></div>
        <div class="dash-hero-stat-label">Ukupno sati</div>
      </div>
      <div class="dash-hero-stat">
        <div class="dash-hero-stat-val">{{ floor($vrijemeUkupno->prosjek) }} <small>min</small></div>
        <div class="dash-hero-stat-label">Prosjek treninga</div>
      </div>
      <div class="dash-hero-stat">
        <div class="dash-hero-stat-val">{{ $trenutniMjesec }}</div>
        <div class="dash-hero-stat-label">Ovaj mjesec</div>
      </div>
    </div>
  </div>

  @error('profile_image')
    <div class="dash-card" style="padding:0.95rem 1rem;border-color:rgba(255,255,255,0.12);background:#151518;color:#d4d4d8;">
      {{ $message }}
    </div>
  @enderror

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
      <div class="dash-card-title monthly-goals-title">
        <span class="icon" style="background:rgba(255,184,0,0.14);">
          <svg width="15" height="15" fill="none" stroke="#ffb800" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
        </span>
        Mjesečni ciljevi
      </div>
      <span style="font-size:11px;font-weight:600;color:#a1a1aa;">{{ $now->translatedFormat('F Y') }}</span>
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
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r1 }}" fill="none" stroke="rgba(255,184,0,0.16)" stroke-width="{{ $sw }}"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r2 }}" fill="none" stroke="rgba(255,255,255,0.12)" stroke-width="{{ $sw }}"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r3 }}" fill="none" stroke="rgba(161,161,170,0.18)" stroke-width="{{ $sw }}"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r1 }}" fill="none" stroke="#ffb800" stroke-width="{{ $sw }}" stroke-linecap="round" stroke-dasharray="{{ $c1 }}" stroke-dashoffset="{{ $o1 }}" transform="rotate(-90 {{ $cx }} {{ $cx }})" style="transition:stroke-dashoffset 1.2s ease;"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r2 }}" fill="none" stroke="#f4f4f5" stroke-width="{{ $sw }}" stroke-linecap="round" stroke-dasharray="{{ $c2 }}" stroke-dashoffset="{{ $o2 }}" transform="rotate(-90 {{ $cx }} {{ $cx }})" style="transition:stroke-dashoffset 1.2s ease;"/>
          <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r3 }}" fill="none" stroke="#a1a1aa" stroke-width="{{ $sw }}" stroke-linecap="round" stroke-dasharray="{{ $c3 }}" stroke-dashoffset="{{ $o3 }}" transform="rotate(-90 {{ $cx }} {{ $cx }})" style="transition:stroke-dashoffset 1.2s ease;"/>
          <text x="{{ $cx }}" y="{{ $cx - 6 }}" text-anchor="middle" font-size="22" font-weight="900" fill="#f4f4f5" style="font-family:inherit;">{{ $progresDolasci }}%</text>
          <text x="{{ $cx }}" y="{{ $cx + 10 }}" text-anchor="middle" font-size="9" font-weight="600" fill="#8b8b93" style="font-family:inherit;text-transform:uppercase;letter-spacing:1px;">OSTVARENO</text>
        </svg>
      </div>
      <div class="rings-legend">
        <div class="ring-row">
          <span class="ring-color" style="background:#ffb800;"></span>
          <div class="ring-info">
            <div class="ring-info-label">Dolasci</div>
            <div class="ring-info-sub">Cilj: {{ $ciljDolazaka }} posjeta</div>
          </div>
          <div class="ring-val" style="color:#ffdd8a;">{{ $trenutniMjesec }}<small>/{{ $ciljDolazaka }}</small></div>
        </div>
        <div class="ring-row">
          <span class="ring-color" style="background:#f4f4f5;"></span>
          <div class="ring-info">
            <div class="ring-info-label">Vrijeme</div>
            <div class="ring-info-sub">Cilj: {{ $ciljSati }} sati</div>
          </div>
          <div class="ring-val" style="color:#f4f4f5;">{{ $satTrenutni }}<small>h</small></div>
        </div>
        <div class="ring-row">
          <span class="ring-color" style="background:#a1a1aa;"></span>
          <div class="ring-info">
            <div class="ring-info-label">Prosjek po treningu</div>
            <div class="ring-info-sub">Cilj: {{ $prosjekCilj }} minuta</div>
          </div>
          <div class="ring-val" style="color:#d4d4d8;">{{ floor($prosjekTrenutni) }}<small>min</small></div>
        </div>
      </div>
    </div>
  </div>

  {{-- ========== METRIC CARDS ========== --}}
  <div class="row g-3 mb-3">
    <div class="col-md-4 col-6">
      <div class="metric">
        <div class="metric-icon" style="background:rgba(255,184,0,0.14);">
          <svg width="18" height="18" fill="none" stroke="#ffb800" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
        </div>
        <div class="metric-label">Dolasci</div>
        <div class="metric-val" style="color:#ffdd8a;">{{ $trenutniMjesec }}</div>
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
          <span style="font-size:10px;color:#8b8b93;margin-left:3px;">vs prethodni</span>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-6">
      <div class="metric">
        <div class="metric-icon" style="background:rgba(255,255,255,0.14);">
          <svg width="18" height="18" fill="none" stroke="#f4f4f5" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <div class="metric-label">Vrijeme ovaj mjesec</div>
        <div class="metric-val" style="color:#f4f4f5;">{{ $satTrenutni }}<small>h {{ $minTrenutni }}m</small></div>
        <div class="metric-footer">
          <div style="display:flex;justify-content:space-between;font-size:10px;font-weight:600;color:#8b8b93;margin-bottom:4px;">
            <span>Cilj</span>
            <span style="color:#f4f4f5;">{{ $progresSati }}%</span>
          </div>
          <div class="prog-track">
            <div class="prog-fill" style="width:{{ $progresSati }}%;background:linear-gradient(90deg,#f4f4f5,#d4d4d8);"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-12">
      <div class="metric">
        <div class="metric-icon" style="background:rgba(161,161,170,0.2);">
          <svg width="18" height="18" fill="none" stroke="#a1a1aa" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>
        </div>
        <div class="metric-label">Zadnjih 6 mjeseci</div>
        <div class="mini-bars" style="margin-top:4px;">
          @php $maxMini = max(array_column($mjesecniMini, 'dolasci')) ?: 1; @endphp
          @foreach($mjesecniMini as $mm)
            @php $barH = max(4, round(($mm['dolasci'] / $maxMini) * 40)); @endphp
            <div style="flex:1;text-align:center;">
              <div class="mini-bar" style="height:{{ $barH }}px;background:{{ $mm['tekuci'] ? '#ffb800' : 'rgba(161,161,170,0.25)' }};margin:0 auto;border-radius:3px;"></div>
                <div style="font-size:9px;font-weight:600;color:{{ $mm['tekuci'] ? '#ffdd8a' : '#8b8b93' }};margin-top:4px;">{{ $mm['label'] }}</div>
            </div>
          @endforeach
        </div>
        <div class="metric-footer" style="padding-top:8px;">
            <span style="font-size:11px;color:#8b8b93;font-weight:500;">Prosjek: {{ floor($vrijemeUkupno->prosjek) }} min/trening</span>
        </div>
      </div>
    </div>
  </div>

  {{-- ========== MEMBERSHIP ========== --}}
  <div class="dash-card">
    <div class="dash-card-head">
      <div class="dash-card-title membership-title">
        <span class="icon" style="background:rgba(255,184,0,0.14);">
          <svg width="15" height="15" fill="none" stroke="#ffb800" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </span>
        Članstvo
      </div>
      @if($aktivanClan && $danaDoIsteka > 0 && $danaDoIsteka <= 14)
        <span style="font-size:11px;font-weight:700;color:#ffdd8a;background:rgba(255,184,0,0.14);padding:3px 10px;border-radius:8px;">
          Ističe za {{ $danaDoIsteka }} dana
        </span>
      @endif
    </div>
    <div class="mem-row">
      <div class="mem-icon" style="background:{{ $aktivanClan ? 'rgba(255,184,0,0.14)' : 'rgba(161,161,170,0.2)' }};">
        <svg width="20" height="20" fill="none" stroke="{{ $aktivanClan ? '#ffb800' : '#d4d4d8' }}" stroke-width="2" viewBox="0 0 24 24">
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
      <div class="mem-val" style="color:{{ $aktivanClan ? '#ffdd8a' : '#d4d4d8' }};">
        {{ $aktivanClan ? 'Aktivno' : 'Neaktivno' }}
      </div>
    </div>
    <div class="mem-row">
      <div class="mem-icon" style="background:rgba(255,184,0,0.14);">
        <svg width="20" height="20" fill="none" stroke="#ffb800" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
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
      <div class="mem-icon" style="background:rgba(161,161,170,0.2);">
        <svg width="20" height="20" fill="none" stroke="#a1a1aa" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>
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
        <span class="icon" style="background:rgba(161,161,170,0.2);">
          <svg width="15" height="15" fill="none" stroke="#a1a1aa" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </span>
        Lični podaci
      </div>
      <a href="{{ route('member.password') }}" style="font-size:12px;font-weight:600;color:#ffdd8a;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
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

@section('scripts')
<script>
function openProfileImagePicker() {
  var input = document.getElementById('profile_image');
  if (input) {
    input.click();
  }
}

document.addEventListener('DOMContentLoaded', function () {
  var input = document.getElementById('profile_image');
  var status = document.getElementById('profile-image-status');

  if (!input) {
    return;
  }

  input.addEventListener('change', function () {
    if (!input.files || !input.files.length) {
      return;
    }

    if (status) {
      status.style.display = 'block';
    }

    input.form.submit();
  });
});
</script>
@endsection
