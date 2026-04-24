@extends('member.layout')
@section('content')
<div class="auth-hero-wrap">
    <div class="auth-phone" style="background-image:url('{{ asset('site/img/hero/hero-1.jpg') }}');">
        <div class="auth-phone-inner">
            <div class="auth-brand">
                <img src="{{ asset('site/img/logo.png') }}" alt="BEG's Fit&Fight">
            </div>

            <div class="auth-copy">
                Build your <strong>strength</strong><br>
                Start your <strong>journey</strong>
            </div>

            <div class="auth-form-panel">
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

                <form method="POST" action="{{ route('member.register.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email adresa</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="vas@email.com" required autofocus>
                        <small style="font-size:12px;">Mora biti isti email koji ste dali pri upisu u teretanu</small>
                    </div>
                    <button type="submit" class="btn-auth-primary">Pošalji lozinku na email</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
