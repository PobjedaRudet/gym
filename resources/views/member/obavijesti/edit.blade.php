@extends('member.layout')

@section('content')
<h4 style="font-weight:800;color:#1C1C1E;margin-bottom:1.5rem;">
    <a href="{{ route('member.obavijesti') }}" style="color:#8E8E93;text-decoration:none;">Obavijesti</a>
    <span style="color:#ccc;margin:0 8px;">/</span> Uredi
</h4>

<div class="glass-card p-4" style="max-width:700px;">
    @if($errors->any())
    <div class="alert-portal mb-3">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('member.obavijesti.update', $obavijest) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Naslov</label>
            <input type="text" name="naslov" class="form-control" value="{{ old('naslov', $obavijest->naslov) }}" required style="border-radius:12px;padding:10px 14px;">
        </div>
        <div class="mb-3">
            <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Tip</label>
            <select name="tip" class="form-select" required style="border-radius:12px;padding:10px 14px;">
                <option value="info" {{ old('tip', $obavijest->tip) == 'info' ? 'selected' : '' }}>Info</option>
                <option value="vazno" {{ old('tip', $obavijest->tip) == 'vazno' ? 'selected' : '' }}>Važno</option>
                <option value="upozorenje" {{ old('tip', $obavijest->tip) == 'upozorenje' ? 'selected' : '' }}>Upozorenje</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Sadržaj</label>
            <textarea name="sadrzaj" class="form-control" rows="5" required style="border-radius:12px;padding:10px 14px;">{{ old('sadrzaj', $obavijest->sadrzaj) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Slika (opcionalno)</label>
            @if($obavijest->slika)
            <div style="margin-bottom:12px;position:relative;display:inline-block;">
                <img src="{{ asset('images/obavijesti/' . $obavijest->slika) }}" style="max-width:100%;max-height:200px;border-radius:12px;border:1px solid #eee;">
                <label style="display:flex;align-items:center;gap:6px;margin-top:8px;cursor:pointer;font-size:13px;color:#ef4444;font-weight:600;">
                    <input type="checkbox" name="ukloni_sliku" value="1" style="accent-color:#ef4444;"> Ukloni sliku
                </label>
            </div>
            @endif
            <div style="border:2px dashed #ddd;border-radius:12px;padding:1.5rem;text-align:center;cursor:pointer;transition:all 0.2s;" id="dropZone" onclick="document.getElementById('slikaInput').click()">
                <input type="file" name="slika" id="slikaInput" accept="image/*" style="display:none;" onchange="previewImage(this)">
                <div id="uploadPlaceholder">
                    <svg width="40" height="40" fill="none" stroke="#ccc" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                    <p style="color:#8E8E93;font-size:13px;margin:8px 0 0;">{{ $obavijest->slika ? 'Zamijeni sliku — klikni ili prevuci' : 'Klikni ili prevuci sliku ovdje' }}</p>
                    <p style="color:#bbb;font-size:11px;margin:0;">JPG, PNG, GIF, WebP — max 5MB</p>
                </div>
                <div id="imagePreview" style="display:none;">
                    <img id="previewImg" src="" style="max-width:100%;max-height:200px;border-radius:10px;">
                    <p style="color:#30D158;font-size:12px;font-weight:600;margin:8px 0 0;">Nova slika učitana</p>
                </div>
            </div>
            @error('slika') <div style="color:#FF375F;font-size:12px;margin-top:4px;">{{ $message }}</div> @enderror
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn" style="background:#FF375F;color:#fff;font-weight:700;border-radius:10px;padding:10px 24px;">Sačuvaj izmjene</button>
            <a href="{{ route('member.obavijesti') }}" class="btn" style="background:#f0f0f0;color:#555;font-weight:600;border-radius:10px;padding:10px 24px;">Odustani</a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    const img = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
const dz = document.getElementById('dropZone');
dz.addEventListener('dragover', e => { e.preventDefault(); dz.style.borderColor = '#FF375F'; dz.style.background = 'rgba(255,55,95,0.03)'; });
dz.addEventListener('dragleave', () => { dz.style.borderColor = '#ddd'; dz.style.background = 'transparent'; });
dz.addEventListener('drop', e => {
    e.preventDefault(); dz.style.borderColor = '#ddd'; dz.style.background = 'transparent';
    document.getElementById('slikaInput').files = e.dataTransfer.files;
    previewImage(document.getElementById('slikaInput'));
});
</script>
@endsection
