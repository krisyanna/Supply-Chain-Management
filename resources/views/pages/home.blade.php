@extends('layouts.app')

@section('content')
<div class="home-page">
    <div class="decor decor-top-left-1"></div>
    <div class="decor decor-top-left-2"></div>
    <div class="decor decor-top-left-3"></div>
    <div class="decor decor-bottom-right-1"></div>
    <div class="decor decor-bottom-right-2"></div>
    <div class="decor decor-bottom-right-3"></div>
        <div class="decor decor-bottom-right-4"></div>

    <header class="navbar container">
        <div class="logo"></div>
        <nav>
         <a href="{{ route('forecasting') }}">FORECASTING</a>
            <a href="#">PROCUREMENT</a>
            <a href="#">LOGISTICS</a>
            <a href="#">INVENTORY</a>
            <a href="#">REPORTS</a>
        </nav>
    </header>

    <main class="hero container">
        <section class="hero-text">
            <h1>SUPPLY &<br>LOGISTICS<br>MANAGEMENT</h1>
            <p>
                Improve efficiency, reduce costs, and keep your business running smoothly
                with effective supply chain management. From sourcing to delivery, we help
                you manage every step of the process with confidence.
            </p>
            <a href="{{ route('dashboard') }}" class="btn-primary">GET STARTED ></a>
        </section>

        <section class="hero-image">
            <img src="{{ asset('images/logistics-hero.webp') }}" alt="Supply and logistics illustration">
        </section>
    </main>
</div>
@endsection

@push('styles')
<style>
    .hero {
        display: flex;
        align-items: center;
        gap: 32px;
        flex-wrap: wrap;
    }

    .hero-text {
        flex: 1 1 420px;
        min-width: 0;
    }

    .hero-image {
        flex: 1 1 380px;
        min-width: 0;
        display: flex;
        justify-content: center;
    }

    .hero-image img {
        width: 100%;
        max-width: 420px;
        height: auto;
        display: block;
    }

    @media (max-width: 768px) {
        .hero-image img {
            max-width: 280px;
        }
    }
</style>
@endpush