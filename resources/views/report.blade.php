@extends('layouts.report')
@section('content')
<div class="container my-4">

    <div class="border p-5 mb-5">
      <!-- Copy this code to have a working example -->
      <!--Section: Design Block-->
      <section>
        <div class="row">
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
              <div class="card-body">
                <p class="text-uppercase small mb-2">
                  <strong>UKUPNO ČLANOVA</strong>
                </p>
                <h5 class="mb-0">

                  @foreach ($ukupno as $key => $uk)
                  @endforeach
                  @foreach ($aktivni as $key => $data)
                  @endforeach
                  @foreach ($prosli_mjesec as $key => $pm)
                  @endforeach
                  @foreach ($prosli_mjesec_iznos as $key => $pmi)
                  @endforeach
                  <strong>{{$uk->ukupniBroj}}</strong>

                  <small class="text-success ms-2">
                    <i class="fas fa-arrow-up fa-sm pe-1"></i>100 %</small>
                </h5>

                <hr />
                @foreach ($ne as $key => $n)
                @endforeach
                <p class="text-uppercase text-muted small mb-2">
                  UKUPNI IZNOS
                </p>
                <h5 class="text-muted mb-0">{{$uk->Iznos}} KM</h5>
              </div>
            </div>
            <!-- Card -->
          </div>

          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
              <div class="card-body">
                <p class="text-uppercase small mb-2">
                  <strong>TRENUTNO AKTIVNIH ČLANOVA</strong>
                </p>
                <h5 class="mb-0">
                  <strong>{{$data->Aktivni}}</strong>
                  <small class="text-success ms-2">
                    <i class="fas fa-arrow-up fa-sm pe-1"></i>{{round(($data->Aktivni/$uk->ukupniBroj)*100,2)}} %</small>
                </h5>

                <hr />

                <p class="text-uppercase text-muted small mb-2">
                  UKUPNI IZNOS
                </p>
                <h5 class="text-muted mb-0">{{$data->Iznos}} KM</h5>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
              <div class="card-body">
                <p class="text-uppercase small mb-2">
                  <strong>AKTIVNIH ČLANOVA PRETHODNI MJESEC</strong>
                </p>
                <h5 class="mb-0">
                  <strong>{{$pm->NP}}</strong>
                  <small class="text-danger ms-2">
                    <i class="fas fa-arrow-down fa-sm pe-1"></i>{{round(($pm->NP/$uk->ukupniBroj)*100,2)}} %</small>
                </h5>

                <hr />

                <p class="text-uppercase text-muted small mb-2">
                  UKUPNI IZNOS
                </p>
                <h5 class="text-muted mb-0">{{$pmi->IznosP}} KM</h5>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 mb-4">
            <div class="card">
              <div class="card-body">
                <p class="text-uppercase small mb-2">
                  <strong>NEAKTIVNI ČLANOVI</strong>
                </p>
                <h5 class="mb-0">
                  <strong>{{$n->N}}</strong>
                  <small class="text-danger ms-2">
                    <i class="fas fa-arrow-down fa-sm pe-1"></i></small>
                </h5>

                <hr />

                <p class="text-uppercase text-muted small mb-2">
                  Procentualno
                </p>
                <h5 class="text-muted mb-0">{{round(($n->N/$uk->ukupniBroj)*100,2)}} %</h5>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--Section: Design Block-->

      <!--Section:
      <section>
        <div class="row">
          <div class="col-md-8 mb-4">
            <div class="card">
              <div class="card-body">

                <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab"
                      aria-controls="ex1-pills-1" aria-selected="true">Users</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex1-tab-2" data-mdb-toggle="pill" href="#ex1-pills-2" role="tab"
                      aria-controls="ex1-pills-2" aria-selected="false">Page views</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex1-tab-3" data-mdb-toggle="pill" href="#ex1-pills-3" role="tab"
                      aria-controls="ex1-pills-3" aria-selected="false">Average time</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex1-tab-4" data-mdb-toggle="pill" href="#ex1-pills-4" role="tab"
                      aria-controls="ex1-pills-4" aria-selected="false">Bounce rate</a>
                  </li>
                </ul>



                <div class="tab-content" id="ex1-content">
                  <div class="tab-pane fade show active" id="ex1-pills-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                    <div id="chart-users"></div>
                  </div>
                  <div class="tab-pane fade" id="ex1-pills-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                    <div id="chart-page-views"></div>
                  </div>
                  <div class="tab-pane fade" id="ex1-pills-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                    <div id="chart-average-time"></div>
                  </div>
                  <div class="tab-pane fade" id="ex1-pills-4" role="tabpanel" aria-labelledby="ex1-tab-4">
                    <div id="chart-bounce-rate"></div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <div class="col-md-4 mb-4">
            <div class="card mb-4">
              <div class="card-body">
                <p class="text-center"><strong>Current period</strong></p>
                <div id="pie-chart-current"></div>
              </div>
            </div>

            <div class="card">
              <div class="card-body">
                <p class="text-center"><strong>Previous period</strong></p>
                <div id="pie-chart-previous"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
     Section: Content-->
      <!--/ Copy this code to have a working example -->
    </div>

    <!-- Grafički izvještaj -->
    <div class="border p-4 mb-5" style="border-radius:16px;background:#fff;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 style="font-weight:700;color:#1a1a2e;margin-bottom:0;">Aktivni članovi po mjesecima</h5>
        <form method="GET" action="{{ route('report') }}" class="d-flex align-items-center gap-2">
          <label for="year" style="font-weight:600;color:#6c757d;white-space:nowrap;font-size:14px;">Godina:</label>
          <select name="year" id="year" onchange="this.form.submit()" class="form-select" style="width:auto;border-radius:10px;border:2px solid #e0e0e0;font-weight:600;padding:6px 32px 6px 12px;color:#1a1a2e;cursor:pointer;">
            @foreach($dostupneGodine as $god)
              <option value="{{ $god }}" {{ $god == $selectedYear ? 'selected' : '' }}>{{ $god }}</option>
            @endforeach
          </select>
        </form>
      </div>
      <canvas id="mjesecniChart" height="100"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var labels = @json($mjesecni->pluck('mjesec'));
        var data = @json($mjesecni->pluck('broj'));

        var ctx = document.getElementById('mjesecniChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
        gradient.addColorStop(1, 'rgba(102, 126, 234, 0.02)');

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [{
              label: 'Aktivni članovi',
              data: data,
              borderColor: '#667eea',
              backgroundColor: gradient,
              borderWidth: 3,
              pointBackgroundColor: '#667eea',
              pointBorderColor: '#fff',
              pointBorderWidth: 2,
              pointRadius: 5,
              pointHoverRadius: 7,
              fill: true,
              tension: 0.35
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: false },
              tooltip: {
                backgroundColor: '#1a1a2e',
                titleFont: { size: 13, weight: '600' },
                bodyFont: { size: 12 },
                padding: 12,
                cornerRadius: 10,
                callbacks: {
                  label: function(ctx) { return ctx.parsed.y + ' članova'; }
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1,
                  font: { size: 12, weight: '500' },
                  color: '#6c757d'
                },
                grid: { color: 'rgba(0,0,0,0.05)' }
              },
              x: {
                ticks: {
                  font: { size: 11, weight: '500' },
                  color: '#6c757d'
                },
                grid: { display: false }
              }
            }
          }
        });
      });
    </script>

  </div>

  @endsection
