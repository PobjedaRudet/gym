@extends('layouts.report')

@section('content')

<style>
  .live-container {
    padding: 1.5rem;
  }
  .live-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
  }
  .live-header h4 {
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
  }
  .live-counter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
  }
  .member-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
  }
  .member-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  }
  .member-card .card-img-wrapper {
    position: relative;
    overflow: hidden;
    background: #f0f0f5;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem 1rem 0.5rem;
  }
  .member-card .card-img-wrapper img {
    width: 110px;
    height: 110px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  }
  .member-card .gym-badge {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    padding: 0.2rem 0.6rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .gym-badge.gym-1 {
    background: rgba(13, 110, 253, 0.15);
    color: #0d6efd;
  }
  .gym-badge.gym-2 {
    background: rgba(214, 51, 132, 0.15);
    color: #d63384;
  }
  .member-card .card-body {
    padding: 0.75rem 1rem 0.5rem;
    text-align: center;
  }
  .member-card .card-body .member-name {
    font-weight: 600;
    font-size: 0.95rem;
    color: #1a1a2e;
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .member-card .card-body .member-time {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.8rem;
    color: #6c757d;
  }
  .member-card .card-body .member-time svg {
    width: 14px;
    height: 14px;
  }
  .member-card .card-actions {
    padding: 0.5rem 1rem 1rem;
    text-align: center;
  }
  .member-card .btn-odjava {
    border: none;
    border-radius: 50px;
    padding: 0.35rem 1.25rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    transition: opacity 0.2s;
    text-decoration: none;
  }
  .member-card .btn-odjava:hover {
    opacity: 0.85;
    color: #fff;
  }
  .btn-odjava.gym-1 {
    background: linear-gradient(135deg, #0d6efd 0%, #6ea8fe 100%);
  }
  .btn-odjava.gym-2 {
    background: linear-gradient(135deg, #d63384 0%, #e685b5 100%);
  }
  .empty-state {
    text-align: center;
    padding: 4rem 1rem;
    color: #6c757d;
  }
  .empty-state svg {
    width: 64px;
    height: 64px;
    margin-bottom: 1rem;
    opacity: 0.4;
  }
  .empty-state p {
    font-size: 1.1rem;
    font-weight: 500;
  }
</style>

<div class="container-fluid live-container">
  <div class="live-header" style="flex-direction:column;align-items:center;">
    <h4 style="margin-bottom:1rem;">Prisutni članovi</h4>
    <div style="display:flex;gap:0.5rem;align-items:center;">
      <span class="live-counter" style="background:linear-gradient(135deg,#0d6efd,#6ea8fe)" id="counter-gym">Gym: 0</span>
      <span class="live-counter" style="background:linear-gradient(135deg,#d63384,#e685b5)" id="counter-ladies">Ladies Gym: 0</span>
      <span class="live-counter" id="live-counter">Ukupno: 0</span>
    </div>
  </div>
  <div class="row g-3" id="live">
  </div>
</div>

<script src="{{ asset('js/live.js') }}" defer></script>
@endsection
