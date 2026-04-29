@extends('layouts.report')

@section('content')
<div class="container" style="max-width:1100px; padding-top:1.25rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
        <h3 style="margin:0;font-weight:800;color:#1a1a2e;">Portal obavijesti</h3>
        <span style="font-size:12px;color:#6b7280;">Objave se prikazuju clanovima na /portal/profile</span>
    </div>

    @if(session('success'))
        <div style="margin-bottom:1rem;padding:0.8rem 1rem;border-radius:12px;background:#ecfdf3;border:1px solid #a7f3d0;color:#065f46;font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="margin-bottom:1rem;padding:0.8rem 1rem;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;font-weight:600;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div style="background:#fff;border-radius:16px;box-shadow:0 4px 16px rgba(0,0,0,0.08);padding:1.25rem;">
                <p style="font-size:15px;font-weight:700;color:#111827;margin-bottom:1rem;">Nova obavijest</p>

                <form method="POST" action="{{ route('admin.portal.obavijesti.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div style="margin-bottom:10px;">
                        <label for="naslov" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Naslov</label>
                        <input id="naslov" name="naslov" type="text" value="{{ old('naslov') }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                    </div>

                    <div style="margin-bottom:10px;">
                        <label for="tip" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Tip</label>
                        <select id="tip" name="tip" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                            <option value="info" {{ old('tip') == 'info' ? 'selected' : '' }}>Info</option>
                            <option value="vazno" {{ old('tip') == 'vazno' ? 'selected' : '' }}>Vazno</option>
                            <option value="upozorenje" {{ old('tip') == 'upozorenje' ? 'selected' : '' }}>Upozorenje</option>
                            <option value="promo" {{ old('tip') == 'promo' ? 'selected' : '' }}>Promo</option>
                        </select>
                    </div>

                    <div style="margin-bottom:10px;">
                        <label for="sadrzaj" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Sadrzaj</label>
                        <textarea id="sadrzaj" name="sadrzaj" rows="5" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">{{ old('sadrzaj') }}</textarea>
                    </div>

                    <div style="margin-bottom:14px;">
                        <label for="slika" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Slika (opcionalno)</label>
                        <input id="slika" name="slika" type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:8px;">
                    </div>

                    <button type="submit" style="border:none;background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;cursor:pointer;">
                        Objavi obavijest
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div style="background:#fff;border-radius:16px;box-shadow:0 4px 16px rgba(0,0,0,0.08);padding:1.25rem;">
                <p style="font-size:15px;font-weight:700;color:#111827;margin-bottom:1rem;">Zadnje obavijesti</p>

                @forelse($obavijesti as $obavijest)
                    <div style="border:1px solid #e5e7eb;border-radius:12px;padding:0.9rem;margin-bottom:0.75rem;">
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:0.75rem;">
                            <strong style="color:#111827;">{{ $obavijest->naslov }}</strong>
                            <span style="font-size:11px;font-weight:700;padding:3px 8px;border-radius:999px;background:#eef2ff;color:#4338ca;">{{ strtoupper($obavijest->tip) }}</span>
                        </div>
                        <p style="margin:0.5rem 0 0.55rem;color:#4b5563;">{{ \Illuminate\Support\Str::limit($obavijest->sadrzaj, 180) }}</p>
                        <small style="color:#9ca3af;">{{ $obavijest->created_at ? $obavijest->created_at->format('d.m.Y H:i') : '' }}</small>
                        <div style="margin-top:0.65rem;display:flex;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('admin.portal.obavijesti.edit', $obavijest) }}" style="display:inline-block;background:#eef2ff;color:#3730a3;text-decoration:none;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700;">Uredi</a>
                            <form method="POST" action="{{ route('admin.portal.obavijesti.destroy', $obavijest) }}" onsubmit="return confirm('Obrisati obavijest?');" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border:none;background:#fee2e2;color:#991b1b;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700;cursor:pointer;">Obrisi</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="color:#6b7280;margin:0;">Nema kreiranih obavijesti.</p>
                @endforelse

                <div style="margin-top:0.8rem;">
                    {{ $obavijesti->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
