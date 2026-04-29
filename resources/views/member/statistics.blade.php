@extends('member.layout')
@section('styles')
<style>
  :root {
    --dash-bg: #0a0a0a;
    --dash-panel: #131316;
    --dash-panel-soft: #17171b;
    --dash-border: rgba(255,255,255,0.08);
    --dash-text: #f4f4f5;
    --dash-muted: #a1a1aa;
    --dash-subtle: #8b8b93;
    --dash-accent: #ffb800;
    --dash-accent-soft: #ffdd8a;
  }

  body { background: var(--dash-bg); color: var(--dash-text); }
  .main-content { background: var(--dash-bg); }

  .page-title {
    font-size: 1.4rem; font-weight: 800; color: var(--dash-text); margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 10px;
  }
  .page-title svg { color: var(--dash-accent); }

  .stat-card {
    background: linear-gradient(160deg, var(--dash-panel), #0f0f11);
    border: 1px solid var(--dash-border);
    border-radius: 14px; padding: 1.25rem; text-align: center;
    transition: transform 0.2s ease, border-color 0.2s ease;
    box-shadow: 0 14px 32px rgba(0,0,0,0.26);
  }
  .stat-card:hover { transform: translateY(-2px); border-color: rgba(255,184,0,0.3); }
  .stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 8px;
  }
  .stat-value { font-size: 1.8rem; font-weight: 800; color: var(--dash-text); margin: 0; }
  .stat-label {
    font-size: 10px; font-weight: 700; color: var(--dash-muted);
    text-transform: uppercase; letter-spacing: 0.8px;
  }
  .stat-sub { font-size: 13px; color: var(--dash-subtle); font-weight: 600; margin-top: 3px; }

  .section-title {
    font-weight: 700; font-size: 15px; color: var(--dash-text);
    margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;
  }
  .monthly-goals-title {
    font-size: 24px;
    font-weight: 800;
    letter-spacing: 0.3px;
  }
  .section-title .dot {
    width: 8px; height: 8px; border-radius: 50%; display: inline-block;
  }

  .glass-panel {
    background: linear-gradient(160deg, var(--dash-panel), var(--dash-panel-soft));
    border: 1px solid var(--dash-border);
    border-radius: 16px; padding: 1.25rem;
    box-shadow: 0 12px 30px rgba(0,0,0,0.24);
  }

  .progress-wrap { margin-bottom: 16px; }
  .progress-header {
    display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;
  }
  .progress-title { font-weight: 700; font-size: 13px; color: var(--dash-text); }
  .progress-value { font-weight: 800; font-size: 18px; }
  .progress-bar-bg {
    background: rgba(255,255,255,0.08); border-radius: 10px; height: 12px; overflow: hidden;
  }
  .progress-bar-fill {
    height: 100%; border-radius: 10px; transition: width 0.8s ease; position: relative;
  }
  .progress-bar-fill span {
    position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
    font-size: 11px; font-weight: 700; color: #0a0a0a;
  }
  .progress-msg { margin: 4px 0 0; font-size: 11px; font-weight: 600; }

  .month-row {
    padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.08);
  }
  .month-row:last-child { border-bottom: none; }
  .month-name { font-size: 13px; font-weight: 600; color: var(--dash-muted); }
  .month-name.tekuci { color: var(--dash-accent-soft); font-weight: 700; }
  .month-stats { font-size: 13px; color: var(--dash-subtle); font-weight: 600; }
  .month-bar-bg {
    background: rgba(255,255,255,0.08); border-radius: 6px; height: 6px; overflow: hidden; margin-top: 4px;
  }
  .month-bar-fill { height: 100%; border-radius: 6px; transition: width 0.6s ease; }

  .week-card {
    background: linear-gradient(160deg, var(--dash-panel), #101013);
    border: 1px solid var(--dash-border);
    border-radius: 12px; padding: 1.1rem; text-align: center;
    box-shadow: 0 10px 24px rgba(0,0,0,0.2);
  }
  .week-card.tekuca { border-color: rgba(255,184,0,0.45); background: rgba(255,184,0,0.08); }
  .week-label { font-size: 17px; font-weight: 800; color: var(--dash-muted); margin-bottom: 8px; }
  .week-value { font-size: 1.6rem; font-weight: 800; color: var(--dash-text); }
  .week-sub { font-size: 16px; color: var(--dash-subtle); font-weight: 700; }

  .year-table {
    width: 100%; border-collapse: separate; border-spacing: 0;
    border-radius: 12px; overflow: hidden; font-size: 14px;
  }
  .year-table thead tr {
    background: linear-gradient(135deg, #151517, #0f0f11); color: var(--dash-text);
  }
  .year-table th { padding: 10px 8px; font-weight: 700; text-align: center; }
  .year-table th:first-child { text-align: left; padding-left: 14px; }
  .year-table td { padding: 8px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.08); color: #d4d4d8; }
  .year-table td:first-child { text-align: left; padding-left: 14px; font-weight: 600; color: var(--dash-muted); }
  .year-table tbody tr:hover { background: rgba(255,255,255,0.03); }
  .year-table tfoot tr {
    background: linear-gradient(135deg, #151517, #0f0f11); color: var(--dash-text); font-weight: 700;
  }

  @media (max-width: 767.98px) {
    .stat-value { font-size: 1.35rem; }
    .stat-icon { width: 36px; height: 36px; }
    .stat-card { padding: 1rem 0.5rem; }
    .page-title { font-size: 1.1rem; }
    .week-label { font-size: 15px; }
    .week-sub { font-size: 14px; }
    .year-table { font-size: 11px; }
    .year-table th, .year-table td { padding: 6px 4px; }
    .hide-mobile { display: none !important; }
  }
</style>
@endsection

@section('content')
@php
  $ciljSatiPrikaz = fmod(round($ciljMinuta / 60, 1), 1.0) === 0.0 ? number_format(round($ciljMinuta / 60, 1), 0) : number_format(round($ciljMinuta / 60, 1), 1);
@endphp
<div style="max-width:1000px;">

  <div class="page-title">
    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
    Statistika treninga
  </div>

  <!-- Stat Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#ffb800,#f59e0b);">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <p class="stat-value">{{ $ukupnoDolazaka }}</p>
        <p class="stat-label">Ukupno dolazaka</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#f4f4f5,#d4d4d8);">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <p class="stat-value">{{ $trenutniMjesec }}</p>
        <p class="stat-label">Ovaj mjesec</p>
        @if($prethodniMjesec > 0)
          @php $promjena = round((($trenutniMjesec - $prethodniMjesec) / $prethodniMjesec) * 100); @endphp
          <p class="stat-sub" style="color:{{ $promjena >= 0 ? '#ffdd8a' : '#d4d4d8' }};font-weight:600;">
            {{ $promjena >= 0 ? '+' : '' }}{{ $promjena }}% vs prethodni
          </p>
        @endif
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#a1a1aa,#71717a);">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <p class="stat-value">{{ floor($vrijemeUkupno->ukupno / 60) }}<span style="font-size:0.7em;font-weight:600;">h</span></p>
        <p class="stat-label">Ukupno sati</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#ffdd8a,#f4f4f5);">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <p class="stat-value">{{ floor($vrijemeUkupno->prosjek) }}<span style="font-size:0.7em;font-weight:600;">min</span></p>
        <p class="stat-label">Prosjek / trening</p>
      </div>
    </div>
  </div>

  <!-- Ciljevi -->
  <div class="section-title monthly-goals-title">
    <span class="dot" style="background:linear-gradient(135deg,#ffb800,#f59e0b);"></span>
    Mjesečni ciljevi
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="glass-panel">
        @php $progresDolasci = min(round(($trenutniMjesec / $ciljDolazaka) * 100), 100); @endphp
        <div class="progress-wrap">
          <div class="progress-header">
            <span class="progress-title">Dolasci ovog mjeseca</span>
            <span class="progress-value" style="color:#ffdd8a;">{{ $trenutniMjesec }} / {{ $ciljDolazaka }}</span>
          </div>
          <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width:{{ $progresDolasci }}%;background:linear-gradient(90deg,#ffb800,#f59e0b);">
              @if($progresDolasci > 15)<span>{{ $progresDolasci }}%</span>@endif
            </div>
          </div>
          <p class="progress-msg" style="color:{{ $progresDolasci >= 80 ? '#ffdd8a' : ($progresDolasci >= 50 ? '#f4f4f5' : '#a1a1aa') }};">
            @if($progresDolasci >= 80) Odlično! Na dobrom ste putu.
            @elseif($progresDolasci >= 50) Dobar napredak, nastavite!
            @else Potrebno je više treninga.
            @endif
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="glass-panel">
        @php $progresVrijeme = min(round(($vrijemeTrenutni->ukupno / $ciljMinuta) * 100), 100); @endphp
        <div class="progress-wrap">
          <div class="progress-header">
            <span class="progress-title">Sati u teretani ovog mjeseca</span>
            <span class="progress-value" style="color:#f4f4f5;">{{ floor($vrijemeTrenutni->ukupno / 60) }}h / {{ $ciljSatiPrikaz }}h</span>
          </div>
          <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width:{{ $progresVrijeme }}%;background:linear-gradient(90deg,#f4f4f5,#d4d4d8);">
              @if($progresVrijeme > 15)<span>{{ $progresVrijeme }}%</span>@endif
            </div>
          </div>
          <p class="progress-msg" style="color:{{ $progresVrijeme >= 80 ? '#ffdd8a' : ($progresVrijeme >= 50 ? '#f4f4f5' : '#a1a1aa') }};">
            @if($progresVrijeme >= 80) Fenomenalan angažman!
            @elseif($progresVrijeme >= 50) Solidno, dodajte još treninga.
            @else Provedite više vremena na treningu.
            @endif
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Vrijeme boravka -->
  <div class="section-title">
    <span class="dot" style="background:linear-gradient(135deg,#a1a1aa,#71717a);"></span>
    Vrijeme boravka u teretani
  </div>
  <div class="row g-3 mb-4">
    <div class="col-4">
      <div class="stat-card">
        <p class="stat-label">Ukupno</p>
        <p class="stat-value" style="font-size:1.45rem;">{{ floor($vrijemeUkupno->ukupno / 60) }}h {{ $vrijemeUkupno->ukupno % 60 }}m</p>
        <p class="stat-sub">Prosjek: {{ floor($vrijemeUkupno->prosjek) }}min</p>
      </div>
    </div>
    <div class="col-4">
      <div class="stat-card">
        <p class="stat-label">Ovaj mjesec</p>
        <p class="stat-value" style="font-size:1.45rem;">{{ floor($vrijemeTrenutni->ukupno / 60) }}h {{ $vrijemeTrenutni->ukupno % 60 }}m</p>
        <p class="stat-sub">Prosjek: {{ floor($vrijemeTrenutni->prosjek) }}min</p>
      </div>
    </div>
    <div class="col-4">
      <div class="stat-card">
        <p class="stat-label">Prethodni mjesec</p>
        <p class="stat-value" style="font-size:1.45rem;">{{ floor($vrijemeProthodni->ukupno / 60) }}h {{ $vrijemeProthodni->ukupno % 60 }}m</p>
        <p class="stat-sub">Prosjek: {{ floor($vrijemeProthodni->prosjek) }}min</p>
      </div>
    </div>
  </div>

  <!-- Sedmicni pregled -->
  <div class="section-title">
    <span class="dot" style="background:linear-gradient(135deg,#ffdd8a,#f4f4f5);"></span>
    Sedmični pregled
  </div>
  <div class="row g-3 mb-4">
    @foreach($sedmicniPregled as $sed)
    <div class="col-6 col-md-3">
      <div class="week-card {{ $sed['tekuca'] ? 'tekuca' : '' }}">
        <p class="week-label">
          {{ $sed['label'] }}
          @if($sed['tekuca']) <span style="font-size:13px;background:#ffb800;color:#0a0a0a;padding:2px 8px;border-radius:6px;margin-left:4px;">Sada</span> @endif
        </p>
        <p class="week-value">{{ $sed['dolasci'] }}</p>
        <p class="week-sub">{{ floor($sed['minuta'] / 60) }}h {{ $sed['minuta'] % 60 }}m</p>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Grafikoni -->
  <div class="row g-3 mb-4">
    <div class="col-md-7">
      <div class="glass-panel">
        <p style="font-weight:700;font-size:14px;color:#f4f4f5;margin-bottom:16px;">Dolasci po mjesecima</p>
        <canvas id="chartDolasci" height="240"></canvas>
      </div>
    </div>
    <div class="col-md-5">
      <div class="glass-panel">
        <p style="font-weight:700;font-size:14px;color:#f4f4f5;margin-bottom:16px;">Dani u sedmici</p>
        <canvas id="chartDani" height="240"></canvas>
      </div>
    </div>
  </div>

  <!-- Mjesecna usporedba -->
  <div class="section-title">
    <span class="dot" style="background:linear-gradient(135deg,#ffb800,#f59e0b);"></span>
    Mjesečna usporedba (6 mjeseci)
  </div>
  <div class="glass-panel mb-4">
    @foreach($mjesecniPregled as $mp)
    <div class="month-row">
      <div class="d-flex justify-content-between align-items-center">
        <span class="month-name {{ $mp['tekuci'] ? 'tekuci' : '' }}">
          {{ $mp['mjesec'] }}
          @if($mp['tekuci']) <span style="font-size:9px;background:#ffb800;color:#0a0a0a;padding:2px 6px;border-radius:5px;margin-left:4px;">Sada</span> @endif
        </span>
        <span class="month-stats">{{ $mp['dolasci'] }} posjeta &middot; {{ floor($mp['ukupno_minuta'] / 60) }}h {{ $mp['ukupno_minuta'] % 60 }}m</span>
      </div>
      @php
        $maxDolasci = $mjesecniPregled->max('dolasci') ?: 1;
        $barPerc = round(($mp['dolasci'] / $maxDolasci) * 100);
        $percCilja = min(round(($mp['dolasci'] / $ciljDolazaka) * 100), 100);
      @endphp
      <div class="d-flex align-items-center gap-2 mt-1">
        <span style="font-size:13px;font-weight:700;color:{{ $percCilja >= 80 ? '#ffdd8a' : ($percCilja >= 50 ? '#f4f4f5' : '#a1a1aa') }};min-width:36px;">{{ $percCilja }}%</span>
        <div class="month-bar-bg flex-grow-1">
          <div class="month-bar-fill" style="width:{{ $barPerc }}%;background:linear-gradient(90deg,{{ $mp['tekuci'] ? '#ffb800,#f59e0b' : '#71717a,#52525b' }});"></div>
        </div>
      </div>
      @if($mp['prosjek_minuta'] > 0)
      <p style="margin:2px 0 0;font-size:12px;color:#8b8b93;">Prosjek po posjeti: {{ floor($mp['prosjek_minuta'] / 60) }}h {{ $mp['prosjek_minuta'] % 60 }}m</p>
      @endif
    </div>
    @endforeach
  </div>

  <!-- Godisnja uporedba -->
  <div class="section-title">
    <span class="dot" style="background:linear-gradient(135deg,#ffb800,#f59e0b);"></span>
    Uporedba godina — {{ $godisnjiPregled['prethodna']['godina'] }} vs {{ $godisnjiPregled['trenutna']['godina'] }}
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="glass-panel">
        <p style="font-weight:700;font-size:13px;color:#f4f4f5;margin-bottom:12px;">Dolasci po mjesecima</p>
        <canvas id="yearVisits" height="240"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="glass-panel">
        <p style="font-weight:700;font-size:13px;color:#f4f4f5;margin-bottom:12px;">Provedeno vrijeme (sati)</p>
        <canvas id="yearHours" height="240"></canvas>
      </div>
    </div>
  </div>

  <div class="glass-panel mb-4" style="overflow-x:auto;">
    <table class="year-table">
      <thead>
        <tr>
          <th>Mjesec</th>
          <th>{{ $godisnjiPregled['prethodna']['godina'] }}</th>
          <th>{{ $godisnjiPregled['trenutna']['godina'] }}</th>
          <th>+/-</th>
          <th class="hide-mobile">Sati {{ $godisnjiPregled['prethodna']['godina'] }}</th>
          <th class="hide-mobile">Sati {{ $godisnjiPregled['trenutna']['godina'] }}</th>
          <th class="hide-mobile">+/-</th>
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
          $isTekuci = ($idx + 1) == now()->month;
        @endphp
        <tr style="{{ $isTekuci ? 'background:rgba(255,184,0,0.1);' : '' }}">
          <td style="font-weight:{{ $isTekuci ? '700' : '600' }};{{ $isTekuci ? 'color:#ffdd8a;' : '' }}">
            {{ $mjesecPuni[$label] ?? $label }}
            @if($isTekuci) <span style="font-size:8px;background:#ffb800;color:#0a0a0a;padding:1px 5px;border-radius:4px;margin-left:3px;">Sada</span> @endif
          </td>
          <td style="color:#a1a1aa;font-weight:600;">{{ $pD }}</td>
          <td style="color:#ffdd8a;font-weight:700;">{{ $tD }}</td>
          <td style="font-weight:700;color:{{ $diffD > 0 ? '#ffdd8a' : ($diffD < 0 ? '#d4d4d8' : '#8b8b93') }};">
            {{ $diffD > 0 ? '+' : '' }}{{ $diffD }}
          </td>
          <td class="hide-mobile" style="color:#a1a1aa;font-weight:600;">{{ $pS }}h</td>
          <td class="hide-mobile" style="color:#f4f4f5;font-weight:700;">{{ $tS }}h</td>
          <td class="hide-mobile" style="font-weight:700;color:{{ $diffS > 0 ? '#ffdd8a' : ($diffS < 0 ? '#d4d4d8' : '#8b8b93') }};">
            {{ $diffS > 0 ? '+' : '' }}{{ $diffS }}h
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        @php
          $totalDiffD = $totalTD - $totalPD;
          $totalDiffS = round($totalTS - $totalPS, 1);
        @endphp
        <tr>
          <td>UKUPNO</td>
          <td>{{ $totalPD }}</td>
          <td>{{ $totalTD }}</td>
          <td style="color:{{ $totalDiffD > 0 ? '#ffdd8a' : ($totalDiffD < 0 ? '#d4d4d8' : '#f4f4f5') }};">
            {{ $totalDiffD > 0 ? '+' : '' }}{{ $totalDiffD }}
          </td>
          <td class="hide-mobile">{{ $totalPS }}h</td>
          <td class="hide-mobile">{{ $totalTS }}h</td>
          <td class="hide-mobile" style="color:{{ $totalDiffS > 0 ? '#ffdd8a' : ($totalDiffS < 0 ? '#d4d4d8' : '#f4f4f5') }};">
            {{ $totalDiffS > 0 ? '+' : '' }}{{ $totalDiffS }}h
          </td>
        </tr>
      </tfoot>
    </table>
  </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  Chart.defaults.color = 'rgba(244,244,245,0.72)';
  Chart.defaults.borderColor = 'rgba(255,255,255,0.1)';

  var labels = @json($mjesecniPregled->pluck('mjesec_kratki'));
  var dolasci = @json($mjesecniPregled->pluck('dolasci'));
  var sati = @json($mjesecniPregled->pluck('ukupno_minuta')->map(function($m){ return round($m / 60, 1); }));

  var ctx1 = document.getElementById('chartDolasci').getContext('2d');
  var grad1 = ctx1.createLinearGradient(0, 0, 0, 240);
  grad1.addColorStop(0, 'rgba(255,184,0,0.28)');
  grad1.addColorStop(1, 'rgba(255,184,0,0.04)');

  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        { label: 'Dolasci', data: dolasci, backgroundColor: 'rgba(255,184,0,0.76)', borderColor: '#ffb800', borderWidth: 2, borderRadius: 8, borderSkipped: false, yAxisID: 'y', order: 2 },
        { label: 'Sati', data: sati, type: 'line', borderColor: '#f4f4f5', backgroundColor: grad1, borderWidth: 2.5, pointBackgroundColor: '#f4f4f5', pointBorderColor: '#0a0a0a', pointBorderWidth: 2, pointRadius: 4, fill: true, tension: 0.35, yAxisID: 'y1', order: 1 }
      ]
    },
    options: {
      responsive: true, interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, font: { size: 11, weight: '600' } } },
        tooltip: { backgroundColor: '#1C1C1E', padding: 10, cornerRadius: 8 }
      },
      scales: {
        y: { beginAtZero: true, position: 'left', ticks: { stepSize: 1, font: { size: 10 } }, title: { display: true, text: 'Dolasci', font: { size: 10, weight: '600' }, color: '#ffdd8a' } },
        y1: { beginAtZero: true, position: 'right', grid: { display: false }, ticks: { font: { size: 10 } }, title: { display: true, text: 'Sati', font: { size: 10, weight: '600' }, color: '#f4f4f5' } },
        x: { ticks: { font: { size: 11, weight: '600' } }, grid: { display: false } }
      }
    }
  });

  // Dani u sedmici chart
  var daniLabels = @json($daniNazivi);
  var daniData = @json($daniData);
  var maxDan = Math.max(...daniData);
  var daniColors = daniData.map(function(v) { return v === maxDan ? '#ffb800' : 'rgba(161,161,170,0.4)'; });

  new Chart(document.getElementById('chartDani').getContext('2d'), {
    type: 'bar',
    data: {
      labels: daniLabels,
      datasets: [{ label: 'Dolasci', data: daniData, backgroundColor: daniColors, borderRadius: 6, borderSkipped: false }]
    },
    options: {
      responsive: true, indexAxis: 'y',
      plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1C1C1E', padding: 10, cornerRadius: 8 } },
      scales: {
        x: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.08)' } },
        y: { ticks: { font: { size: 11, weight: '600' } }, grid: { display: false } }
      }
    }
  });

  // Godisnja uporedba
  var ycLabels = @json($godisnjiPregled['labels']);
  var ycTD = @json($godisnjiPregled['trenutna']['dolasci']);
  var ycPD = @json($godisnjiPregled['prethodna']['dolasci']);
  var ycTS = @json($godisnjiPregled['trenutna']['sati']);
  var ycPS = @json($godisnjiPregled['prethodna']['sati']);
  var ycTG = {{ $godisnjiPregled['trenutna']['godina'] }};
  var ycPG = {{ $godisnjiPregled['prethodna']['godina'] }};

  var ycOpts = function(suffix) {
    return {
      responsive: true, interaction: { mode: 'index', intersect: false },
      plugins: { legend: { position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 14, font: { size: 11, weight: '600' } } },
        tooltip: { backgroundColor: '#1C1C1E', padding: 10, cornerRadius: 8, callbacks: { label: function(c) { return c.dataset.label + ': ' + c.parsed.y + ' ' + suffix; } } }
      },
      scales: { y: { beginAtZero: true, ticks: { font: { size: 10 } } }, x: { ticks: { font: { size: 10 } }, grid: { display: false } } }
    };
  };

  new Chart(document.getElementById('yearVisits').getContext('2d'), {
    type: 'bar', data: { labels: ycLabels, datasets: [
      { label: ycPG.toString(), data: ycPD, backgroundColor: 'rgba(161,161,170,0.4)', borderColor: '#71717a', borderWidth: 1.5, borderRadius: 5, borderSkipped: false },
      { label: ycTG.toString(), data: ycTD, backgroundColor: 'rgba(255,184,0,0.72)', borderColor: '#ffb800', borderWidth: 1.5, borderRadius: 5, borderSkipped: false }
    ]}, options: ycOpts('posjeta')
  });

  new Chart(document.getElementById('yearHours').getContext('2d'), {
    type: 'bar', data: { labels: ycLabels, datasets: [
      { label: ycPG.toString(), data: ycPS, backgroundColor: 'rgba(161,161,170,0.4)', borderColor: '#71717a', borderWidth: 1.5, borderRadius: 5, borderSkipped: false },
      { label: ycTG.toString(), data: ycTS, backgroundColor: 'rgba(244,244,245,0.7)', borderColor: '#f4f4f5', borderWidth: 1.5, borderRadius: 5, borderSkipped: false }
    ]}, options: ycOpts('sati')
  });
});
</script>
@endsection
