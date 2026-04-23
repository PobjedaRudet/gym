@extends('member.layout')
@section('content')
<div class="container" style="padding-top:8vh;">
    <div class="auth-card">
        <h2>Prijava</h2>
        <p class="subtitle">Pristupite svom profilu člana</p>

        @if($errors->any())
        <div class="alert-portal mb-3">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('member.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email adresa</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="vas@email.com" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Lozinka</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Unesite lozinku" required>
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" style="background:#f8f8f8;border-color:#ddd;">
                <label class="form-check-label" for="remember" style="color:#888;font-size:13px;text-transform:none;letter-spacing:0;">Zapamti me</label>
            </div>
            <button type="submit" class="btn-portal">Prijavi se</button>
        </form>

        <p class="text-center mt-4" style="color:#888;font-size:14px;">
            Nemate nalog? <a href="{{ route('member.register') }}" class="auth-link">Registrujte se</a>
        </p>
    </div>
</div>
@endsection
