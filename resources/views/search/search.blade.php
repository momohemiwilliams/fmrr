@extends('layouts.headerexternal')

@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha384-R334r6kryDNB/GWs2kfB6blAOyWPCxjdHSww/mo7fel+o5TM/AOobJ0QpGRXSDh4" crossorigin="anonymous">
    <link href="{{ asset('public/admin/css/dashlite.css') }}" rel="stylesheet" type="text/css" />
    <div class="info">

        <div class="title">Search</div>


    </div>
    </div>

    </section>
    <section style="background: #f1f5f9 !important; padding: 36px 20px 64px;" class="gd-main-container">
        <style>
            .fmdq-search-page-wrap {
                max-width: 1160px;
                width: 100%;
                margin: 0 auto;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 44px;
            }
            .fmdq-search-form-col {
                flex: 1 1 540px;
                max-width: 640px;
                width: 100%;
            }
            .fmdq-search-empty-col {
                flex: 0 1 360px;
                display: flex;
                justify-content: center;
            }
            .adv-search-empty {
                text-align: center;
                padding: 20px;
            }
            .adv-search-empty .no-doc {
                color: #0c2b70 !important;
                font-size: 20px !important;
                font-weight: 700 !important;
                margin-top: 14px;
                margin-bottom: 6px;
            }
            .adv-search-empty .get-in {
                color: #64748b !important;
                font-size: 14px !important;
            }
        </style>

        <div class="fmdq-search-page-wrap">
            <div class="fmdq-search-form-col">
                @include('search.searchTbale')
            </div>

            <div class="fmdq-search-empty-col">
                <div class="adv-search-empty">
                    <img src="{{ asset('public/users/assets/illustration-search.svg') }}" alt="search illustration"
                        height="250px">
                    <div class="no-doc">No Results to Show</div>
                    <div class="get-in">
                        Enter a query to see results here
                    </div>
                </div>
            </div>
        </div>
    </section>

    </div>
@endsection
</div>
</body>

</html>
