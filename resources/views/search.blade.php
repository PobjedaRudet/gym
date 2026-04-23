@extends('layouts.report')
@section('content')
<style>
  .search-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 1.5rem;
  }
  .search-header {
    text-align: center;
    margin-bottom: 1.5rem;
  }
  .search-header h4 {
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 1rem;
  }
  .search-box {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    max-width: 500px;
    margin: 0 auto;
  }
  .search-box input {
    flex: 1;
    padding: 0.6rem 1.2rem;
    border: 2px solid #e0e0e8;
    border-radius: 50px;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fff;
  }
  .search-box input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
  }
  .search-box .btn-search-submit {
    padding: 0.6rem 1.5rem;
    border: none;
    border-radius: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: transform 0.15s, box-shadow 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
  }
  .search-box .btn-search-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }
  .search-results-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    overflow: hidden;
    margin-top: 1.5rem;
  }
  .search-results-info {
    padding: 0.75rem 1rem;
    background: #f8f9fb;
    border-bottom: 1px solid #eee;
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
  }
  .search-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.9rem;
  }
  .search-table thead th {
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
  .search-table tbody tr {
    transition: background 0.15s;
  }
  .search-table tbody tr:hover {
    background: #f0f4ff;
  }
  .search-table tbody td {
    padding: 0.75rem 1rem;
    color: #333;
    border-bottom: 1px solid #f0f0f5;
    vertical-align: middle;
  }
  .search-table .member-name {
    font-weight: 600;
    color: #1a1a2e;
  }
  .search-table .code-badge {
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
  .search-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: #6c757d;
  }
  .search-empty svg {
    width: 48px;
    height: 48px;
    opacity: 0.35;
    margin-bottom: 0.75rem;
  }
  .search-empty p {
    font-size: 1rem;
    font-weight: 500;
    margin: 0;
  }
  .back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    margin-top: 1rem;
    font-size: 0.85rem;
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
  }
  .back-link:hover {
    color: #764ba2;
  }
</style>

<div class="search-container">
  <div class="search-header">
    <h4>Pretraga članova</h4>
    <form action="{{ route('search') }}" method="GET" class="search-box">
      <input type="text" name="search" placeholder="Unesite ime ili prezime..." value="{{ request('search') }}">
      <button type="submit" class="btn-search-submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 10-1.397 1.398h-.001l3.85 3.85a1 1 0 001.415-1.414l-3.85-3.85zm-5.242.156a5 5 0 110-10 5 5 0 010 10z"/></svg>
        Pretraži
      </button>
    </form>
  </div>

  @if (isset($users) && count($users) > 0)
    <div class="search-results-card">
      <div class="search-results-info">
        Pronađeno <strong>{{ count($users) }}</strong> rezultata @if(request('search')) za "<strong>{{ request('search') }}</strong>"@endif
      </div>
      <table class="search-table">
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
          @foreach ($users as $user)
            <tr>
              <td class="member-name">{{ $user->name }}</td>
              <td>{{ $user->surname }}</td>
              <td style="text-align:center"><span class="code-badge">{{ $user->code }}</span></td>
              <td style="text-align:center">{{ $user->city }}</td>
              <td style="text-align:center;white-space:nowrap;">
                <a href="{{ route('editMember', $user->id) }}" class="btn-action edit">Izmijeni</a>
                <a href="{{ route('memberProfile', $user->id) }}" class="btn-action profile">Profil</a>
                <a href="{{ route('fees', $user->id) }}" class="btn-action fee">Članarina</a>
                <form action="{{ route('deleteMember', $user->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Da li ste sigurni da želite obrisati člana {{ $user->name }} {{ $user->surname }}?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-action delete">Obriši</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @elseif(request('search'))
    <div class="search-results-card">
      <div class="search-empty">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <p>Nema rezultata za "{{ request('search') }}"</p>
      </div>
    </div>
  @endif

  <a href="{{ route('members') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 00-.5-.5H2.707l3.147-3.146a.5.5 0 10-.708-.708l-4 4a.5.5 0 000 .708l4 4a.5.5 0 00.708-.708L2.707 8.5H14.5A.5.5 0 0015 8z"/></svg>
    Nazad na listu članova
  </a>
</div>
@endsection
