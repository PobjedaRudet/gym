@extends('layouts.report')

@section('content')
<style>
  .create-container {
    max-width: 750px;
    margin: 0 auto;
    padding: 1.5rem;
  }
  .create-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    overflow: hidden;
  }
  .create-card-header {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: #fff;
    padding: 1.25rem 1.5rem;
    font-weight: 700;
    font-size: 1.1rem;
    letter-spacing: 0.3px;
  }
  .create-card-body {
    padding: 1.5rem;
  }
  .form-section {
    margin-bottom: 1.5rem;
  }
  .form-section-title {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #667eea;
    margin-bottom: 0.75rem;
    padding-bottom: 0.4rem;
    border-bottom: 2px solid #f0f0f5;
  }
  .create-card .form-label {
    font-weight: 600;
    font-size: 0.82rem;
    color: #495057;
    margin-bottom: 0.3rem;
  }
  .create-card .form-control {
    border-radius: 10px;
    border: 2px solid #e0e0e8;
    padding: 0.55rem 0.9rem;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .create-card .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
  }
  .create-card .form-check-input {
    width: 1.15em;
    height: 1.15em;
    border-radius: 4px;
    border: 2px solid #ccc;
  }
  .create-card .form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
  }
  .create-card .form-check-label {
    font-weight: 500;
    font-size: 0.9rem;
    margin-left: 0.3rem;
  }
  .btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.6rem 2rem;
    border: none;
    border-radius: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: transform 0.15s, box-shadow 0.2s;
  }
  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }
  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.6rem 1.5rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    color: #495057;
    background: #f0f0f5;
    border: none;
    transition: background 0.15s;
  }
  .btn-back:hover {
    background: #e0e0e8;
    color: #1a1a2e;
  }
  .create-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.25rem;
    border-top: 1px solid #f0f0f5;
    margin-top: 0.5rem;
  }
</style>

<div class="create-container">
  <div class="create-card">
    <div class="create-card-header">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="vertical-align:-3px;margin-right:6px;opacity:0.8"><path d="M15.502 1.94a.5.5 0 010 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 01.707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 00-.121.196l-.805 2.414a.25.25 0 00.316.316l2.414-.805a.5.5 0 00.196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-6a.5.5 0 00-1 0v6a.5.5 0 01-.5.5h-11a.5.5 0 01-.5-.5v-11a.5.5 0 01.5-.5H9a.5.5 0 000-1H2.5A1.5 1.5 0 001 2.5v11z"/></svg>
      Kreiranje člana
    </div>
    <div class="create-card-body">
      @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center" style="border-radius:12px;font-size:0.9rem;font-weight:500;" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="margin-right:8px;flex-shrink:0"><path d="M8.982 1.566a1.13 1.13 0 00-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 01-1.1 0L7.1 5.995A.905.905 0 018 5zm.002 6a1 1 0 110 2 1 1 0 010-2z"/></svg>
          {{ session('error') }}
        </div>
      @endif
      <form class="row g-3" action="{{ route('create') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="col-12 form-section">
          <div class="form-section-title">Lični podaci</div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Ime</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Prezime</label>
          <input type="text" class="form-control" id="surname" name="surname" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Code</label>
          <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">E-mail</label>
          <input type="text" class="form-control" id="email" name="email">
        </div>

        <div class="col-12 form-section" style="margin-top:1.5rem">
          <div class="form-section-title">Kontakt i adresa</div>
        </div>
        <div class="col-md-4">
          <label class="form-label">Mobitel</label>
          <input type="text" class="form-control" id="mobile" name="mobile" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Ulica</label>
          <input type="text" class="form-control" id="street" name="street" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Poštanski broj</label>
          <input type="number" class="form-control" id="post_no" name="post_no" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Grad</label>
          <input type="text" class="form-control" id="city" name="city" required>
        </div>

        <div class="col-12 form-section" style="margin-top:1.5rem">
          <div class="form-section-title">Registracija</div>
        </div>
        <div class="col-md-4">
          <label class="form-label">Datum registracije</label>
          <?php
            $mytime = Carbon\Carbon::now();
            $mytime2 = $mytime->format('d-m-Y');
          ?>
          <input type="text" class="form-control" id="register_date" value="{{ $mytime2 }}" name="register_date" required>
        </div>
        <div class="col-md-5">
          <label class="form-label">Upload slike</label>
          <input class="form-control" type="file" id="image" name="image">
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="status" name="status" required>
            <label class="form-check-label" for="status">Aktiviraj člana</label>
          </div>
        </div>

        <div class="col-12 create-footer">
          <a href="{{ route('members') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 00-.5-.5H2.707l3.147-3.146a.5.5 0 10-.708-.708l-4 4a.5.5 0 000 .708l4 4a.5.5 0 00.708-.708L2.707 8.5H14.5A.5.5 0 0015 8z"/></svg>
            Nazad
          </a>
          <button type="submit" class="btn-submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M2 1a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1H9.5a1 1 0 00-1 .724L7.947 4.5H2zm0 3V2h5.293l-.65 2.607A.5.5 0 007.13 5h6.37v10H2V4z"/><path d="M8 6.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5zM6.5 9a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"/></svg>
            Snimi
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
