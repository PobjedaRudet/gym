@extends('member.layout')

@section('content')
<div class="auth-hero-wrap">
    <div class="auth-phone" style="background-image:url('{{ asset('site/img/hero/hero-2.jpg') }}');">
        <div class="auth-phone-inner">
            <div class="auth-brand">
                <img src="{{ asset('site/img/logo.png') }}" alt="BEG's Fit&Fight">
            </div>

            <div class="auth-copy">
                Choose a <strong>new</strong><br>
                secure <strong>password</strong>
            </div>

            <div class="auth-form-panel">
                <div class="auth-form-title">Postavi novu lozinku</div>
                <div class="auth-form-subtitle">Unesite novu lozinku za Vas clan portal nalog</div>

                @if($errors->any())
                <div class="alert-portal mb-3">
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('member.password.store') }}" autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-2">
                        <label for="email" class="form-label">Email adresa</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $email) }}" required autofocus>
                    </div>

                    <div class="mb-2">
                        <label for="password" class="form-label">Nova lozinka</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Potvrdi novu lozinku</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="6" required>
                    </div>

                    <button type="submit" class="btn-auth-primary">Sacuvaj novu lozinku</button>
                </form>

                <div class="text-center mt-3 auth-muted" style="font-size:13px;">
                    <a href="{{ route('member.login') }}" class="auth-link">Nazad na prijavu</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
