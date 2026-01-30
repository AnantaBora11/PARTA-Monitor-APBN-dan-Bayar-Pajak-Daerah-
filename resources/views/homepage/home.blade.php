@extends('layouts.app')

@push('styles')
<style>
    /* Hero Section */
    .hero {
        min-height: 600px; height: auto; display: flex; align-items: center; position: relative;
        background: radial-gradient(circle at top right, rgba(56, 189, 248, 0.1), transparent 40%),
                    radial-gradient(circle at bottom left, rgba(129, 140, 248, 0.1), transparent 40%);
        overflow: hidden;
    }
    .hero-content {
        max-width: 800px;
        position: relative; z-index: 10;
        animation: fadeIn Up 0.8s ease-out;
    }
    .hero h1 { font-size: 3.5rem; line-height: 1.2; margin-bottom: 1.5rem; background: linear-gradient(to right, white, #94a3b8); -webkit-background-clip: text; color: transparent; }
    .hero p { font-size: 1.25rem; color: #94a3b8; margin-bottom: 2rem; max-width: 600px; }
    .btn-cta { 
        display: inline-block; padding: 1rem 2rem; background: #38bdf8; color: #0f172a; 
        font-weight: 600; border-radius: 99px; transition: transform 0.2s, box-shadow 0.2s; 
    }
    .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -10px rgba(56, 189, 248, 0.5); }

    /* Card Slider */
    .section-title { font-size: 2.5rem; margin-bottom: 3rem; text-align: center; color: var(--text-main); }
    .slider-container {
        padding: 5rem 0;
        overflow: hidden;
    }
    .cards-wrapper {
        display: flex; gap: 2rem; padding: 1rem 5%;
        overflow-x: auto; scroll-snap-type: x mandatory;
        scrollbar-width: none; 
        -ms-overflow-style: none; 
    }
    .cards-wrapper::-webkit-scrollbar { display: none; }
    .card-item {
        flex: 0 0 350px; scroll-snap-align: start;
        border-radius: 16px; overflow: hidden; transition: transform 0.3s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .card-item:hover { transform: translateY(-5px); }
    .card-img { height: 200px; width: 100%; background-color: #f1f5f9; object-fit: cover; }
    .card-body { padding: 1.5rem; }
    .card-title { font-size: 1.25rem; margin-bottom: 0.5rem; color: var(--text-main); }
    .card-desc { font-size: 0.95rem; color: var(--text-muted); }

    /* About Section */
    .about-section { padding: 5rem 0; background-color: var(--bg-secondary); }
    .about-content { max-width: 800px; margin: 0 auto; text-align: center; color: var(--text-muted); font-size: 1.1rem; line-height: 1.8; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

</style>
@endpush

@section('content')
    @include('homepage.hero')
    @include('homepage.map')
    @include('homepage.news')
    @include('homepage.services')
    @include('homepage.contact')
    @include('homepage.about')
    
@endsection
