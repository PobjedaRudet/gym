@extends('layouts.report')

@section('content')
<style>
  .att-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 1.5rem;
  }
  .att-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }
  .att-header h4 {
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
  }
  .btn-odjavi-all {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    border: none;
    color: #fff;
    background: linear-gradient(135deg, #dc3545, #e85d6f);
    cursor: pointer;
    transition: transform 0.15s, box-shadow 0.2s;
  }
  .btn-odjavi-all:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
  }
  .att-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    overflow: hidden;
  }
  .att-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.9rem;
  }
  .att-table thead th {
    background: #f8f9fb;
    color: #6c757d;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.9rem 1rem;
    border-bottom: 2px solid #eee;
    white-space: nowrap;
  }
  .att-table tbody tr {
    transition: background 0.15s;
  }
  .att-table tbody tr:hover {
    background: #f0f4ff;
  }
  .att-table tbody td {
    padding: 0.75rem 1rem;
    color: #333;
    border-bottom: 1px solid #f0f0f5;
    vertical-align: middle;
  }
  .att-table .member-name {
    font-weight: 600;
    color: #1a1a2e;
  }
  .gym-pill {
    display: inline-block;
    padding: 0.2rem 0.7rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }
  .gym-pill.gym-1 {
    background: rgba(13, 110, 253, 0.12);
    color: #0d6efd;
  }
  .gym-pill.gym-2 {
    background: rgba(214, 51, 132, 0.12);
    color: #d63384;
  }
  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.2rem 0.7rem;
    border-radius: 50px;
    font-size: 0.78rem;
    font-weight: 600;
  }
  .status-badge.online {
    background: rgba(25, 135, 84, 0.12);
    color: #198754;
  }
  .status-badge.online::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #198754;
    animation: pulse 1.5s infinite;
  }
  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
  }
  .btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.8rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    color: #fff;
    transition: opacity 0.15s;
  }
  .btn-action:hover {
    opacity: 0.85;
    color: #fff;
  }
  .btn-action.odjava {
    background: #ffc107;
    color: #1a1a2e;
  }
  .btn-action.odjava:hover {
    color: #1a1a2e;
  }
  .att-pagination {
    padding: 1rem;
    display: flex;
    justify-content: center;
  }
  .att-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: #6c757d;
    font-size: 1rem;
    font-weight: 500;
  }
</style>

<div class="att-container">
  <div class="att-header">
    <h4>Pregled evidencija</h4>
    <form action="{{ route('odjaviNeaktivne') }}" method="post" style="margin:0;">
      @csrf
      <button type="submit" class="btn-odjavi-all" onclick="return confirm('Da li ste sigurni da želite odjaviti sve neaktivne?')">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M6 12.5a.5.5 0 01.5-.5h3a.5.5 0 010 1h-3a.5.5 0 01-.5-.5zm-2-3a.5.5 0 01.5-.5h7a.5.5 0 010 1h-7a.5.5 0 01-.5-.5zm-2-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5z"/></svg>
        Odjavi neaktivne
      </button>
    </form>
  </div>

  <div class="att-card">
    @if (isset($att) && count($att) > 0)
      <table class="att-table">
        <thead>
          <tr>
            <th>Ime</th>
            <th>Prezime</th>
            <th style="text-align:center">Gym</th>
            <th style="text-align:center">Datum</th>
            <th style="text-align:center">Prijava</th>
            <th style="text-align:center">Odjava</th>
            <th style="text-align:center">Akcija</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($att as $data)
            <tr>
              <td class="member-name">{{ $data->name }}</td>
              <td>{{ $data->surname }}</td>
              <td style="text-align:center">
                <span class="gym-pill {{ $data->gym == 1 ? 'gym-1' : 'gym-2' }}">
                  {{ $data->gym == 1 ? 'Gym' : 'Ladies' }}
                </span>
              </td>
              <td style="text-align:center">{{ date("d.m.Y", strtotime($data->in)) }}</td>
              <td style="text-align:center">{{ date("H:i:s", strtotime($data->in)) }}</td>
              <td style="text-align:center">
                @if ($data->out == null)
                  <span class="status-badge online">Prijavljen</span>
                @else
                  {{ date("H:i:s", strtotime($data->out)) }}
                @endif
              </td>
              <td style="text-align:center">
                <a href="{{ route('odjava', $data->id) }}" class="btn-action odjava">Odjavi</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="att-pagination">
        {{ $att->links('pagination::bootstrap-4') }}
      </div>
    @else
      <div class="att-empty">Nema prijavljenih članova.</div>
    @endif
  </div>
</div>
@endsection
