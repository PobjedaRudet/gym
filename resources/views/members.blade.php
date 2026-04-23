@extends('layouts.report')

@section('content')
<style>
  .members-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 1.5rem;
  }
  .members-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }
  .members-header h4 {
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
  }
  .members-actions {
    display: flex;
    gap: 0.5rem;
  }
  .members-actions .btn-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    color: #fff;
    transition: transform 0.15s, box-shadow 0.2s;
    cursor: pointer;
  }
  .members-actions .btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    color: #fff;
  }
  .btn-modern.btn-search {
    background: linear-gradient(135deg, #0d6efd, #6ea8fe);
  }
  .btn-modern.btn-create {
    background: linear-gradient(135deg, #198754, #20c997);
  }
  .members-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    overflow: hidden;
  }
  .members-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.9rem;
  }
  .members-table thead th {
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
  .members-table tbody tr {
    transition: background 0.15s;
  }
  .members-table tbody tr:hover {
    background: #f0f4ff;
  }
  .members-table tbody td {
    padding: 0.75rem 1rem;
    color: #333;
    border-bottom: 1px solid #f0f0f5;
    vertical-align: middle;
  }
  .members-table .member-name {
    font-weight: 600;
    color: #1a1a2e;
  }
  .members-table .code-badge {
    display: inline-block;
    background: #f0f0f5;
    padding: 0.2rem 0.6rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    color: #495057;
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
  .btn-action.edit {
    background: #ffc107;
    color: #1a1a2e;
  }
  .btn-action.edit:hover {
    color: #1a1a2e;
  }
  .btn-action.profile {
    background: linear-gradient(135deg, #667eea, #764ba2);
  }
  .btn-action.fee {
    background: linear-gradient(135deg, #198754, #20c997);
  }
  .btn-action.delete {
    background: linear-gradient(135deg, #dc3545, #e85d6f);
    cursor: pointer;
  }
  .members-pagination {
    padding: 1rem;
    display: flex;
    justify-content: center;
  }
  .members-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: #6c757d;
    font-size: 1rem;
    font-weight: 500;
  }
  @media (max-width: 768px) {
    .members-header {
      flex-direction: column;
      align-items: stretch;
    }
    .members-actions {
      justify-content: flex-end;
    }
    .members-table thead th,
    .members-table tbody td {
      padding: 0.5rem 0.6rem;
      font-size: 0.8rem;
    }
  }
</style>

<div class="members-container">
  <div class="members-header">
    <h4>Članovi</h4>
    <div class="members-actions">
      <a href="{{ route('search') }}" class="btn-modern btn-search">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 10-1.397 1.398h-.001l3.85 3.85a1 1 0 001.415-1.414l-3.85-3.85zm-5.242.156a5 5 0 110-10 5 5 0 010 10z"/></svg>
        Pretraga
      </a>
      <a href="{{ route('createMember') }}" class="btn-modern btn-create">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 01.5.5v3h3a.5.5 0 010 1h-3v3a.5.5 0 01-1 0v-3h-3a.5.5 0 010-1h3v-3A.5.5 0 018 4z"/></svg>
        Kreiraj člana
      </a>
    </div>
  </div>

  <div class="members-card">
    @if (isset($stanje) && count($stanje) > 0)
      <table class="members-table">
        <thead>
          <tr>
            <th>Ime</th>
            <th>Prezime</th>
            <th style="text-align:center">Code</th>
            <th style="text-align:center">Grad</th>
            <th style="text-align:center">Akcije</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($stanje as $data)
            <tr>
              <td class="member-name">{{ $data->name }}</td>
              <td>{{ $data->surname }}</td>
              <td style="text-align:center"><span class="code-badge">{{ $data->code }}</span></td>
              <td style="text-align:center">{{ $data->city }}</td>
              <td style="text-align:center;white-space:nowrap;">
                <a href="{{ route('editMember', $data->id) }}" class="btn-action edit">Izmijeni</a>
                <a href="{{ route('memberProfile', $data->id) }}" class="btn-action profile">Profil</a>
                <a href="{{ route('fees', $data->id) }}" class="btn-action fee">Članarina</a>
                <form action="{{ route('deleteMember', $data->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Da li ste sigurni da želite obrisati člana {{ $data->name }} {{ $data->surname }}?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-action delete">Obriši</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="members-pagination">
        {{ $stanje->links('pagination::bootstrap-4') }}
      </div>
    @else
      <div class="members-empty">Nema kreiranih članova.</div>
    @endif
  </div>
</div>
@endsection
