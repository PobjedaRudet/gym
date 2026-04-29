@extends('layouts.report')
@section('content')
<style>
  .profile-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
  }
  .profile-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(102,126,234,0.15) 0%, transparent 70%);
    border-radius: 50%;
  }
  .profile-avatar {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(255,255,255,0.2);
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
  }
  .profile-name {
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
  }
  .profile-badge {
    display: inline-block;
    font-size: 13px;
    font-weight: 700;
    padding: 6px 20px;
    border-radius: 30px;
    letter-spacing: 0.5px;
  }
  .badge-aktivan { background: rgba(13,110,253,0.2); color: #6ea8fe; border: 1px solid rgba(13,110,253,0.3); }
  .badge-neaktivan { background: rgba(220,53,69,0.2); color: #f1aeb5; border: 1px solid rgba(220,53,69,0.3); }
  .info-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
  }
  .info-card .card-header-custom {
    padding: 1rem 1.5rem;
    font-weight: 700;
    font-size: 15px;
    color: #1a1a2e;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .info-row {
    display: flex;
    align-items: center;
    padding: 14px 1.5rem;
    border-bottom: 1px solid #f5f5f5;
    transition: background 0.15s;
  }
  .info-row:last-child { border-bottom: none; }
  .info-row:hover { background: #f8f9ff; }
  .info-label {
    font-size: 13px;
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    min-width: 140px;
  }
  .info-value {
    font-size: 15px;
    font-weight: 500;
    color: #1a1a2e;
  }
  .stat-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    text-align: center;
    padding: 1.5rem 1rem;
    height: 100%;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
  }
  .stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
  }
  .stat-label {
    font-size: 11px;
    font-weight: 700;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 4px;
  }
  .stat-value {
    font-size: 1.6rem;
    font-weight: 800;
    color: #1a1a2e;
    margin: 0;
    line-height: 1.2;
  }
  .stat-sub {
    font-size: 12px;
    color: #6c757d;
    font-weight: 500;
    margin-top: 4px;
  }
  .section-title {
    font-weight: 700;
    font-size: 16px;
    color: #1a1a2e;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .section-title .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
  }

  /* ===== Mobile responsive ===== */
  @media (max-width: 767.98px) {
    .profile-hero {
      padding: 1.25rem;
    }
    .profile-hero .row {
      flex-direction: column;
      text-align: center;
    }
    .profile-hero .col-auto,
    .profile-hero .col {
      width: 100%;
      flex: 0 0 100%;
    }
    .profile-avatar {
      width: 90px;
      height: 90px;
      margin-bottom: 0.75rem;
    }
    .profile-name {
      font-size: 1.3rem;
    }
    .profile-hero .d-flex.align-items-center.gap-3 {
      justify-content: center;
      gap: 8px !important;
    }
    .profile-hero .d-flex span {
      font-size: 12px !important;
    }
    .btn-back-mobile {
      display: inline-flex !important;
      margin-top: 1rem;
    }
    .info-row {
      flex-direction: column;
      align-items: flex-start;
      padding: 10px 1rem;
      gap: 2px;
    }
    .info-label {
      min-width: unset;
      font-size: 11px;
    }
    .info-value {
      font-size: 14px;
    }
    .stat-value {
      font-size: 1.25rem;
    }
    .stat-icon {
      width: 42px;
      height: 42px;
    }
    .stat-card {
      padding: 1rem 0.75rem;
    }
    .year-table-wrap table {
      font-size: 11px;
    }
    .year-table-wrap th,
    .year-table-wrap td {
      padding: 6px 4px !important;
    }
    .year-table-wrap .hide-mobile {
      display: none !important;
    }
  }
  @media (max-width: 575.98px) {
    .stat-card {
      padding: 0.75rem 0.5rem;
    }
    .stat-value {
      font-size: 1.1rem;
    }
    .section-title {
      font-size: 14px;
    }
    .year-table-wrap table {
      font-size: 10px;
    }
  }
</style>

<div class="container" style="max-width:1100px;padding-top:1.5rem;padding-bottom:2rem;">

  @php
    $ciljSatiPrikaz = fmod(round($ciljMinuta / 60, 1), 1.0) === 0.0 ? number_format(round($ciljMinuta / 60, 1), 0) : number_format(round($ciljMinuta / 60, 1), 1);
  @endphp

  @if(session('success'))
    <div style="margin-bottom:1rem;padding:0.85rem 1rem;border-radius:12px;background:#ecfdf3;border:1px solid #a7f3d0;color:#065f46;font-weight:600;">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div style="margin-bottom:1rem;padding:0.85rem 1rem;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;font-weight:600;">
      {{ $errors->first() }}
    </div>
  @endif

  <!-- Hero profil -->
  <div class="profile-hero">
    <div class="row align-items-center">
      <div class="col-auto">
        <?php $image = $member->image_path; ?>
        <img src="{{ asset("images/{$image}") }}" alt="avatar" class="profile-avatar">
      </div>
      <div class="col">
        <p class="profile-name">{{ $member->name.' '.$member->surname }}</p>
        <div class="d-flex align-items-center gap-3 mt-2 flex-wrap">
          @if($aktivanClan)
            <span class="profile-badge badge-aktivan">Aktivan</span>
          @else
            <span class="profile-badge badge-neaktivan">Neaktivan</span>
          @endif
          <span style="font-size:13px;color:rgba(255,255,255,0.6);">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Članarina do: <strong style="color:{{ $aktivanClan ? '#6ea8fe' : '#f1aeb5' }};">{{ $istekClanarine ? \Carbon\Carbon::parse($istekClanarine)->format('d.m.Y') : 'Nema' }}</strong>
          </span>
          @if($member->register_date)
          <span style="font-size:13px;color:rgba(255,255,255,0.6);">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px;"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>
            Registracija: <strong style="color:rgba(255,255,255,0.8);">{{ \Carbon\Carbon::parse($member->register_date)->format('d.m.Y') }}</strong>
          </span>
          @endif
        </div>
      </div>
      <div class="col-auto btn-back-mobile" style="display:none;">
        <a href="{{ url('/members') }}" style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);color:#fff;border-radius:12px;padding:10px 20px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          Nazad
        </a>
      </div>
      <div class="col-auto d-none d-md-block">
        <a href="{{ url('/members') }}" style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);color:#fff;border-radius:12px;padding:10px 20px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          Nazad
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Lične informacije -->
    <div class="col-lg-5 mb-4">
      <div class="info-card">
        <div class="card-header-custom">
          <svg width="18" height="18" fill="none" stroke="#667eea" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Lični podaci
        </div>
        <div>
          <div class="info-row">
            <span class="info-label">Ime i prezime</span>
            <span class="info-value">{{ $member->name.' '.$member->surname }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Mobitel</span>
            <span class="info-value">{{ $member->mobile ?? '—' }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">E-mail</span>
            <span class="info-value">{{ $member->email ?? '—' }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Adresa</span>
            <span class="info-value">{{ $member->street ?? '—' }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Grad</span>
            <span class="info-value">{{ $member->city ?? '—' }}</span>
          </div>
        </div>
      </div>

      <div class="info-card mt-3">
        <div class="card-header-custom">
          <svg width="18" height="18" fill="none" stroke="#11998e" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
          Postavke ciljeva
        </div>
        <form method="POST" action="{{ route('memberProfile.settings', ['id' => $member->id]) }}" style="padding:1rem 1.25rem;">
          @csrf
          <div style="margin-bottom:12px;">
            <label for="monthly_goal_visits" style="display:block;font-size:12px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:6px;">Mjesečni cilj dolazaka</label>
            <input
              type="number"
              id="monthly_goal_visits"
              name="monthly_goal_visits"
              min="1"
              max="60"
              value="{{ old('monthly_goal_visits', $ciljDolazaka) }}"
              style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;font-size:14px;font-weight:600;color:#1f2937;"
              required
            >
          </div>
          <div style="margin-bottom:14px;">
            <label for="monthly_goal_hours" style="display:block;font-size:12px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:6px;">Mjesečni cilj vremena (sati)</label>
            <input
              type="number"
              id="monthly_goal_hours"
              name="monthly_goal_hours"
              min="1"
              max="300"
              value="{{ old('monthly_goal_hours', (int) round($ciljMinuta / 60)) }}"
              style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;font-size:14px;font-weight:600;color:#1f2937;"
              required
            >
          </div>
          <button type="submit" style="border:none;background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;cursor:pointer;">
            Sačuvaj postavke
          </button>
        </form>
      </div>
    </div>

    <!-- Statistika dolazaka -->
    <div class="col-lg-7 mb-4">
      <div class="section-title">
        <span class="dot" style="background:linear-gradient(135deg,#667eea,#764ba2);"></span>
        Statistika dolazaka
      </div>
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
          <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#667eea,#764ba2);">
              <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/><path d="M9 14l2 2 4-4"/></svg>
            </div>
            <p class="stat-label">Ukupno</p>
            <p class="stat-value">{{ $ukupnoDolazaka }}</p>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#11998e,#38ef7d);">
              <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            </div>
            <p class="stat-label">Trenutni mjesec</p>
            <p class="stat-value">{{ $trenutniMjesec }}</p>
            @if($prethodniMjesec > 0)
              @php $promjena = round((($trenutniMjesec - $prethodniMjesec) / $prethodniMjesec) * 100); @endphp
              <p class="stat-sub" style="color:{{ $promjena >= 0 ? '#11998e' : '#e74c3c' }};font-weight:600;">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="vertical-align:-1px;"><path d="{{ $promjena >= 0 ? 'M12 19V5M5 12l7-7 7 7' : 'M12 5v14M5 12l7 7 7-7' }}"/></svg>
                {{ abs($promjena) }}%
              </p>
            @endif
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);">
              <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
            </div>
            <p class="stat-label">Prethodni mjesec</p>
            <p class="stat-value">{{ $prethodniMjesec }}</p>
          </div>
        </div>
      </div>

      <div class="section-title">
        <span class="dot" style="background:linear-gradient(135deg,#4facfe,#00f2fe);"></span>
        Vrijeme boravka u teretani
      </div>
      <div class="row g-3">
        <div class="col-6 col-md-4">
          <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#4facfe,#00f2fe);">
              <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <p class="stat-label">Ukupno sati</p>
            <p class="stat-value">{{ floor($vrijemeUkupno->ukupno / 60) }}h {{ $vrijemeUkupno->ukupno % 60 }}m</p>
            <p class="stat-sub">Prosjek: {{ floor($vrijemeUkupno->prosjek / 60) }}h {{ $vrijemeUkupno->prosjek % 60 }}m</p>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#43e97b,#38f9d7);">
              <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <p class="stat-label">Trenutni mjesec</p>
            <p class="stat-value">{{ floor($vrijemeTrenutni->ukupno / 60) }}h {{ $vrijemeTrenutni->ukupno % 60 }}m</p>
            <p class="stat-sub">Prosjek: {{ floor($vrijemeTrenutni->prosjek / 60) }}h {{ $vrijemeTrenutni->prosjek % 60 }}m</p>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#fccb90,#d57eeb);">
              <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <p class="stat-label">Prethodni mjesec</p>
            <p class="stat-value">{{ floor($vrijemeProthodni->ukupno / 60) }}h {{ $vrijemeProthodni->ukupno % 60 }}m</p>
            <p class="stat-sub">Prosjek: {{ floor($vrijemeProthodni->prosjek / 60) }}h {{ $vrijemeProthodni->prosjek % 60 }}m</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Detaljan pregled treninga -->
  <div class="row">
    <div class="col-12 mb-4">
      <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;gap:10px;">
          <svg width="20" height="20" fill="none" stroke="#667eea" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
          <span style="font-weight:700;font-size:16px;color:#1a1a2e;">Detaljan pregled treninga</span>
        </div>
        <div style="padding:1.5rem;">

          <!-- Progres trenutnog mjeseca -->
          <div class="row g-4 mb-4">
            <div class="col-md-6">
              <div style="background:#f8f9ff;border-radius:14px;padding:1.25rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                  <span style="font-weight:700;font-size:14px;color:#1a1a2e;">Dolasci ovog mjeseca</span>
                  <span style="font-weight:800;font-size:18px;color:#667eea;">{{ $trenutniMjesec }} / {{ $ciljDolazaka }}</span>
                </div>
                @php $progresDolasci = min(round(($trenutniMjesec / $ciljDolazaka) * 100), 100); @endphp
                <div style="background:#e8ecf4;border-radius:10px;height:14px;overflow:hidden;">
                  <div style="width:{{ $progresDolasci }}%;height:100%;border-radius:10px;background:linear-gradient(90deg,#667eea,#764ba2);transition:width 0.8s ease;position:relative;">
                    @if($progresDolasci > 15)
                    <span style="position:absolute;right:8px;top:50%;transform:translateY(-50%);font-size:10px;font-weight:700;color:#fff;">{{ $progresDolasci }}%</span>
                    @endif
                  </div>
                </div>
                <p style="margin:8px 0 0;font-size:12px;color:#6c757d;">
                  @if($progresDolasci >= 80)
                    <span style="color:#11998e;font-weight:600;">Odlično! Na dobrom ste putu.</span>
                  @elseif($progresDolasci >= 50)
                    <span style="color:#f5a623;font-weight:600;">Dobar napredak, nastavite!</span>
                  @else
                    <span style="color:#e74c3c;font-weight:600;">Potrebno je više treninga.</span>
                  @endif
                  Cilj: {{ $ciljDolazaka }} dolazaka mjesečno
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div style="background:#f0fdf4;border-radius:14px;padding:1.25rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                  <span style="font-weight:700;font-size:14px;color:#1a1a2e;">Sati u teretani ovog mjeseca</span>
                  <span style="font-weight:800;font-size:18px;color:#11998e;">{{ floor($vrijemeTrenutni->ukupno / 60) }}h / {{ $ciljSatiPrikaz }}h</span>
                </div>
                @php $progresVrijeme = min(round(($vrijemeTrenutni->ukupno / $ciljMinuta) * 100), 100); @endphp
                <div style="background:#d1fae5;border-radius:10px;height:14px;overflow:hidden;">
                  <div style="width:{{ $progresVrijeme }}%;height:100%;border-radius:10px;background:linear-gradient(90deg,#11998e,#38ef7d);transition:width 0.8s ease;position:relative;">
                    @if($progresVrijeme > 15)
                    <span style="position:absolute;right:8px;top:50%;transform:translateY(-50%);font-size:10px;font-weight:700;color:#fff;">{{ $progresVrijeme }}%</span>
                    @endif
                  </div>
                </div>
                <p style="margin:8px 0 0;font-size:12px;color:#6c757d;">
                  @if($progresVrijeme >= 80)
                    <span style="color:#11998e;font-weight:600;">Fenomenalan angažman!</span>
                  @elseif($progresVrijeme >= 50)
                    <span style="color:#f5a623;font-weight:600;">Solidno, dodajte još treninga.</span>
                  @else
                    <span style="color:#e74c3c;font-weight:600;">Provedite više vremena na treningu.</span>
                  @endif
                  Cilj: {{ $ciljSatiPrikaz }} sati mjesečno
                </p>
              </div>
            </div>
          </div>

          <!-- Grafikon dolazaka i tabela po mjesecima -->
          <div class="row g-4">
            <div class="col-12 col-md-7">
              <div style="background:#f8f9ff;border-radius:14px;padding:1.25rem;">
                <p style="font-weight:700;font-size:14px;color:#1a1a2e;margin-bottom:16px;">Dolasci po mjesecima</p>
                <canvas id="profileChart" height="220"></canvas>
              </div>
            </div>
            <div class="col-12 col-md-5">
              <div style="background:#faf5ff;border-radius:14px;padding:1.25rem;">
                <p style="font-weight:700;font-size:14px;color:#1a1a2e;margin-bottom:12px;">Mjesečna usporedba</p>
                @foreach($mjesecniPregled as $mp)
                <div style="margin-bottom:14px;">
                  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                    <span style="font-size:13px;font-weight:{{ $mp['tekuci'] ? '700' : '500' }};color:{{ $mp['tekuci'] ? '#667eea' : '#1a1a2e' }};">
                      {{ $mp['mjesec'] }}
                      @if($mp['tekuci']) <span style="font-size:10px;background:#667eea;color:#fff;padding:2px 6px;border-radius:6px;margin-left:4px;">Sada</span> @endif
                    </span>
                    <span style="font-size:12px;color:#6c757d;font-weight:600;">{{ $mp['dolasci'] }} posjeta &middot; {{ floor($mp['ukupno_minuta'] / 60) }}h {{ $mp['ukupno_minuta'] % 60 }}m</span>
                  </div>
                  @php
                    $maxDolasci = $mjesecniPregled->max('dolasci') ?: 1;
                    $barPerc = round(($mp['dolasci'] / $maxDolasci) * 100);
                    $percDolasci = min(round(($mp['dolasci'] / $ciljDolazaka) * 100), 100);
                  @endphp
                  <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                    <span style="font-size:12px;font-weight:700;color:{{ $percDolasci >= 80 ? '#11998e' : ($percDolasci >= 50 ? '#f5a623' : '#e74c3c') }};">{{ $percDolasci }}%</span>
                    <span style="font-size:11px;color:#9ca3af;">cilja</span>
                  </div>
                  <div style="background:#e8e0f0;border-radius:8px;height:8px;overflow:hidden;">
                    <div style="width:{{ $barPerc }}%;height:100%;border-radius:8px;background:linear-gradient(90deg,{{ $mp['tekuci'] ? '#667eea,#764ba2' : '#c4b5fd,#a78bfa' }});transition:width 0.6s ease;"></div>
                  </div>
                  @if($mp['prosjek_minuta'] > 0)
                  <p style="margin:3px 0 0;font-size:11px;color:#9ca3af;">Prosjek po posjeti: {{ floor($mp['prosjek_minuta'] / 60) }}h {{ $mp['prosjek_minuta'] % 60 }}m</p>
                  @endif
                </div>
                @endforeach
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Uporedba godina -->
  <div class="row">
    <div class="col-12 mb-4">
      <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;gap:10px;">
          <svg width="20" height="20" fill="none" stroke="#764ba2" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M7 16l4-8 4 4 4-6"/></svg>
          <span style="font-weight:700;font-size:16px;color:#1a1a2e;">Uporedba godina — {{ $godisnjiPregled['prethodna']['godina'] }} vs {{ $godisnjiPregled['trenutna']['godina'] }}</span>
        </div>
        <div style="padding:1.5rem;">
          <div class="row g-4">
            <div class="col-md-6">
              <div style="background:#f8f9ff;border-radius:14px;padding:1.25rem;">
                <p style="font-weight:700;font-size:14px;color:#1a1a2e;margin-bottom:16px;">Dolasci po mjesecima</p>
                <canvas id="yearCompareVisits" height="260"></canvas>
              </div>
            </div>
            <div class="col-md-6">
              <div style="background:#f0fdf4;border-radius:14px;padding:1.25rem;">
                <p style="font-weight:700;font-size:14px;color:#1a1a2e;margin-bottom:16px;">Provedeno vrijeme (sati)</p>
                <canvas id="yearCompareHours" height="260"></canvas>
              </div>
            </div>
          </div>

          <!-- Statistička tabela -->
          <div class="mt-4 year-table-wrap" style="overflow-x:auto;">
            <table style="width:100%;border-collapse:separate;border-spacing:0;border-radius:12px;overflow:hidden;font-size:13px;">
              <thead>
                <tr style="background:linear-gradient(135deg,#1a1a2e,#16213e);color:#fff;">
                  <th style="padding:12px 16px;font-weight:700;text-align:left;">Mjesec</th>
                  <th style="padding:12px 10px;text-align:center;">Dolasci {{ $godisnjiPregled['prethodna']['godina'] }}</th>
                  <th class="hide-mobile" style="padding:12px 10px;text-align:center;">%</th>
                  <th style="padding:12px 10px;text-align:center;">Dolasci {{ $godisnjiPregled['trenutna']['godina'] }}</th>
                  <th class="hide-mobile" style="padding:12px 10px;text-align:center;">%</th>
                  <th style="padding:12px 10px;text-align:center;">Razlika</th>
                  <th style="padding:12px 10px;text-align:center;">Sati {{ $godisnjiPregled['prethodna']['godina'] }}</th>
                  <th class="hide-mobile" style="padding:12px 10px;text-align:center;">%</th>
                  <th style="padding:12px 10px;text-align:center;">Sati {{ $godisnjiPregled['trenutna']['godina'] }}</th>
                  <th class="hide-mobile" style="padding:12px 10px;text-align:center;">%</th>
                  <th style="padding:12px 10px;text-align:center;">Razlika</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $mjesecPuni = ['Jan'=>'Januar','Feb'=>'Februar','Mar'=>'Mart','Apr'=>'April','Maj'=>'Maj','Jun'=>'Juni','Jul'=>'Juli','Aug'=>'August','Sep'=>'Septembar','Okt'=>'Oktobar','Nov'=>'Novembar','Dec'=>'Decembar'];
                  $totalPD = array_sum($godisnjiPregled['prethodna']['dolasci']);
                  $totalTD = array_sum($godisnjiPregled['trenutna']['dolasci']);
                  $totalPS = array_sum($godisnjiPregled['prethodna']['sati']);
                  $totalTS = array_sum($godisnjiPregled['trenutna']['sati']);
                @endphp
                @foreach($godisnjiPregled['labels'] as $idx => $label)
                @php
                  $pD = $godisnjiPregled['prethodna']['dolasci'][$idx];
                  $tD = $godisnjiPregled['trenutna']['dolasci'][$idx];
                  $pS = $godisnjiPregled['prethodna']['sati'][$idx];
                  $tS = $godisnjiPregled['trenutna']['sati'][$idx];
                  $diffD = $tD - $pD;
                  $diffS = round($tS - $pS, 1);
                  $percD = $pD > 0 ? round((($tD - $pD) / $pD) * 100) : ($tD > 0 ? 100 : 0);
                  $percS = $pS > 0 ? round((($tS - $pS) / $pS) * 100) : ($tS > 0 ? 100 : 0);
                  $isTekuci = ($idx + 1) == now()->month;
                @endphp
                <tr style="background:{{ $isTekuci ? '#f0f0ff' : ($loop->even ? '#fafafa' : '#fff') }};border-bottom:1px solid #f0f0f0;{{ $isTekuci ? 'font-weight:600;' : '' }}">
                  <td style="padding:10px 16px;color:#1a1a2e;font-weight:{{ $isTekuci ? '700' : '600' }};">
                    {{ $mjesecPuni[$label] ?? $label }}
                    @if($isTekuci) <span style="font-size:9px;background:#667eea;color:#fff;padding:2px 5px;border-radius:5px;margin-left:4px;">Sada</span> @endif
                  </td>
                  <td style="padding:10px;text-align:center;color:#a78bfa;font-weight:600;">{{ $pD }}</td>
                  <td class="hide-mobile" style="padding:10px 6px;text-align:center;font-size:11px;color:#9ca3af;">
                    @if($totalPD > 0){{ round(($pD / $totalPD) * 100) }}%@else 0%@endif
                  </td>
                  <td style="padding:10px;text-align:center;color:#667eea;font-weight:700;">{{ $tD }}</td>
                  <td class="hide-mobile" style="padding:10px 6px;text-align:center;font-size:11px;color:#9ca3af;">
                    @if($totalTD > 0){{ round(($tD / $totalTD) * 100) }}%@else 0%@endif
                  </td>
                  <td style="padding:10px;text-align:center;font-weight:700;color:{{ $diffD > 0 ? '#11998e' : ($diffD < 0 ? '#e74c3c' : '#9ca3af') }};">
                    {{ $diffD > 0 ? '+' : '' }}{{ $diffD }}
                    <span style="font-size:10px;font-weight:600;">({{ $percD > 0 ? '+' : '' }}{{ $percD }}%)</span>
                  </td>
                  <td style="padding:10px;text-align:center;color:#38ef7d;font-weight:600;">{{ $pS }}h</td>
                  <td class="hide-mobile" style="padding:10px 6px;text-align:center;font-size:11px;color:#9ca3af;">
                    @if($totalPS > 0){{ round(($pS / $totalPS) * 100) }}%@else 0%@endif
                  </td>
                  <td style="padding:10px;text-align:center;color:#11998e;font-weight:700;">{{ $tS }}h</td>
                  <td class="hide-mobile" style="padding:10px 6px;text-align:center;font-size:11px;color:#9ca3af;">
                    @if($totalTS > 0){{ round(($tS / $totalTS) * 100) }}%@else 0%@endif
                  </td>
                  <td style="padding:10px;text-align:center;font-weight:700;color:{{ $diffS > 0 ? '#11998e' : ($diffS < 0 ? '#e74c3c' : '#9ca3af') }};">
                    {{ $diffS > 0 ? '+' : '' }}{{ $diffS }}h
                    <span style="font-size:10px;font-weight:600;">({{ $percS > 0 ? '+' : '' }}{{ $percS }}%)</span>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                @php
                  $totalDiffD = $totalTD - $totalPD;
                  $totalPercD = $totalPD > 0 ? round((($totalTD - $totalPD) / $totalPD) * 100) : ($totalTD > 0 ? 100 : 0);
                  $totalDiffS = round($totalTS - $totalPS, 1);
                  $totalPercS = $totalPS > 0 ? round((($totalTS - $totalPS) / $totalPS) * 100) : ($totalTS > 0 ? 100 : 0);
                @endphp
                <tr style="background:linear-gradient(135deg,#1a1a2e,#16213e);color:#fff;font-weight:700;">
                  <td style="padding:12px 16px;">UKUPNO</td>
                  <td style="padding:12px 10px;text-align:center;">{{ $totalPD }}</td>
                  <td class="hide-mobile" style="padding:12px 6px;text-align:center;font-size:11px;opacity:0.7;">100%</td>
                  <td style="padding:12px 10px;text-align:center;">{{ $totalTD }}</td>
                  <td class="hide-mobile" style="padding:12px 6px;text-align:center;font-size:11px;opacity:0.7;">100%</td>
                  <td style="padding:12px 10px;text-align:center;color:{{ $totalDiffD > 0 ? '#38ef7d' : ($totalDiffD < 0 ? '#ff6b6b' : '#fff') }};">
                    {{ $totalDiffD > 0 ? '+' : '' }}{{ $totalDiffD }}
                    <span style="font-size:10px;">({{ $totalPercD > 0 ? '+' : '' }}{{ $totalPercD }}%)</span>
                  </td>
                  <td style="padding:12px 10px;text-align:center;">{{ $totalPS }}h</td>
                  <td class="hide-mobile" style="padding:12px 6px;text-align:center;font-size:11px;opacity:0.7;">100%</td>
                  <td style="padding:12px 10px;text-align:center;">{{ $totalTS }}h</td>
                  <td class="hide-mobile" style="padding:12px 6px;text-align:center;font-size:11px;opacity:0.7;">100%</td>
                  <td style="padding:12px 10px;text-align:center;color:{{ $totalDiffS > 0 ? '#38ef7d' : ($totalDiffS < 0 ? '#ff6b6b' : '#fff') }};">
                    {{ $totalDiffS > 0 ? '+' : '' }}{{ $totalDiffS }}h
                    <span style="font-size:10px;">({{ $totalPercS > 0 ? '+' : '' }}{{ $totalPercS }}%)</span>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var labels = @json($mjesecniPregled->pluck('mjesec_kratki'));
      var dolasci = @json($mjesecniPregled->pluck('dolasci'));
      var sati = @json($mjesecniPregled->pluck('ukupno_minuta')->map(function($m){ return round($m / 60, 1); }));

      var profileCtx = document.getElementById('profileChart').getContext('2d');

      var gradientDolasci = profileCtx.createLinearGradient(0, 0, 0, 220);
      gradientDolasci.addColorStop(0, 'rgba(102,126,234,0.25)');
      gradientDolasci.addColorStop(1, 'rgba(102,126,234,0.02)');

      var gradientSati = profileCtx.createLinearGradient(0, 0, 0, 220);
      gradientSati.addColorStop(0, 'rgba(17,153,142,0.2)');
      gradientSati.addColorStop(1, 'rgba(17,153,142,0.02)');

      new Chart(profileCtx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Dolasci',
              data: dolasci,
              backgroundColor: 'rgba(102,126,234,0.8)',
              borderColor: '#667eea',
              borderWidth: 2,
              borderRadius: 8,
              borderSkipped: false,
              yAxisID: 'y',
              order: 2
            },
            {
              label: 'Sati',
              data: sati,
              type: 'line',
              borderColor: '#11998e',
              backgroundColor: gradientSati,
              borderWidth: 2.5,
              pointBackgroundColor: '#11998e',
              pointBorderColor: '#fff',
              pointBorderWidth: 2,
              pointRadius: 4,
              fill: true,
              tension: 0.35,
              yAxisID: 'y1',
              order: 1
            }
          ]
        },
        options: {
          responsive: true,
          interaction: { mode: 'index', intersect: false },
          plugins: {
            legend: {
              position: 'top',
              labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, font: { size: 12, weight: '600' } }
            },
            tooltip: {
              backgroundColor: '#1a1a2e',
              titleFont: { size: 13, weight: '600' },
              bodyFont: { size: 12 },
              padding: 12,
              cornerRadius: 10,
              callbacks: {
                label: function(tooltipItem) {
                  if (tooltipItem.dataset.label === 'Dolasci') return tooltipItem.parsed.y + ' posjeta';
                  return tooltipItem.parsed.y + ' sati';
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              position: 'left',
              ticks: { stepSize: 1, font: { size: 11, weight: '500' }, color: '#6c757d' },
              grid: { color: 'rgba(0,0,0,0.04)' },
              title: { display: true, text: 'Dolasci', font: { size: 11, weight: '600' }, color: '#667eea' }
            },
            y1: {
              beginAtZero: true,
              position: 'right',
              ticks: { font: { size: 11, weight: '500' }, color: '#6c757d' },
              grid: { display: false },
              title: { display: true, text: 'Sati', font: { size: 11, weight: '600' }, color: '#11998e' }
            },
            x: {
              ticks: { font: { size: 12, weight: '600' }, color: '#6c757d' },
              grid: { display: false }
            }
          }
        }
      });

      // Uporedba godina - chartovi
      var ycLabels = @json($godisnjiPregled['labels']);
      var ycTDolasci = @json($godisnjiPregled['trenutna']['dolasci']);
      var ycPDolasci = @json($godisnjiPregled['prethodna']['dolasci']);
      var ycTSati = @json($godisnjiPregled['trenutna']['sati']);
      var ycPSati = @json($godisnjiPregled['prethodna']['sati']);
      var ycTGodina = {{ $godisnjiPregled['trenutna']['godina'] }};
      var ycPGodina = {{ $godisnjiPregled['prethodna']['godina'] }};

      var ycChartOpts = function(suffix) {
        return {
          responsive: true,
          interaction: { mode: 'index', intersect: false },
          plugins: {
            legend: { position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, font: { size: 12, weight: '600' } } },
            tooltip: {
              backgroundColor: '#1a1a2e', titleFont: { size: 13, weight: '600' }, bodyFont: { size: 12 }, padding: 12, cornerRadius: 10,
              callbacks: {
                label: function(c) { return c.dataset.label + ': ' + c.parsed.y + ' ' + suffix; },
                afterBody: function(items) {
                  if (items.length < 2) return '';
                  var prev = items[0].parsed.y;
                  var curr = items[1].parsed.y;
                  var diff = curr - prev;
                  var perc = prev > 0 ? Math.round(((curr - prev) / prev) * 100) : (curr > 0 ? 100 : 0);
                  var sign = diff > 0 ? '+' : '';
                  return 'Razlika: ' + sign + diff + ' ' + suffix + ' (' + sign + perc + '%)';
                }
              }
            }
          },
          scales: {
            y: { beginAtZero: true, position: 'left', ticks: { font: { size: 11, weight: '500' }, color: '#6c757d' }, grid: { color: 'rgba(0,0,0,0.04)' } },
            x: { ticks: { font: { size: 11, weight: '600' }, color: '#6c757d' }, grid: { display: false } }
          }
        };
      };

      // Dolasci chart
      new Chart(document.getElementById('yearCompareVisits').getContext('2d'), {
        type: 'bar',
        data: {
          labels: ycLabels,
          datasets: [
            {
              label: ycPGodina.toString(),
              data: ycPDolasci,
              backgroundColor: 'rgba(196,181,253,0.7)',
              borderColor: '#a78bfa',
              borderWidth: 2,
              borderRadius: 6,
              borderSkipped: false
            },
            {
              label: ycTGodina.toString(),
              data: ycTDolasci,
              backgroundColor: 'rgba(102,126,234,0.8)',
              borderColor: '#667eea',
              borderWidth: 2,
              borderRadius: 6,
              borderSkipped: false
            }
          ]
        },
        options: ycChartOpts('posjeta')
      });

      // Sati chart
      new Chart(document.getElementById('yearCompareHours').getContext('2d'), {
        type: 'bar',
        data: {
          labels: ycLabels,
          datasets: [
            {
              label: ycPGodina.toString(),
              data: ycPSati,
              backgroundColor: 'rgba(167,218,200,0.7)',
              borderColor: '#38ef7d',
              borderWidth: 2,
              borderRadius: 6,
              borderSkipped: false
            },
            {
              label: ycTGodina.toString(),
              data: ycTSati,
              backgroundColor: 'rgba(17,153,142,0.75)',
              borderColor: '#11998e',
              borderWidth: 2,
              borderRadius: 6,
              borderSkipped: false
            }
          ]
        },
        options: ycChartOpts('sati')
      });
    });
  </script>

</div>

@endsection
