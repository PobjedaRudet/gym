@extends('layouts.report')
@section('content')
<style>
  .comp-container { max-width: 1200px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
  .comp-header {
    background: linear-gradient(135deg, #1C1C1E 0%, #2C2C2E 50%, #1C1C1E 100%);
    border-radius: 20px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
  }
  .comp-header::before {
    content: '';
    position: absolute;
    top: -60%;
    right: -10%;
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(255,55,95,0.12) 0%, transparent 70%);
    border-radius: 50%;
  }
  .comp-header h2 {
    color: #fff;
    font-weight: 800;
    font-size: 1.6rem;
    margin: 0;
  }
  .comp-header p {
    color: rgba(255,255,255,0.55);
    font-size: 14px;
    margin: 6px 0 0;
  }
  .yearly-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 1.25rem;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
  }
  .yearly-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
  }
  .yearly-card .year-badge {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 10px;
  }
  .yearly-card .stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid #f3f3f3;
    font-size: 13px;
  }
  .yearly-card .stat-row:last-child { border-bottom: none; }
  .yearly-card .stat-row .label { color: #6c757d; font-weight: 500; }
  .yearly-card .stat-row .val { color: #1C1C1E; font-weight: 700; }
  .chart-box {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }
  .chart-title {
    font-weight: 700;
    font-size: 15px;
    color: #1C1C1E;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .chart-title .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
  }
  .detail-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13px;
  }
  .detail-table thead th {
    background: #f8f8fa;
    color: #6c757d;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 11px;
    padding: 10px 12px;
    border-bottom: 2px solid #e8ecf4;
    position: sticky;
    top: 0;
  }
  .detail-table thead th:first-child { border-radius: 10px 0 0 0; }
  .detail-table thead th:last-child { border-radius: 0 10px 0 0; }
  .detail-table tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid #f3f3f3;
    color: #1C1C1E;
    font-weight: 500;
  }
  .detail-table tbody tr:hover td { background: #f8f8fa; }
  .detail-table tbody tr:last-child td { border-bottom: none; }
  .detail-table .month-col { font-weight: 700; color: #FF375F; }
  .best-val { background: #d1fae5; color: #065f46; border-radius: 6px; padding: 2px 8px; font-weight: 700; }
  .worst-val { background: #fee2e2; color: #991b1b; border-radius: 6px; padding: 2px 8px; font-weight: 700; }
  .tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    border: 2px solid #e0e0e0;
    background: #fff;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.2s;
  }
  .tab-btn:hover { border-color: #FF375F; color: #FF375F; }
  .tab-btn.active { background: linear-gradient(135deg,#FF375F,#FF6482); color: #fff; border-color: transparent; }
  .heatmap-cell {
    text-align: center;
    font-weight: 700;
    font-size: 13px;
    padding: 8px 6px;
    border-radius: 6px;
    min-width: 40px;
  }
</style>

<div class="comp-container">

  <!-- Header -->
  <div class="comp-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div>
        <h2>Detaljna statistika</h2>
        <p>Detaljan pregled i usporedba po svim godinama i mjesecima</p>
      </div>
      <a href="{{ route('report') }}" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);color:#fff;border-radius:12px;padding:10px 20px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Izvještaj
      </a>
    </div>
  </div>

  <!-- Godišnji pregled kartice -->
  <div class="row g-3 mb-4">
    @php
      $boje = ['#FF375F','#30D158','#5AC8FA','#FF9F0A','#BF5AF2','#64D2FF','#FF6482','#AC8E68'];
    @endphp
    @foreach($dostupneGodine as $i => $god)
    <div class="col-lg-3 col-md-4 col-sm-6">
      <div class="yearly-card">
        <span class="year-badge" style="background:{{ $boje[$i % count($boje)] }}20;color:{{ $boje[$i % count($boje)] }};">{{ $god }}</span>
        <div class="stat-row">
          <span class="label">Dolasci</span>
          <span class="val">{{ number_format($godisnjeTotali[$god]['dolasci']) }}</span>
        </div>
        <div class="stat-row">
          <span class="label">Sati</span>
          <span class="val">{{ number_format($godisnjeTotali[$god]['sati'], 1) }}h</span>
        </div>
        <div class="stat-row">
          <span class="label">Prosjek/posjeta</span>
          <span class="val">{{ floor($godisnjeTotali[$god]['prosjek_min'] / 60) }}h {{ $godisnjeTotali[$god]['prosjek_min'] % 60 }}m</span>
        </div>
        <div class="stat-row">
          <span class="label">Članova</span>
          <span class="val">{{ $godisnjeTotali[$god]['clanova'] }}</span>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Tabovi za tipove grafikona -->
  <div class="d-flex gap-2 mb-4 flex-wrap">
    <button class="tab-btn active" onclick="switchTab('dolasci', this)">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
      Dolasci
    </button>
    <button class="tab-btn" onclick="switchTab('sati', this)">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
      Sati u gym-u
    </button>
    <button class="tab-btn" onclick="switchTab('clanovi', this)">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>
      Aktivni članovi
    </button>
  </div>

  <!-- Grafikoni -->
  <div class="chart-box" id="chart-dolasci-box">
    <div class="chart-title">
      <span class="dot" style="background:#FF375F;"></span>
      Dolasci po mjesecima — sve godine
    </div>
    <canvas id="chartDolasci" height="90"></canvas>
  </div>

  <div class="chart-box" id="chart-sati-box" style="display:none;">
    <div class="chart-title">
      <span class="dot" style="background:#30D158;"></span>
      Sati u teretani po mjesecima — sve godine
    </div>
    <canvas id="chartSati" height="90"></canvas>
  </div>

  <div class="chart-box" id="chart-clanovi-box" style="display:none;">
    <div class="chart-title">
      <span class="dot" style="background:#5AC8FA;"></span>
      Aktivni članovi po mjesecima — sve godine
    </div>
    <canvas id="chartClanovi" height="90"></canvas>
  </div>

  <!-- Heatmap tabela -->
  <div class="chart-box">
    <div class="chart-title">
      <span class="dot" style="background:#FF9F0A;"></span>
      Heatmap dolazaka
    </div>
    <div style="overflow-x:auto;">
      <table class="detail-table">
        <thead>
          <tr>
            <th>Godina</th>
            @foreach($mjesecnaImena as $mj)
            <th style="text-align:center;">{{ $mj }}</th>
            @endforeach
            <th style="text-align:center;">Ukupno</th>
          </tr>
        </thead>
        <tbody>
          @php
            $allValues = collect($dolasciPoGodinama)->flatten();
            $globalMax = $allValues->max() ?: 1;
          @endphp
          @foreach($dostupneGodine as $god)
          <tr>
            <td class="month-col">{{ $god }}</td>
            @foreach($dolasciPoGodinama[$god] as $val)
              @php
                $intensity = $globalMax > 0 ? ($val / $globalMax) : 0;
                if ($val == 0) $bg = '#f9fafb';
                elseif ($intensity <= 0.25) $bg = '#FFE5EA';
                elseif ($intensity <= 0.5) $bg = '#FF9AAD';
                elseif ($intensity <= 0.75) $bg = '#FF6482';
                else $bg = '#FF375F';
                $color = $intensity > 0.5 ? '#fff' : '#1C1C1E';
              @endphp
              <td class="heatmap-cell" style="background:{{ $bg }};color:{{ $color }};">{{ $val }}</td>
            @endforeach
            <td style="text-align:center;font-weight:800;color:#FF375F;">{{ array_sum($dolasciPoGodinama[$god]) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Detaljna tabela po godinama -->
  <div class="chart-box">
    <div class="chart-title">
      <span class="dot" style="background:#FF375F;"></span>
      Detaljni podaci po mjesecima
    </div>
    <div class="d-flex gap-2 mb-3 flex-wrap">
      @foreach($dostupneGodine as $i => $god)
      <button class="tab-btn {{ $loop->last ? 'active' : '' }}" onclick="switchDetailYear({{ $god }}, this)">{{ $god }}</button>
      @endforeach
    </div>

    @foreach($dostupneGodine as $god)
    <div class="detail-year-table" id="detail-{{ $god }}" style="{{ $loop->last ? '' : 'display:none;' }}">
      <div style="overflow-x:auto;">
        <table class="detail-table">
          <thead>
            <tr>
              <th>Mjesec</th>
              <th style="text-align:center;">Dolasci</th>
              <th style="text-align:center;">Ukupno sati</th>
              <th style="text-align:center;">Prosjek/posjeta</th>
              <th style="text-align:center;">Aktivni članovi</th>
              <th style="text-align:center;">Napredak</th>
            </tr>
          </thead>
          <tbody>
            @php
              $maxDol = max($dolasciPoGodinama[$god]) ?: 1;
              $prevDol = 0;
            @endphp
            @foreach($mjesecnaImena as $mi => $mj)
            @php
              $dol = $dolasciPoGodinama[$god][$mi];
              $vr = $vrijemePoGodinama[$god][$mi];
              $pr = $prosjekPoGodinama[$god][$mi];
              $ak = $aktivniPoGodinama[$god][$mi];
              $barPerc = round(($dol / $maxDol) * 100);
              $diff = $mi > 0 ? $dol - $dolasciPoGodinama[$god][$mi - 1] : 0;
            @endphp
            <tr>
              <td class="month-col">{{ $mj }}</td>
              <td style="text-align:center;">
                @if($dol == max($dolasciPoGodinama[$god]) && $dol > 0)
                  <span class="best-val">{{ $dol }}</span>
                @elseif($dol == min($dolasciPoGodinama[$god]) && $dol > 0 && min($dolasciPoGodinama[$god]) != max($dolasciPoGodinama[$god]))
                  <span class="worst-val">{{ $dol }}</span>
                @else
                  {{ $dol }}
                @endif
              </td>
              <td style="text-align:center;">{{ $vr }}h</td>
              <td style="text-align:center;">{{ floor($pr / 60) }}h {{ $pr % 60 }}m</td>
              <td style="text-align:center;">{{ $ak }}</td>
              <td>
                <div style="display:flex;align-items:center;gap:8px;">
                  <div style="flex:1;background:#e8ecf4;border-radius:6px;height:8px;overflow:hidden;">
                    <div style="width:{{ $barPerc }}%;height:100%;border-radius:6px;background:linear-gradient(90deg,#FF375F,#FF6482);"></div>
                  </div>
                  @if($mi > 0)
                    @if($diff > 0)
                      <span style="font-size:11px;color:#30D158;font-weight:700;">+{{ $diff }}</span>
                    @elseif($diff < 0)
                      <span style="font-size:11px;color:#FF375F;font-weight:700;">{{ $diff }}</span>
                    @else
                      <span style="font-size:11px;color:#8E8E93;font-weight:700;">—</span>
                    @endif
                  @endif
                </div>
              </td>
            </tr>
            @endforeach
            <tr style="background:#f8f8fa;">
              <td style="font-weight:800;color:#1C1C1E;">UKUPNO</td>
              <td style="text-align:center;font-weight:800;color:#FF375F;">{{ array_sum($dolasciPoGodinama[$god]) }}</td>
              <td style="text-align:center;font-weight:800;color:#30D158;">{{ array_sum($vrijemePoGodinama[$god]) }}h</td>
              <td style="text-align:center;font-weight:700;color:#8E8E93;">—</td>
              <td style="text-align:center;font-weight:700;color:#8E8E93;">—</td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    @endforeach
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
  var labels = @json($mjesecnaImena);
  var boje = ['#FF375F','#30D158','#5AC8FA','#FF9F0A','#BF5AF2','#64D2FF','#FF6482','#AC8E68'];
  var bojeTransparent = ['rgba(255,55,95,0.15)','rgba(48,209,88,0.15)','rgba(90,200,250,0.15)','rgba(255,159,10,0.15)','rgba(191,90,242,0.15)','rgba(100,210,255,0.15)','rgba(255,100,130,0.15)','rgba(172,142,104,0.15)'];
  var godine = @json($dostupneGodine);
  var dolasciData = @json($dolasciPoGodinama);
  var vrijemeData = @json($vrijemePoGodinama);
  var aktivniData = @json($aktivniPoGodinama);

  function makeDatasets(sourceData, type) {
    return godine.map(function(god, i) {
      var data = sourceData[god];
      var color = boje[i % boje.length];
      if (type === 'bar') {
        return {
          label: god.toString(),
          data: data,
          backgroundColor: color + 'CC',
          borderColor: color,
          borderWidth: 1,
          borderRadius: 6,
          borderSkipped: false
        };
      }
      return {
        label: god.toString(),
        data: data,
        borderColor: color,
        backgroundColor: bojeTransparent[i % bojeTransparent.length],
        borderWidth: 2.5,
        pointBackgroundColor: color,
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6,
        fill: true,
        tension: 0.3
      };
    });
  }

  var chartOpts = {
    responsive: true,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: {
        position: 'top',
        labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, font: { size: 12, weight: '600' } }
      },
      tooltip: {
        backgroundColor: '#1C1C1E',
        titleFont: { size: 13, weight: '600' },
        bodyFont: { size: 12 },
        padding: 12,
        cornerRadius: 10
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { font: { size: 11, weight: '500' }, color: '#6c757d' },
        grid: { color: 'rgba(0,0,0,0.04)' }
      },
      x: {
        ticks: { font: { size: 12, weight: '600' }, color: '#6c757d' },
        grid: { display: false }
      }
    }
  };

  // Dolasci chart
  new Chart(document.getElementById('chartDolasci').getContext('2d'), {
    type: 'bar',
    data: { labels: labels, datasets: makeDatasets(dolasciData, 'bar') },
    options: chartOpts
  });

  // Sati chart
  new Chart(document.getElementById('chartSati').getContext('2d'), {
    type: 'line',
    data: { labels: labels, datasets: makeDatasets(vrijemeData, 'line') },
    options: chartOpts
  });

  // Aktivi chart
  new Chart(document.getElementById('chartClanovi').getContext('2d'), {
    type: 'line',
    data: { labels: labels, datasets: makeDatasets(aktivniData, 'line') },
    options: chartOpts
  });

  function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(function(b) {
      if (b.closest('.chart-box')) return;
      b.classList.remove('active');
    });
    btn.classList.add('active');
    document.getElementById('chart-dolasci-box').style.display = tab === 'dolasci' ? '' : 'none';
    document.getElementById('chart-sati-box').style.display = tab === 'sati' ? '' : 'none';
    document.getElementById('chart-clanovi-box').style.display = tab === 'clanovi' ? '' : 'none';
  }

  function switchDetailYear(year, btn) {
    btn.parentElement.querySelectorAll('.tab-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('.detail-year-table').forEach(function(el) { el.style.display = 'none'; });
    document.getElementById('detail-' + year).style.display = '';
  }
</script>

@endsection
