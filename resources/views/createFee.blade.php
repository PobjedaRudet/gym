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
    .field-note {
        color: #6c757d;
        font-size: 0.78rem;
        margin-top: 0.25rem;
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

@php
    $mytime = Carbon\Carbon::today()->toDateString();
@endphp

<div class="create-container">
    <div class="create-card">
        <div class="create-card-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="vertical-align:-3px;margin-right:6px;opacity:0.8"><path d="M4 .5A.5.5 0 014.5 0h7A1.5 1.5 0 0113 1.5V3h.5a1.5 1.5 0 011.5 1.5V14a2 2 0 01-2 2H3a2 2 0 01-2-2V4.5A1.5 1.5 0 012.5 3H3V1.5A1.5 1.5 0 014.5 0H5a.5.5 0 010 1h-.5a.5.5 0 00-.5.5V3h8V1.5a.5.5 0 00-.5-.5h-7A.5.5 0 014 .5z"/><path d="M11 7a.5.5 0 01.5.5V9H13a.5.5 0 010 1h-1.5v1.5a.5.5 0 01-1 0V10H9a.5.5 0 010-1h1.5V7.5A.5.5 0 0111 7z"/></svg>
            Unos članarine
        </div>
        <div class="create-card-body">
            <form class="row g-3" action="{{ route('insertFee') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="member_id" value="{{ $test['id'] }}" />

            <div class="col-12 form-section">
                <div class="form-section-title">Član</div>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="name">Ime</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $test['name'] }}" disabled>
            </div>

            <div class="col-md-4">
                <label class="form-label" for="surname">Prezime</label>
                <input type="text" class="form-control" id="surname" name="surname" value="{{ $test['surname'] }}" disabled>
            </div>

            <div class="col-md-4">
                <label class="form-label" for="amount">Iznos</label>
                <input type="number" class="form-control" id="amount" name="amount" min="1" required>
            </div>

            <div class="col-12 form-section" style="margin-top:1.5rem">
                <div class="form-section-title">Period članarine</div>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="date">Datum unosa</label>
                <input type="text" class="form-control text-center" id="date" value="{{ $mytime }}" name="date" readonly>
            </div>

            <div class="col-md-4">
                <label class="form-label" for="start">Uplaćeno od</label>
                <input class="form-control text-center" type="text" id="start" name="start" readonly required />
                <div class="field-note">Datum početka članarine.</div>
            </div>

            <div class="col-md-4">
                <label class="form-label" for="end">Uplaćeno do</label>
                <input class="form-control text-center" type="text" id="end" name="end" readonly required />
                <div class="field-note">Datum isteka članarine.</div>
            </div>

            <div class="col-12 form-section" style="margin-top:1.5rem">
                <div class="form-section-title">Napomena</div>
            </div>
            <div class="col-12">
                <label class="form-label" for="comment">Komentar</label>
                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
            </div>

            <div class="col-12 create-footer">
                <a href="{{ route('fees', $test['id']) }}" class="btn-back">
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

<script>
$(function () {
    $('#start').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date());

    $('#end').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date());
});
</script>
@endsection
