@extends('layouts.report')

@section('content')
<div class="container" style="max-width:850px; padding-top:1.25rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
        <h3 style="margin:0;font-weight:800;color:#1a1a2e;">Uredi portal obavijest</h3>
        <a href="{{ route('admin.portal.obavijesti') }}" style="text-decoration:none;background:#f3f4f6;color:#374151;border-radius:10px;padding:8px 12px;font-size:12px;font-weight:700;">Nazad</a>
    </div>

    @if($errors->any())
        <div style="margin-bottom:1rem;padding:0.8rem 1rem;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;font-weight:600;">
            {{ $errors->first() }}
        </div>
    @endif

    <div style="background:#fff;border-radius:16px;box-shadow:0 4px 16px rgba(0,0,0,0.08);padding:1.25rem;">
        <form method="POST" action="{{ route('admin.portal.obavijesti.update', $obavijest) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom:10px;">
                <label for="naslov" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Naslov</label>
                <input id="naslov" name="naslov" type="text" value="{{ old('naslov', $obavijest->naslov) }}" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
            </div>

            <div style="margin-bottom:10px;">
                <label for="tip" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Tip</label>
                <select id="tip" name="tip" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">
                    <option value="info" {{ old('tip', $obavijest->tip) == 'info' ? 'selected' : '' }}>Info</option>
                    <option value="vazno" {{ old('tip', $obavijest->tip) == 'vazno' ? 'selected' : '' }}>Vazno</option>
                    <option value="upozorenje" {{ old('tip', $obavijest->tip) == 'upozorenje' ? 'selected' : '' }}>Upozorenje</option>
                    <option value="promo" {{ old('tip', $obavijest->tip) == 'promo' ? 'selected' : '' }}>Promo</option>
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label for="sadrzaj" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Sadrzaj</label>
                <textarea id="sadrzaj" name="sadrzaj" rows="6" required style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 12px;">{{ old('sadrzaj', $obavijest->sadrzaj) }}</textarea>
            </div>

            <div style="margin-bottom:10px;">
                <label for="slika" style="display:block;margin-bottom:6px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;">Nova slika (opcionalno)</label>
                <input id="slika" name="slika" type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:8px;">
            </div>

            @if($obavijest->slika)
                <div style="margin-bottom:12px;padding:10px;border:1px solid #e5e7eb;border-radius:10px;">
                    <div style="font-size:12px;color:#6b7280;margin-bottom:8px;">Trenutna slika</div>
                    <img src="{{ asset('images/obavijesti/' . $obavijest->slika) }}" alt="slika" style="max-width:220px;border-radius:8px;display:block;margin-bottom:8px;">
                    <label style="display:inline-flex;align-items:center;gap:6px;font-size:12px;color:#7f1d1d;cursor:pointer;">
                        <input type="checkbox" name="ukloni_sliku" value="1">
                        Ukloni trenutnu sliku
                    </label>
                </div>
            @endif

            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button type="submit" style="border:none;background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;cursor:pointer;">Sacuvaj izmjene</button>
                <a href="{{ route('admin.portal.obavijesti') }}" style="text-decoration:none;background:#f3f4f6;color:#374151;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;">Odustani</a>
            </div>
        </form>
    </div>
</div>
@endsection
