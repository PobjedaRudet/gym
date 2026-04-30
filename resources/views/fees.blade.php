@extends('layouts.report')

@section('content')
<style>
    .fees-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 1.5rem;
    }
    .fees-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .fees-header h4 {
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }
    .fees-subtitle {
        margin: 0.15rem 0 0;
        color: #6c757d;
        font-size: 0.88rem;
        font-weight: 500;
    }
    .fees-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        color: #fff;
        transition: transform 0.15s, box-shadow 0.2s;
        cursor: pointer;
    }
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: #fff;
    }
    .btn-modern.btn-back {
        background: linear-gradient(135deg, #6c757d, #9aa1a9);
    }
    .btn-modern.btn-create {
        background: linear-gradient(135deg, #198754, #20c997);
    }
    .fees-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .fees-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9rem;
    }
    .fees-table thead th {
        background: #f8f9fb;
        color: #6c757d;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.9rem 1rem;
        border-bottom: 2px solid #eee;
        white-space: nowrap;
    }
    .fees-table tbody tr {
        transition: background 0.15s;
    }
    .fees-table tbody tr:hover {
        background: #f0f4ff;
    }
    .fees-table tbody td {
        padding: 0.75rem 1rem;
        color: #333;
        border-bottom: 1px solid #f0f0f5;
        vertical-align: middle;
    }
    .member-name {
        font-weight: 600;
        color: #1a1a2e;
    }
    .date-badge {
        display: inline-block;
        background: #f0f0f5;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        color: #495057;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        color: #fff;
        transition: opacity 0.15s;
    }
    .btn-action:hover {
        opacity: 0.85;
        color: #fff;
    }
    .btn-action.edit {
        background: #ffc107;
        color: #1a1a2e;
    }
    .btn-action.edit:hover {
        color: #1a1a2e;
    }
    .btn-action.delete {
        background: linear-gradient(135deg, #dc3545, #e85d6f);
    }
    .fees-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
        font-size: 1rem;
        font-weight: 500;
    }
    @media (max-width: 768px) {
        .fees-header {
            flex-direction: column;
            align-items: stretch;
        }
        .fees-actions {
            justify-content: flex-end;
        }
        .fees-table thead th,
        .fees-table tbody td {
            padding: 0.5rem 0.6rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="fees-container">
    @php
        $member = isset($stanje) && count($stanje) > 0 ? $stanje->first() : null;
    @endphp

    <div class="fees-header">
        <div>
            <h4>Članarine</h4>
            @if($member)
                <p class="fees-subtitle">{{ $member->name }} {{ $member->surname }}</p>
            @else
                <p class="fees-subtitle">Pregled uplata članarine</p>
            @endif
        </div>

        <div class="fees-actions">
            <a href="{{ route('members') }}" class="btn-modern btn-back">Nazad</a>
            <a href="{{ route('createFee', $id) }}" class="btn-modern btn-create">Dodaj članarinu</a>
        </div>
    </div>

    <div class="fees-card">
        @if (isset($stanje) && count($stanje) > 0)
            <table class="fees-table">
                <thead>
                    <tr>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th style="text-align: center">Datum uplate</th>
                        <th style="text-align: center">Datum početka</th>
                        <th style="text-align: center">Datum isteka</th>
                        <th style="text-align: center">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stanje as $data)
                        <tr>
                            <td class="member-name">{{ $data->name }}</td>
                            <td>{{ $data->surname }}</td>
                            <td style="text-align: center">
                                @if(!empty($data->date))
                                    <span class="date-badge">{{ date('d.m.Y', strtotime($data->date)) }}</span>
                                @else
                                    <span class="date-badge">—</span>
                                @endif
                            </td>
                            <td style="text-align: center">{{ date('d.m.Y', strtotime($data->start)) }}</td>
                            <td style="text-align: center">{{ date('d.m.Y', strtotime($data->end)) }}</td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="{{ route('editFee', $data->fees_id) }}" class="btn-action edit">Izmijeni</a>
                                <a href="{{ route('feesDelete', $data->fees_id) }}" class="btn-action delete">Briši</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="fees-empty">
                Član nema uplata članarine.
            </div>
        @endif
    </div>
</div>
@endsection
