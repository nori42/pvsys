@php
    $serviceCategory = [
        'corporateEvents' => ['CONFERENCES', 'CORPORATE PARTIES', 'PRODUCT LAUNCHES', 'SEMINARS', 'TEAM-BUILDING ACTIVITIES'],
        'commercialShoots' => ['ADVERTISING CAMPAIGNS', 'FASHION SHOOTS'],
        'potraits' => ['FAMILY POTRAITS', 'LIFESTYLE PHOTOGRAPHY', 'PROFESSIONAL HEADSHOTS', 'SENIOR PORTRAITS'],
        'socialEvents' => ['ANNIVERSARIES', 'BABY SHOWERS', 'BIRTHDAYS', 'GRADUATIONS'],
        'weddings' => ['BRIDAL SHOWERS', 'CEREMONIES', 'ENGAGEMENT PARTIES', 'RECEPTION'],
    ];
@endphp

@extends('layout.main')

@section('stylesheets')
@endsection

@section('maincontent')
    <main>
        <div>Admin Services</div>
        <a class="btn btn-primary" href="/admin/services/create">Add Service</a>

        <div class="modal">
        </div>
    </main>
@endsection

@section('scripts')
@endsection
