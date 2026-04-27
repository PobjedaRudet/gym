@extends('moderator.layout')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f2f2f2;padding:1rem;">
    <div class="auth-card">
        <div style="text-align:center;margin-bottom:1.5rem;">
            <img src="{{ asset('site/img/logo.png') }}" alt="BEG's" style="height:44px;width:auto;max-width:100%;">
        </div>
        <h2 style="text-align:center;">Moderator Panel</h2>
        <p class="subtitle" style="text-align:center;">Prijavite se na moderatorski panel</p>

        @if($errors->any())
        <div class="alert-portal mb-3">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('moderator.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Lozinka</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember" style="text-transform:none;font-size:14px;">Zapamti me</label>
            </div>
            <button type="submit" class="btn btn-mod">Prijava</button>
        </form>
    </div>
</div>
@endsection
