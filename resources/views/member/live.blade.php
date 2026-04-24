@extends('member.layout')
@section('styles')
<style>
  body { background: #0a0a0a; color: #f4f4f5; }
  .main-content { background: #0a0a0a; }
  .page-title {
    font-size: 1.4rem; font-weight: 800; color: #f4f4f5; margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 10px;
  }
  .page-title svg { color: #ffb800; }

  .live-dot {
    display: inline-block; width: 8px; height: 8px;
    border-radius: 50%; background: #ffb800;
    animation: livePulse 1.5s ease-in-out infinite;
    margin-right: 4px;
  }
  @keyframes livePulse {
    0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(255,184,0,0.45); }
    50% { opacity: 0.7; box-shadow: 0 0 0 6px rgba(255,184,0,0); }
  }

  .refresh-btn {
    background: rgba(255,184,0,0.12); border: 1px solid rgba(255,184,0,0.3);
    color: #ffdd8a; border-radius: 10px; padding: 8px 16px;
    font-size: 13px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
    transition: all 0.2s; text-decoration: none;
  }
  .refresh-btn:hover {
    background: rgba(255,184,0,0.2); color: #ffefc2;
  }

  .live-card {
    background: linear-gradient(160deg, #141416, #101012);
    border-radius: 18px;
    padding: 2rem;
    box-shadow: 0 14px 36px rgba(0,0,0,0.28);
    border: 1px solid rgba(255,255,255,0.08);
    text-align: center;
    transition: transform 0.2s ease, border-color 0.2s ease;
  }
  .live-card:hover { transform: translateY(-3px); border-color: rgba(255,184,0,0.32); }
  .live-card-icon {
    width: 64px; height: 64px; border-radius: 18px;
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
  }
  .live-card-count {
    font-size: 3.5rem; font-weight: 900; line-height: 1; margin-bottom: 4px;
  }
  .live-card-label {
    font-size: 13px; font-weight: 600; color: #a1a1aa;
    text-transform: uppercase; letter-spacing: 1px;
  }
  .live-card-status {
    margin-top: 12px; font-size: 12px; font-weight: 600;
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 14px; border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.1);
  }

  @media (max-width: 767.98px) {
    .page-title { font-size: 1.1rem; }
    .live-card { padding: 1.5rem; }
    .live-card-count { font-size: 2.5rem; }
  }
</style>
@endsection

@section('content')
<div style="max-width:900px;">

  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div class="page-title mb-0">
      <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
      <span class="live-dot"></span> Trenutno prisutnih
    </div>
    <a href="{{ route('member.live') }}" class="refresh-btn">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>
      Osvježi
    </a>
  </div>

  <div class="row g-4">
    {{-- GYM --}}
    <div class="col-12 col-md-6">
      <div class="live-card">
        <div class="live-card-icon" style="background:linear-gradient(135deg,#5AC8FA,#64D2FF);">
          <svg width="28" height="28" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M6.5 6.5h11M6.5 17.5h11M2 12h20M4 9v6M20 9v6M6.5 6.5v11M17.5 6.5v11"/></svg>
        </div>
        <div class="live-card-count" style="color:#ffdd8a;">{{ $gymMembers->count() }}</div>
        <div class="live-card-label">Gym</div>
        <div class="live-card-status" style="background:{{ $gymMembers->count() > 0 ? 'rgba(255,184,0,0.14)' : 'rgba(161,161,170,0.18)' }};color:{{ $gymMembers->count() > 0 ? '#ffdd8a' : '#a1a1aa' }};">
          @if($gymMembers->count() > 0)
            <span class="live-dot" style="width:6px;height:6px;margin:0;"></span> Aktivno
          @else
            Prazno
          @endif
        </div>
      </div>
    </div>

    {{-- LADIES GYM --}}
    <div class="col-12 col-md-6">
      <div class="live-card">
        <div class="live-card-icon" style="background:linear-gradient(135deg,#FF4FA0,#FF7AB8);">
          <svg width="28" height="28" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M6.5 6.5h11M6.5 17.5h11M2 12h20M4 9v6M20 9v6M6.5 6.5v11M17.5 6.5v11"/></svg>
        </div>
        <div class="live-card-count" style="color:#f4f4f5;">{{ $ladiesMembers->count() }}</div>
        <div class="live-card-label">Ladies Gym</div>
        <div class="live-card-status" style="background:{{ $ladiesMembers->count() > 0 ? 'rgba(244,244,245,0.14)' : 'rgba(161,161,170,0.18)' }};color:{{ $ladiesMembers->count() > 0 ? '#f4f4f5' : '#a1a1aa' }};">
          @if($ladiesMembers->count() > 0)
            <span class="live-dot" style="width:6px;height:6px;margin:0;"></span> Aktivno
          @else
            Prazno
          @endif
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
