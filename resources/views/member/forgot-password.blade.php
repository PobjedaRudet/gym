@extends('member.layout')

@section('content')
<div class="auth-hero-wrap">
    <div class="auth-phone" style="background-image:url('{{ asset('site/img/hero/hero-3.jpg') }}');">
        <div class="auth-phone-inner">
            <div class="auth-brand">
                <img src="{{ asset('site/img/logo.png') }}" alt="BEG's Fit&Fight">
            </div>

            <div class="auth-copy">
                Back to your <strong>focus</strong><br>
                Reset in <strong>seconds</strong>
            </div>

            <div class="auth-form-panel">
                <div class="auth-form-title">Zaboravljena lozinka</div>
                <div class="auth-form-subtitle">Unesite email i poslacemo Vam link za reset lozinke</div>

                @if($errors->any())
                <div class="alert-portal mb-3">
                    {{ $errors->first() }}
                </div>
                @endif

                @if(session('success'))
                <div class="mb-3" style="background:#1a1a1a;border:1px solid #525252;color:#f4f4f5;border-radius:12px;padding:12px 16px;font-size:14px;">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('member.password.email') }}" autocomplete="on">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email adresa</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="vas@email.com" required autofocus>
                    </div>
                    <button type="submit" class="btn-auth-primary">Posalji reset link</button>
                </form>

                <div class="text-center mt-3 auth-muted" style="font-size:13px;">
                    Sjetili ste se lozinke? <a href="{{ route('member.login') }}" class="auth-link">Nazad na prijavu</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
