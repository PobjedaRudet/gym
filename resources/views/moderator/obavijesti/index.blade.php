@extends('moderator.layout')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 style="font-weight:800;color:#1C1C1E;margin:0;">
        <svg width="24" height="24" fill="none" stroke="#FF375F" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-4px;margin-right:6px;"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
        Obavijesti
    </h4>
    <a href="{{ route('moderator.obavijesti.create') }}" class="btn btn-sm" style="background:#FF375F;color:#fff;font-weight:700;border-radius:10px;padding:8px 18px;">
        + Nova obavijest
    </a>
</div>

@if($obavijesti->isEmpty())
<div class="glass-card p-5 text-center">
    <svg width="48" height="48" fill="none" stroke="#ccc" stroke-width="1.5" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
    <p class="mt-3" style="color:#8E8E93;">Nemate kreiranih obavijesti.</p>
</div>
@else
<div class="glass-card" style="overflow:hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:14px;">
            <thead style="background:#f8f8f8;">
                <tr>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Naslov</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Tip</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;">Datum</th>
                    <th style="padding:14px 16px;font-weight:700;color:#8E8E93;font-size:11px;text-transform:uppercase;letter-spacing:1px;text-align:right;">Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obavijesti as $o)
                <tr>
                    <td style="padding:14px 16px;font-weight:600;color:#1C1C1E;">
                        @if($o->slika)
                        <svg width="14" height="14" fill="#30D158" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px;"><rect x="3" y="3" width="18" height="18" rx="3" stroke="#30D158" stroke-width="2" fill="rgba(48,209,88,0.12)"/><circle cx="8.5" cy="8.5" r="1.5" fill="#30D158"/><path d="M21 15l-5-5L5 21" stroke="#30D158" stroke-width="2" fill="none"/></svg>
                        @endif
                        {{ $o->naslov }}
                    </td>
                    <td style="padding:14px 16px;">
                        @if($o->tip === 'info')
                        <span style="background:rgba(90,200,250,0.12);color:#5AC8FA;padding:3px 10px;border-radius:8px;font-size:12px;font-weight:700;">Info</span>
                        @elseif($o->tip === 'vazno')
                        <span style="background:rgba(255,55,95,0.12);color:#FF375F;padding:3px 10px;border-radius:8px;font-size:12px;font-weight:700;">Važno</span>
                        @else
                        <span style="background:rgba(255,159,10,0.12);color:#FF9F0A;padding:3px 10px;border-radius:8px;font-size:12px;font-weight:700;">Upozorenje</span>
                        @endif
                    </td>
                    <td style="padding:14px 16px;color:#8E8E93;">{{ $o->created_at->format('d.m.Y H:i') }}</td>
                    <td style="padding:14px 16px;text-align:right;">
                        <a href="{{ route('moderator.obavijesti.edit', $o) }}" class="btn btn-sm" style="background:rgba(90,200,250,0.1);color:#5AC8FA;font-weight:600;border-radius:8px;padding:4px 12px;font-size:12px;">Uredi</a>
                        <form action="{{ route('moderator.obavijesti.delete', $o) }}" method="POST" style="display:inline;" onsubmit="return confirm('Obrisati obavijest?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:#ef4444;font-weight:600;border-radius:8px;padding:4px 12px;font-size:12px;">Obriši</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $obavijesti->links() }}</div>
@endif
@endsection
