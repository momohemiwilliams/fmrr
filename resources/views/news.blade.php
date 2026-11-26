@extends('layouts.externalnews')

@section('content')
<style>
/* Modern FMDQ News Grid Redesign */
.cards-container {
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)) !important;
    gap: 24px !important;
    width: 100% !important;
    max-width: 1180px !important;
    margin: 0 auto !important;
    padding: 32px 20px !important;
    box-sizing: border-box !important;
    align-items: stretch !important;
}

.card.js-card {
    display: flex !important;
    flex-direction: column !important;
    width: 100% !important;
    height: 100% !important;
    perspective: none !important;
    position: static !important;
    border: none !important;
    background: transparent !important;
    box-shadow: none !important;
    margin: 0 !important;
    padding: 0 !important;
}

.card.js-card > div,
.card.js-card > div > a {
    display: flex !important;
    flex-direction: column !important;
    height: 100% !important;
    text-decoration: none !important;
}

.blog-card {
    background: #ffffff !important;
    border-radius: 14px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05) !important;
    transition: all 0.25s ease !important;
    position: relative !important;
    border: 1px solid #e2e8f0 !important;
    display: flex !important;
    flex-direction: column !important;
    height: 100% !important;
    min-height: 300px !important;
}

.blog-card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 12px 28px rgba(12, 43, 112, 0.1) !important;
    border-color: rgba(199, 157, 81, 0.55) !important;
}

.blog-card-media {
    position: relative;
    overflow: hidden;
    height: 165px;
    background: #f1f5f9;
}

.blog-card img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    border-radius: 0 !important;
    transition: transform 0.45s ease !important;
}

.blog-card:hover img {
    transform: scale(1.05) !important;
}

.blog-card-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(12, 43, 112, 0.9);
    color: #ffffff;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.3px;
    padding: 4px 10px;
    border-radius: 999px;
    border: 1px solid rgba(199, 157, 81, 0.6);
    backdrop-filter: blur(4px);
}

.blog-card-info {
    padding: 18px 20px !important;
    display: flex !important;
    flex-direction: column !important;
    flex-grow: 1 !important;
    justify-content: space-between !important;
}

.blog-card-title {
    color: #0c2b70 !important;
    font-family: straightBold, "Roboto", sans-serif !important;
    font-weight: 700 !important;
    font-size: 15px !important;
    line-height: 1.45 !important;
    margin: 0 0 16px 0 !important;
    transition: color 0.2s ease !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 3 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
}

.blog-card:hover .blog-card-title {
    color: #b5892e !important;
}

.blog-card-footer {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding-top: 12px !important;
    border-top: 1px solid #f1f5f9 !important;
    margin-top: auto !important;
}

.blog-card-date {
    font-family: customRegular, sans-serif !important;
    color: #64748b !important;
    font-size: 12px !important;
    display: flex !important;
    align-items: center !important;
    gap: 5px !important;
    margin-top: 0 !important;
}

.blog-card-readmore {
    font-size: 12.5px;
    font-weight: 600;
    color: #0c2b70;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: color 0.2s ease, transform 0.2s ease;
}

.blog-card:hover .blog-card-readmore {
    color: #b5892e;
    transform: translateX(2px);
}
</style>

    <section class="main-container">
        <div class="cards-container">
            @foreach ($news_alert as $news)
                <div class="card js-card">
                    <div class="">
                        <a href="{{ route('alert', $news->id) }}">
                            <div class="blog-card">
                                <div class="blog-card-media">
                                    <img src="{{ asset('public/users/assets/art.jpg') }}" alt="{{ $news->title }}">
                                    <span class="blog-card-badge">News &amp; Circulars</span>
                                </div>
                                <div class="blog-card-info">
                                    <div class="blog-card-title">{{ $news->title }}</div>
                                    <div class="blog-card-footer">
                                        <div class="blog-card-date">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            {{ \Carbon\Carbon::parse($news->created_at)->format('M. j, Y') }}
                                        </div>
                                        <span class="blog-card-readmore">Read More &rarr;</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    </div>
@endsection
</body>

</html>
