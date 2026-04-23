@extends('member.layout')
@section('styles')
<style>
  .page-title {
    font-size: 1.4rem; font-weight: 800; color: #1a1a1a; margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 10px;
  }
  .page-title svg { color: #FF375F; }

  .stat-card {
    background: #fff; border: 1px solid rgba(0,0,0,0.06);
    border-radius: 14px; padding: 1.25rem; text-align: center;
    transition: transform 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
  }
  .stat-card:hover { transform: translateY(-2px); }
  .stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 8px;
  }
  .stat-value { font-size: 1.4rem; font-weight: 800; color: #1a1a1a; margin: 0; }
  .stat-label {
    font-size: 10px; font-weight: 700; color: #888;
    text-transform: uppercase; letter-spacing: 0.8px;
  }
  .stat-sub { font-size: 11px; color: #888; font-weight: 500; margin-top: 2px; }

  .section-title {
    font-weight: 700; font-size: 15px; color: #1a1a1a;
    margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;
  }
  .section-title .dot {
    width: 8px; height: 8px; border-radius: 50%; display: inline-block;
  }

  .glass-panel {
    background: #fff; border: 1px solid rgba(0,0,0,0.06);
    border-radius: 16px; padding: 1.25rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
  }

  .progress-wrap { margin-bottom: 16px; }
  .progress-header {
    display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;
  }
  .progress-title { font-weight: 700; font-size: 13px; color: #1a1a1a; }
  .progress-value { font-weight: 800; font-size: 14px; }
  .progress-bar-bg {
    background: #eee; border-radius: 10px; height: 12px; overflow: hidden;
  }
  .progress-bar-fill {
    height: 100%; border-radius: 10px; transition: width 0.8s ease; position: relative;
  }
  .progress-bar-fill span {
    position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
    font-size: 9px; font-weight: 700; color: #fff;
  }
  .progress-msg { margin: 4px 0 0; font-size: 11px; font-weight: 600; }

  .month-row {
    padding: 10px 0; border-bottom: 1px solid rgba(0,0,0,0.04);
  }
  .month-row:last-child { border-bottom: none; }
  .month-name { font-size: 13px; font-weight: 600; color: #555; }
  .month-name.tekuci { color: #FF375F; font-weight: 700; }
  .month-stats { font-size: 11px; color: #888; font-weight: 500; }
  .month-bar-bg {
    background: #eee; border-radius: 6px; height: 6px; overflow: hidden; margin-top: 4px;
  }
  .month-bar-fill { height: 100%; border-radius: 6px; transition: width 0.6s ease; }

  .week-card {
    background: #fff; border: 1px solid rgba(0,0,0,0.06);
    border-radius: 12px; padding: 1rem; text-align: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
  }
  .week-card.tekuca { border-color: rgba(255,55,95,0.4); background: rgba(255,55,95,0.04); }
  .week-label { font-size: 11px; font-weight: 600; color: #888; margin-bottom: 6px; }
  .week-value { font-size: 1.1rem; font-weight: 800; color: #1a1a1a; }
  .week-sub { font-size: 10px; color: #aaa; }

  .year-table {
    width: 100%; border-collapse: separate; border-spacing: 0;
    border-radius: 12px; overflow: hidden; font-size: 12px;
  }
  .year-table thead tr {
    background: linear-gradient(135deg, #1C1C1E, #2C2C2E); color: #fff;
  }
  .year-table th { padding: 10px 8px; font-weight: 700; text-align: center; }
  .year-table th:first-child { text-align: left; padding-left: 14px; }
  .year-table td { padding: 8px; text-align: center; border-bottom: 1px solid rgba(0,0,0,0.04); color: #333; }
  .year-table td:first-child { text-align: left; padding-left: 14px; font-weight: 600; color: #555; }
  .year-table tbody tr:hover { background: rgba(0,0,0,0.015); }
  .year-table tfoot tr {
    background: linear-gradient(135deg, #1C1C1E, #2C2C2E); color: #fff; font-weight: 700;
  }

  @media (max-width: 767.98px) {
    .stat-value { font-size: 1.1rem; }
    .stat-icon { width: 36px; height: 36px; }
    .stat-card { padding: 1rem 0.5rem; }
    .page-title { font-size: 1.1rem; }
    .year-table { font-size: 10px; }
    .year-table th, .year-table td { padding: 6px 4px; }
    .hide-mobile { display: none !important; }
  }
</style>
@endsection

@section('content')
<div style="max-width:1000px;">

  <div class="page-title">
    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
    Statistika treninga
  </div>

  <!-- Stat Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#FF375F,#FF6482);">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <p class="stat-value">{{ $ukupnoDolazaka }}</p>
        <p class="stat-label">Ukupno dolazaka</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#30D158,#4ADE80);">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <p class="stat-value">{{ $trenutniMjesec }}</p>
        <p class="stat-label">Ovaj mjesec</p>
        @if($prethodniMjesec > 0)
          @php $promjena = round((($trenutniMjesec - $prethodniMjesec) / $prethodniMjesec) * 100); @endphp
          <p class="stat-sub" style="color:{{ $promjena >= 0 ? '#30D158' : '#FF375F' }};font-weight:600;">
            {{ $promjena >= 0 ? '+' : '' }}{{ $promjena }}% vs prethodni
          </p>
        @endif
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#5AC8FA,#64D2FF);">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <p class="stat-value">{{ floor($vrijemeUkupno->ukupno / 60) }}<span style="font-size:0.7em;font-weight:600;">h</span></p>
        <p class="stat-label">Ukupno sati</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#FF9F0A,#FFB340);">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <p class="stat-value">{{ floor($vrijemeUkupno->prosjek) }}<span style="font-size:0.7em;font-weight:600;">min</span></p>
        <p class="stat-label">Prosjek / trening</p>
      </div>
    </div>
  </div>

  <!-- Ciljevi -->
  <div class="section-title">
    <span class="dot" style="background:linear-gradient(135deg,#FF375F,#FF6482);"></span>
    Mjesečni ciljevi
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="glass-panel">
        @php $progresDolasci = min(round(($trenutniMjesec / $ciljDolazaka) * 100), 100); @endphp
        <div class="progress-wrap">
          <div class="progress-header">
            <span class="progress-title">Dolasci ovog mjeseca</span>
            <span class="progress-value" style="color:#FF375F;">{{ $trenutniMjesec }} / {{ $ciljDolazaka }}</span>
          </div>
          <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width:{{ $progresDolasci }}%;background:linear-gradient(90deg,#FF375F,#FF6482);">
              @if($progresDolasci > 15)<span>{{ $progresDolasci }}%</span>@endif
            </div>
          </div>
          <p class="progress-msg" style="color:{{ $progresDolasci >= 80 ? '#30D158' : ($progresDolasci >= 50 ? '#FF9F0A' : '#FF375F') }};">
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
            <span class="progress-value" style="color:#30D158;">{{ floor($vrijemeTrenutni->ukupno / 60) }}h / {{ floor($ciljMinuta / 60) }}h</span>
          </div>
          <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width:{{ $progresVrijeme }}%;background:linear-gradient(90deg,#30D158,#4ADE80);">
              @if($progresVrijeme > 15)<span>{{ $progresVrijeme }}%</span>@endif
            </div>
          </div>
          <p class="progress-msg" style="color:{{ $progresVrijeme >= 80 ? '#30D158' : ($progresVrijeme >= 50 ? '#FF9F0A' : '#FF375F') }};">
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
    <span class="dot" style="background:linear-gradient(135deg,#5AC8FA,#64D2FF);"></span>
    Vrijeme boravka u teretani
  </div>
  <div class="row g-3 mb-4">
    <div class="col-4">
      <div class="stat-card">
        <p class="stat-label">Ukupno</p>
        <p class="stat-value" style="font-size:1.1rem;">{{ floor($vrijemeUkupno->ukupno / 60) }}h {{ $vrijemeUkupno->ukupno % 60 }}m</p>
        <p class="stat-sub">Prosjek: {{ floor($vrijemeUkupno->prosjek) }}min</p>
      </div>
    </div>
    <div class="col-4">
      <div class="stat-card">
        <p class="stat-label">Ovaj mjesec</p>
        <p class="stat-value" style="font-size:1.1rem;">{{ floor($vrijemeTrenutni->ukupno / 60) }}h {{ $vrijemeTrenutni->ukupno % 60 }}m</p>
        <p class="stat-sub">Prosjek: {{ floor($vrijemeTrenutni->prosjek) }}min</p>
      </div>
    </div>
    <div class="col-4">
      <div class="stat-card">
        <p class="stat-label">Prethodni mjesec</p>
        <p class="stat-value" style="font-size:1.1rem;">{{ floor($vrijemeProthodni->ukupno / 60) }}h {{ $vrijemeProthodni->ukupno % 60 }}m</p>
        <p class="stat-sub">Prosjek: {{ floor($vrijemeProthodni->prosjek) }}min</p>
      </div>
    </div>
  </div>

  <!-- Sedmicni pregled -->
  <div class="section-title">
    <span class="dot" style="background:linear-gradient(135deg,#FF9F0A,#FFB340);"></span>
    Sedmični pregled
  </div>
  <div class="row g-3 mb-4">
    @foreach($sedmicniPregled as $sed)
    <div class="col-6 col-md-3">
      <div class="week-card {{ $sed['tekuca'] ? 'tekuca' : '' }}">
        <p class="week-label">
          {{ $sed['label'] }}
          @if($sed['tekuca']) <span style="font-size:9px;background:#FF375F;color:#fff;padding:2px 6px;border-radius:5px;margin-left:2px;">Sada</span> @endif
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
        <p style="font-weight:700;font-size:14px;color:#1a1a1a;margin-bottom:16px;">Dolasci po mjesecima</p>
        <canvas id="chartDolasci" height="240"></canvas>
      </div>
    </div>
    <div class="col-md-5">
      <div class="glass-panel">
        <p style="font-weight:700;font-size:14px;color:#1a1a1a;margin-bottom:16px;">Dani u sedmici</p>
        <canvas id="chartDani" height="240"></canvas>
      </div>
    </div>
  </div>

  <!-- Mjesecna usporedba -->
  <div class="section-title">
    <span class="dot" style="background:linear-gradient(135deg,#FF375F,#FF6482);"></span>
    Mjesečna usporedba (6 mjeseci)
  </div>
  <div class="glass-panel mb-4">
    @foreach($mjesecniPregled as $mp)
    <div class="month-row">
      <div class="d-flex justify-content-between align-items-center">
        <span class="month-name {{ $mp['tekuci'] ? 'tekuci' : '' }}">
          {{ $mp['mjesec'] }}
          @if($mp['tekuci']) <span style="font-size:9px;background:#FF375F;color:#fff;padding:2px 6px;border-radius:5px;margin-left:4px;">Sada</span> @endif
        </span>
        <span class="month-stats">{{ $mp['dolasci'] }} posjeta &middot; {{ floor($mp['ukupno_minuta'] / 60) }}h {{ $mp['ukupno_minuta'] % 60 }}m</span>
      </div>
      @php
        $maxDolasci = $mjesecniPregled->max('dolasci') ?: 1;
        $barPerc = round(($mp['dolasci'] / $maxDolasci) * 100);
        $percCilja = min(round(($mp['dolasci'] / $ciljDolazaka) * 100), 100);
      @endphp
      <div class="d-flex align-items-center gap-2 mt-1">
        <span style="font-size:11px;font-weight:700;color:{{ $percCilja >= 80 ? '#30D158' : ($percCilja >= 50 ? '#FF9F0A' : '#FF375F') }};min-width:32px;">{{ $percCilja }}%</span>
        <div class="month-bar-bg flex-grow-1">
          <div class="month-bar-fill" style="width:{{ $barPerc }}%;background:linear-gradient(90deg,{{ $mp['tekuci'] ? '#FF375F,#FF6482' : '#ccc,#bbb' }});"></div>
        </div>
      </div>
      @if($mp['prosjek_minuta'] > 0)
      <p style="margin:2px 0 0;font-size:10px;color:#aaa;">Prosjek po posjeti: {{ floor($mp['prosjek_minuta'] / 60) }}h {{ $mp['prosjek_minuta'] % 60 }}m</p>
      @endif
    </div>
    @endforeach
  </div>

  <!-- Godisnja uporedba -->
  <div class="section-title">
    <span class="dot" style="background:linear-gradient(135deg,#FF375F,#FF6482);"></span>
    Uporedba godina — {{ $godisnjiPregled['prethodna']['godina'] }} vs {{ $godisnjiPregled['trenutna']['godina'] }}
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="glass-panel">
        <p style="font-weight:700;font-size:13px;color:#1a1a1a;margin-bottom:12px;">Dolasci po mjesecima</p>
        <canvas id="yearVisits" height="240"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="glass-panel">
        <p style="font-weight:700;font-size:13px;color:#1a1a1a;margin-bottom:12px;">Provedeno vrijeme (sati)</p>
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
        <tr style="{{ $isTekuci ? 'background:rgba(255,55,95,0.08);' : '' }}">
          <td style="font-weight:{{ $isTekuci ? '700' : '600' }};{{ $isTekuci ? 'color:#FF375F;' : '' }}">
            {{ $mjesecPuni[$label] ?? $label }}
            @if($isTekuci) <span style="font-size:8px;background:#FF375F;color:#fff;padding:1px 5px;border-radius:4px;margin-left:3px;">Sada</span> @endif
          </td>
          <td style="color:#8E8E93;font-weight:600;">{{ $pD }}</td>
          <td style="color:#FF375F;font-weight:700;">{{ $tD }}</td>
          <td style="font-weight:700;color:{{ $diffD > 0 ? '#30D158' : ($diffD < 0 ? '#FF375F' : '#aaa') }};">
            {{ $diffD > 0 ? '+' : '' }}{{ $diffD }}
          </td>
          <td class="hide-mobile" style="color:#8E8E93;font-weight:600;">{{ $pS }}h</td>
          <td class="hide-mobile" style="color:#30D158;font-weight:700;">{{ $tS }}h</td>
          <td class="hide-mobile" style="font-weight:700;color:{{ $diffS > 0 ? '#30D158' : ($diffS < 0 ? '#FF375F' : '#aaa') }};">
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
          <td style="color:{{ $totalDiffD > 0 ? '#30D158' : ($totalDiffD < 0 ? '#FF375F' : '#fff') }};">
            {{ $totalDiffD > 0 ? '+' : '' }}{{ $totalDiffD }}
          </td>
          <td class="hide-mobile">{{ $totalPS }}h</td>
          <td class="hide-mobile">{{ $totalTS }}h</td>
          <td class="hide-mobile" style="color:{{ $totalDiffS > 0 ? '#30D158' : ($totalDiffS < 0 ? '#FF375F' : '#fff') }};">
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
  Chart.defaults.color = 'rgba(0,0,0,0.5)';
  Chart.defaults.borderColor = 'rgba(0,0,0,0.06)';

  var labels = @json($mjesecniPregled->pluck('mjesec_kratki'));
  var dolasci = @json($mjesecniPregled->pluck('dolasci'));
  var sati = @json($mjesecniPregled->pluck('ukupno_minuta')->map(function($m){ return round($m / 60, 1); }));

  var ctx1 = document.getElementById('chartDolasci').getContext('2d');
  var grad1 = ctx1.createLinearGradient(0, 0, 0, 240);
  grad1.addColorStop(0, 'rgba(48,209,88,0.25)');
  grad1.addColorStop(1, 'rgba(48,209,88,0.02)');

  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        { label: 'Dolasci', data: dolasci, backgroundColor: 'rgba(255,55,95,0.7)', borderColor: '#FF375F', borderWidth: 2, borderRadius: 8, borderSkipped: false, yAxisID: 'y', order: 2 },
        { label: 'Sati', data: sati, type: 'line', borderColor: '#30D158', backgroundColor: grad1, borderWidth: 2.5, pointBackgroundColor: '#30D158', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4, fill: true, tension: 0.35, yAxisID: 'y1', order: 1 }
      ]
    },
    options: {
      responsive: true, interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, font: { size: 11, weight: '600' } } },
        tooltip: { backgroundColor: '#1C1C1E', padding: 10, cornerRadius: 8 }
      },
      scales: {
        y: { beginAtZero: true, position: 'left', ticks: { stepSize: 1, font: { size: 10 } }, title: { display: true, text: 'Dolasci', font: { size: 10, weight: '600' }, color: '#FF375F' } },
        y1: { beginAtZero: true, position: 'right', grid: { display: false }, ticks: { font: { size: 10 } }, title: { display: true, text: 'Sati', font: { size: 10, weight: '600' }, color: '#30D158' } },
        x: { ticks: { font: { size: 11, weight: '600' } }, grid: { display: false } }
      }
    }
  });

  // Dani u sedmici chart
  var daniLabels = @json($daniNazivi);
  var daniData = @json($daniData);
  var maxDan = Math.max(...daniData);
  var daniColors = daniData.map(function(v) { return v === maxDan ? '#FF375F' : 'rgba(255,55,95,0.35)'; });

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
        x: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
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
      { label: ycPG.toString(), data: ycPD, backgroundColor: 'rgba(255,55,95,0.3)', borderColor: '#FF6482', borderWidth: 1.5, borderRadius: 5, borderSkipped: false },
      { label: ycTG.toString(), data: ycTD, backgroundColor: 'rgba(255,55,95,0.7)', borderColor: '#FF375F', borderWidth: 1.5, borderRadius: 5, borderSkipped: false }
    ]}, options: ycOpts('posjeta')
  });

  new Chart(document.getElementById('yearHours').getContext('2d'), {
    type: 'bar', data: { labels: ycLabels, datasets: [
      { label: ycPG.toString(), data: ycPS, backgroundColor: 'rgba(48,209,88,0.3)', borderColor: '#4ADE80', borderWidth: 1.5, borderRadius: 5, borderSkipped: false },
      { label: ycTG.toString(), data: ycTS, backgroundColor: 'rgba(48,209,88,0.6)', borderColor: '#30D158', borderWidth: 1.5, borderRadius: 5, borderSkipped: false }
    ]}, options: ycOpts('sati')
  });
});
</script>
@endsection
