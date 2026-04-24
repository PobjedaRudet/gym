@extends('member.layout')
@section('content')
<div class="auth-hero-wrap">
    <div class="auth-phone" style="background-image:url('{{ asset('site/img/hero/hero-2.jpg') }}');">
        <div class="auth-phone-inner">
            <div class="auth-brand">
                <img src="{{ asset('site/img/logo.png') }}" alt="BEG's Fit&Fight">
            </div>

            <div class="auth-copy">
                Transform your <strong>body</strong><br>
                <strong>Empower</strong> your mind
            </div>

            <div class="auth-actions">
                <a href="{{ route('member.login') }}" class="btn-auth-secondary">Login</a>
            </div>

            <div class="auth-form-panel">
                @if($errors->any())
                <div class="alert-portal mb-3">
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('member.login.submit') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="email" class="form-label">Email adresa</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="vas@email.com" required autofocus>
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Lozinka</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Unesite lozinku" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" style="background:#16161a;border-color:#3f3f46;">
                        <label class="form-check-label" for="remember" style="font-size:13px;text-transform:none;letter-spacing:0;">Zapamti me</label>
                    </div>
                    <button type="submit" class="btn-auth-primary">Prijavi se</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
