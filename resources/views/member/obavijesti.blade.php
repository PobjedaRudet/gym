@extends('member.layout')

@section('styles')
<style>
    .obavijesti-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.25rem;
    }
    @media(max-width: 768px) {
        .obavijesti-grid { grid-template-columns: 1fr; }
    }

    .ob-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06), 0 0 0 1px rgba(0,0,0,0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    .ob-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.1), 0 0 0 1px rgba(0,0,0,0.04);
    }

    /* Image hero section */
    .ob-image-wrap {
        position: relative;
        width: 100%;
        padding-top: 40%; /* shorter ratio */
        overflow: hidden;
        background: linear-gradient(135deg, #1C1C1E 0%, #2C2C2E 100%);
    }
    .ob-image-wrap img {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .ob-card:hover .ob-image-wrap img {
        transform: scale(1.03);
    }
    .ob-image-overlay {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
        pointer-events: none;
    }
    .ob-image-badge {
        position: absolute;
        top: 14px; left: 14px;
        padding: 4px 12px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
    .ob-image-badge.info { background: rgba(90,200,250,0.85); color: #fff; }
    .ob-image-badge.vazno { background: rgba(255,55,95,0.85); color: #fff; }
    .ob-image-badge.upozorenje { background: rgba(255,159,10,0.85); color: #fff; }

    /* NEW ribbon for fresh posts */
    .ob-new-ribbon {
        position: absolute;
        top: 14px; right: 14px;
        background: #30D158;
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 8px;
        letter-spacing: 1px;
        text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(48,209,88,0.3);
    }

    /* Card body */
    .ob-body {
        padding: 1.25rem 1.5rem 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .ob-body-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 0.75rem;
    }
    .ob-type-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        margin-top: 6px;
        flex-shrink: 0;
    }
    .ob-type-dot.info { background: #5AC8FA; box-shadow: 0 0 6px rgba(90,200,250,0.4); }
    .ob-type-dot.vazno { background: #FF375F; box-shadow: 0 0 6px rgba(255,55,95,0.4); }
    .ob-type-dot.upozorenje { background: #FF9F0A; box-shadow: 0 0 6px rgba(255,159,10,0.4); }

    .ob-naslov {
        font-weight: 800;
        font-size: 18px;
        color: #1C1C1E;
        line-height: 1.3;
        margin: 0;
    }
    .ob-sadrzaj {
        font-size: 14px;
        color: #555;
        line-height: 1.7;
        flex: 1;
    }
    .ob-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(0,0,0,0.04);
    }
    .ob-date {
        font-size: 12px;
        color: #8E8E93;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .ob-tip-inline {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }
    .ob-tip-inline.info { background: rgba(90,200,250,0.1); color: #5AC8FA; }
    .ob-tip-inline.vazno { background: rgba(255,55,95,0.1); color: #FF375F; }
    .ob-tip-inline.upozorenje { background: rgba(255,159,10,0.1); color: #FF9F0A; }

    /* No-image card style — with accent left border */
    .ob-card.no-image {
        border-left: 4px solid transparent;
    }
    .ob-card.no-image.info-border { border-left-color: #5AC8FA; }
    .ob-card.no-image.vazno-border { border-left-color: #FF375F; }
    .ob-card.no-image.upozorenje-border { border-left-color: #FF9F0A; }

    /* Featured / large card for first item with image */
    .ob-featured {
        grid-column: 1 / -1;
    }
    .ob-featured .ob-image-wrap {
        padding-top: 32%;
    }
    .ob-featured .ob-naslov {
        font-size: 22px;
    }
    .ob-featured .ob-sadrzaj {
        font-size: 15px;
    }

    /* Empty state */
    .ob-empty {
        background: #fff;
        border-radius: 20px;
        padding: 4rem 2rem;
        text-align: center;
        border: 2px dashed rgba(0,0,0,0.06);
    }
</style>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 style="font-weight:800;color:#1C1C1E;margin:0;">
        <svg width="24" height="24" fill="none" stroke="#FF375F" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-4px;margin-right:6px;"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
        Obavijesti
    </h4>
    <span style="font-size:13px;color:#8E8E93;">{{ $obavijesti->total() }} {{ $obavijesti->total() == 1 ? 'obavijest' : 'obavijesti' }}</span>
</div>

@if($obavijesti->isEmpty())
<div class="ob-empty">
    <svg width="56" height="56" fill="none" stroke="#ddd" stroke-width="1.5" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
    <p style="color:#8E8E93;font-size:16px;font-weight:600;margin-top:1rem;">Nema obavijesti</p>
    <p style="color:#bbb;font-size:13px;">Ovdje će se pojaviti nove obavijesti i promocije.</p>
</div>
@else
<div class="obavijesti-grid">
    @foreach($obavijesti as $index => $o)
    <div class="ob-card {{ $o->slika ? '' : 'no-image ' . $o->tip . '-border' }} {{ $index === 0 && $o->slika ? 'ob-featured' : '' }}">

        {{-- Image hero --}}
        @if($o->slika)
        <div class="ob-image-wrap">
            <img src="{{ asset('images/obavijesti/' . $o->slika) }}" alt="{{ $o->naslov }}" loading="lazy">
            <div class="ob-image-overlay"></div>
            <span class="ob-image-badge {{ $o->tip }}">
                @if($o->tip === 'info') Info @elseif($o->tip === 'vazno') Važno @else Upozorenje @endif
            </span>
            @if($o->created_at->diffInDays(now()) < 3)
            <span class="ob-new-ribbon">NOVO</span>
            @endif
        </div>
        @endif

        {{-- Card body --}}
        <div class="ob-body">
            <div class="ob-body-header">
                @if(!$o->slika)
                <div class="ob-type-dot {{ $o->tip }}"></div>
                @endif
                <div>
                    <h5 class="ob-naslov">{{ $o->naslov }}</h5>
                </div>
            </div>
            <div class="ob-sadrzaj">{!! nl2br(e($o->sadrzaj)) !!}</div>
            <div class="ob-footer">
                <span class="ob-date">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    {{ $o->created_at->diffForHumans() }}
                </span>
                @if(!$o->slika)
                <span class="ob-tip-inline {{ $o->tip }}">
                    @if($o->tip === 'info') Info @elseif($o->tip === 'vazno') Važno @else Upozorenje @endif
                </span>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4">{{ $obavijesti->links() }}</div>
@endif
@endsection
