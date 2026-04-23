@extends('member.layout')
@section('content')
<div class="container" style="padding-top:6vh;">
    <div class="auth-card">
        <h2>Registracija</h2>
        <p class="subtitle">Unesite email koji ste dali pri upisu u teretanu. Inicijalna lozinka će Vam biti poslana na mail.</p>

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

        <form method="POST" action="{{ route('member.register.submit') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label">Email adresa</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="vas@email.com" required autofocus>
                <small style="color:#aaa;font-size:12px;">Mora biti isti email koji ste dali pri upisu u teretanu</small>
            </div>
            <button type="submit" class="btn-portal">Pošalji lozinku na email</button>
        </form>

        <p class="text-center mt-4" style="color:#888;font-size:14px;">
            Već imate nalog? <a href="{{ route('member.login') }}" class="auth-link">Prijavite se</a>
        </p>
    </div>
</div>
@endsection
