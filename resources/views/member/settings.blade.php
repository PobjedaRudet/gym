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
    --dash-accent: #ffb800;
  }

  body { background: var(--dash-bg); color: var(--dash-text); }
  .main-content { background: var(--dash-bg); }

  .settings-wrap {
    max-width: 760px;
  }

  .settings-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 1rem;
    color: var(--dash-text);
    font-size: 1.25rem;
    font-weight: 800;
  }

  .settings-panel {
    background: linear-gradient(160deg, var(--dash-panel), var(--dash-panel-soft));
    border: 1px solid var(--dash-border);
    border-radius: 16px;
    padding: 1.25rem;
    box-shadow: 0 12px 30px rgba(0,0,0,0.24);
  }

  .settings-label {
    display: block;
    margin-bottom: 6px;
    color: #d4d4d8;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
  }

  .settings-input {
    width: 100%;
    border: 1px solid #3f3f46;
    background: #18181b;
    color: #f4f4f5;
    border-radius: 10px;
    padding: 11px 12px;
    font-size: 14px;
    font-weight: 600;
  }

  .settings-input:focus {
    outline: none;
    border-color: rgba(255,184,0,0.6);
    box-shadow: 0 0 0 3px rgba(255,184,0,0.14);
  }

  .settings-save-btn {
    border: none;
    background: linear-gradient(135deg,#ffb800,#f59e0b);
    color: #111;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    font-weight: 800;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .settings-save-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 24px rgba(245,158,11,0.18);
  }
</style>
@endsection

@section('content')
<div class="settings-wrap">
  <div class="settings-title">
    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33h0A1.65 1.65 0 0010 3.09V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51h0a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82v0a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
    Postavke ciljeva
  </div>

  @if(session('success'))
    <div style="margin-bottom:1rem;padding:0.9rem 1rem;border-radius:12px;background:rgba(48,209,88,0.12);border:1px solid rgba(48,209,88,0.35);color:#c7ffd9;font-weight:600;">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div style="margin-bottom:1rem;padding:0.9rem 1rem;border-radius:12px;background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.35);color:#fecaca;font-weight:600;">
      {{ $errors->first() }}
    </div>
  @endif

  <div class="settings-panel">
    <form method="POST" action="{{ route('member.settings.update') }}">
      @csrf

      <div style="margin-bottom:14px;">
        <label for="monthly_goal_visits" class="settings-label">Mjesečni cilj dolazaka</label>
        <input
          type="number"
          id="monthly_goal_visits"
          name="monthly_goal_visits"
          min="1"
          max="60"
          value="{{ old('monthly_goal_visits', $ciljDolazaka) }}"
          required
          class="settings-input"
        >
      </div>

      <div style="margin-bottom:16px;">
        <label for="monthly_goal_hours" class="settings-label">Mjesečni cilj vremena (sati)</label>
        <input
          type="number"
          id="monthly_goal_hours"
          name="monthly_goal_hours"
          min="1"
          max="300"
          value="{{ old('monthly_goal_hours', (int) round($ciljMinuta / 60)) }}"
          required
          class="settings-input"
        >
      </div>

      <button type="submit" class="settings-save-btn">
        Sacuvaj postavke
      </button>
    </form>
  </div>
</div>
@endsection
