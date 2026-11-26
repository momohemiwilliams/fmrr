  <section class="top-half">
      <div class="w-1100">
          @include('layouts.appnavbar')

          <div class="info">
              <div class="title">News</div>
          </div>
      </div>
<style>
/* Premium FMDQ Hero News Ticker */
.marq {
    width: 100% !important;
    display: block !important;
    margin-top: 12px;
}

.scrolling-news {
    display: inline-flex !important;
    align-items: stretch !important;
    gap: 14px !important;
    padding: 4px 0 !important;
}

.scrolling-news a {
    text-decoration: none !important;
}

.scrolling-news .news-card {
    background: rgba(12, 43, 112, 0.88) !important;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.16) !important;
    border-left: 3px solid #C79D51 !important;
    border-radius: 10px !important;
    width: 285px !important;
    min-width: 285px !important;
    padding: 11px 16px !important;
    color: #fff !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 4px !important;
    box-sizing: border-box !important;
    overflow: hidden !important;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease !important;
}

.scrolling-news .news-card:hover {
    background: rgba(12, 43, 112, 1) !important;
    border-color: rgba(199, 157, 81, 0.7) !important;
    transform: translateY(-2px);
}

.scrolling-news .news-card .news-title {
    color: #ffffff !important;
    font-family: straightBold, sans-serif !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    width: 100% !important;
    display: block !important;
}

.scrolling-news .news-card .date {
    color: #ebc277 !important;
    font-family: customRegular, sans-serif !important;
    font-size: 11px !important;
    font-weight: 500 !important;
    letter-spacing: 0.2px;
    margin-bottom: 0 !important;
}
</style>
      <marquee class="marq" bgcolor="transparent" direction="left" loop="" onmouseover="this.stop();" onmouseout="this.start();">
          <div class="scrolling-news">
              @foreach ($news_alert as $news)
              <a href="{{ route('alert', $news->id) }}" title="{{ $news->title }}">
                  <div class="news-card">
                      <div class="date"> @php
                          $postdate = date_format($news->created_at, 'F d,Y');

                          @endphp

                          <?php

                            $timestamp = strtotime($postdate);
                            $newDateFormat = date('M. j, Y', $timestamp);
                            echo $newDateFormat;

                            ?></div>
                      <div class="news-title">
                          {{ \Illuminate\Support\Str::limit($news->title, 50) }}
                      </div>
                      {{-- <div class="news-desc">
                              {{ Str::limit($news->news_content, 25) }}



                  </div> --}}
          </div>
          </a>
          @endforeach


          </div>
      </marquee>
  </section>