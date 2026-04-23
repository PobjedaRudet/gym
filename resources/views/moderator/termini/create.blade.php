@extends('moderator.layout')

@section('content')
<h4 style="font-weight:800;color:#1C1C1E;margin-bottom:1.5rem;">
    <a href="{{ route('moderator.termini') }}" style="color:#8E8E93;text-decoration:none;">Termini</a>
    <span style="color:#ccc;margin:0 8px;">/</span> Novi termin
</h4>

<div class="glass-card p-4" style="max-width:700px;">
    @if($errors->any())
    <div class="alert-portal mb-3">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('moderator.termini.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Naziv treninga</label>
            <input type="text" name="naziv" class="form-control" value="{{ old('naziv') }}" required style="border-radius:12px;padding:10px 14px;">
        </div>
        <div class="mb-3">
            <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Opis (opcionalno)</label>
            <textarea name="opis" class="form-control" rows="3" style="border-radius:12px;padding:10px 14px;">{{ old('opis') }}</textarea>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Datum od kad važi</label>
                <input type="date" name="datum_od" class="form-control" value="{{ old('datum_od') }}" required style="border-radius:12px;padding:10px 14px;">
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Vrijeme od</label>
                <input type="time" name="vrijeme_od" class="form-control" value="{{ old('vrijeme_od') }}" required style="border-radius:12px;padding:10px 14px;">
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Vrijeme do</label>
                <input type="time" name="vrijeme_do" class="form-control" value="{{ old('vrijeme_do') }}" required style="border-radius:12px;padding:10px 14px;">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Dani u sedmici</label>
            <div class="d-flex flex-wrap gap-2">
                @php $daniNazivi = [1 => 'Ponedjeljak', 2 => 'Utorak', 3 => 'Srijeda', 4 => 'Četvrtak', 5 => 'Petak', 6 => 'Subota', 7 => 'Nedjelja']; @endphp
                @foreach($daniNazivi as $num => $naziv)
                <label style="display:inline-flex;align-items:center;gap:6px;background:{{ is_array(old('dani')) && in_array($num, old('dani')) ? 'rgba(48,209,88,0.15)' : '#f5f5f5' }};padding:8px 14px;border-radius:10px;cursor:pointer;font-size:13px;font-weight:600;color:#333;border:2px solid {{ is_array(old('dani')) && in_array($num, old('dani')) ? '#30D158' : 'transparent' }};" class="dan-label" data-num="{{ $num }}">
                    <input type="checkbox" name="dani[]" value="{{ $num }}" {{ is_array(old('dani')) && in_array($num, old('dani')) ? 'checked' : '' }} style="display:none;" class="dan-check">
                    <span class="dan-check-icon" style="width:18px;height:18px;border-radius:5px;border:2px solid #ccc;display:flex;align-items:center;justify-content:center;font-size:12px;"></span>
                    {{ $naziv }}
                </label>
                @endforeach
            </div>
            @error('dani') <div style="color:#FF375F;font-size:12px;margin-top:4px;">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="form-label" style="font-weight:600;font-size:13px;color:#555;">Maksimalan broj mjesta</label>
            <input type="number" name="max_mjesta" class="form-control" value="{{ old('max_mjesta', 20) }}" min="1" max="100" required style="border-radius:12px;padding:10px 14px;max-width:150px;">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn" style="background:#30D158;color:#fff;font-weight:700;border-radius:10px;padding:10px 24px;">Kreiraj termin</button>
            <a href="{{ route('moderator.termini') }}" class="btn" style="background:#f0f0f0;color:#555;font-weight:600;border-radius:10px;padding:10px 24px;">Odustani</a>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('.dan-label').forEach(label => {
    label.addEventListener('click', function(e) {
        e.preventDefault();
        const check = this.querySelector('.dan-check');
        check.checked = !check.checked;
        const icon = this.querySelector('.dan-check-icon');
        if (check.checked) {
            this.style.background = 'rgba(48,209,88,0.15)';
            this.style.borderColor = '#30D158';
            icon.innerHTML = '✓';
            icon.style.borderColor = '#30D158';
            icon.style.color = '#30D158';
        } else {
            this.style.background = '#f5f5f5';
            this.style.borderColor = 'transparent';
            icon.innerHTML = '';
            icon.style.borderColor = '#ccc';
        }
    });
    const check = label.querySelector('.dan-check');
    const icon = label.querySelector('.dan-check-icon');
    if (check.checked) {
        icon.innerHTML = '✓';
        icon.style.borderColor = '#30D158';
        icon.style.color = '#30D158';
    }
});
</script>
@endsection
