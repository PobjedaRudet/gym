@extends('member.layout')

@section('styles')
<style>
    body { background: #0a0a0a; color: #f4f4f5; }
    .main-content { background: #0a0a0a; }

    .rules-wrap {
        max-width: 860px;
    }

    .page-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #f4f4f5;
        margin: 0 0 0.45rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .page-title svg { color: #ffb800; }

    .page-subtitle {
        margin: 0 0 1.2rem;
        color: #a1a1aa;
        font-size: 14px;
    }

    .rules-card {
        background: linear-gradient(160deg, #131316, #101012);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 18px;
        padding: 1.25rem;
        box-shadow: 0 16px 36px rgba(0,0,0,0.25);
        margin-bottom: 1rem;
    }

    .rules-card h3 {
        margin: 0 0 0.8rem;
        font-size: 1.05rem;
        color: #f4f4f5;
        font-weight: 800;
    }

    .rules-list {
        margin: 0;
        padding-left: 1.1rem;
        color: #d4d4d8;
        line-height: 1.75;
        font-size: 14px;
    }

    .rules-note {
        border-radius: 14px;
        border: 1px solid rgba(255,184,0,0.2);
        background: rgba(255,184,0,0.08);
        color: #fde68a;
        padding: 0.85rem 1rem;
        font-size: 13px;
        margin-top: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="rules-wrap">
        <h1 class="page-title">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2l7 4v6c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-4z"/><path d="M9 12l2 2 4-4"/></svg>
            Pravila portala
        </h1>
        <p class="page-subtitle">Molimo pridržavajte se pravila kako bi portal ostao sigurno i ugodno mjesto za sve članove.</p>

        <div class="rules-card">
            <h3>Pravila za upload profilne fotografije</h3>
            <ul class="rules-list">
                <li>Fotografija ne smije sadržavati vulgaran, uvredljiv ili seksualno eksplicitan sadržaj.</li>
                <li>Zabranjen je rasistički, govor mržnje, diskriminatoran ili bilo koji drugi neprimjeren sadržaj.</li>
                <li>Nije dozvoljeno postavljanje fotografija nasilja, oružja ili uznemirujućih scena.</li>
                <li>Profilna slika treba prikazivati vas (vlasnika profila), a ne drugu osobu bez dozvole.</li>
                <li>Fotografija treba biti jasna, odgovarajućeg kvaliteta i u jednom od podržanih formata (JPG, PNG, WEBP).</li>
                <li>Nije dozvoljen upload zaštićenih logotipa, brendova ili tuđih autorskih fotografija bez prava korištenja.</li>
            </ul>
        </div>

        <div class="rules-card">
            <h3>Opšta pravila ponašanja na portalu</h3>
            <ul class="rules-list">
                <li>Ne dijelite svoje pristupne podatke (email i lozinku) sa drugim osobama.</li>
                <li>Ne pokušavajte neovlašteno mijenjati podatke, pristupati tuđim profilima ili zloupotrebljavati sistem.</li>
            </ul>
            <div class="rules-note">
                Administrator može ukloniti fotografiju ili privremeno ograničiti mogućnost izmjene profila ako se pravila ne poštuju.
            </div>
        </div>
    </div>
</div>
@endsection
