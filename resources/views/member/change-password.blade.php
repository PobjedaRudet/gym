@extends('member.layout')
@section('content')
<div class="container" style="padding-top:6vh;">
    <div class="auth-card">
        <h2>Promjena lozinke</h2>
        <p class="subtitle">Unesite trenutnu lozinku i novu lozinku</p>

        @if($errors->any())
        <div class="alert-portal mb-3">
            {{ $errors->first() }}
        </div>
        @endif

        @if(session('success'))
        <div class="mb-3" style="background:rgba(22,163,74,0.08);border:1px solid rgba(22,163,74,0.2);color:#16a34a;border-radius:12px;padding:12px 16px;font-size:14px;">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('member.password.update') }}">
            @csrf
            <div class="mb-3">
                <label for="current_password" class="form-label">Trenutna lozinka</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nova lozinka</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Minimalno 6 karaktera" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Potvrdite novu lozinku</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ponovite novu lozinku" required>
            </div>
            <button type="submit" class="btn-portal">Promijeni lozinku</button>
        </form>

        <p class="text-center mt-4" style="color:#888;font-size:14px;">
            <a href="{{ route('member.profile') }}" class="auth-link">&larr; Nazad na profil</a>
        </p>
    </div>
</div>
@endsection
