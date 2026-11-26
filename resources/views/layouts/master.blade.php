<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('public/admin/images/fmdq_favicon.png') }}">
    <title>Financial Markets Regulations & Rules Repository Portal</title>
    <!-- Session timeout configuration -->
    <meta name="session-timeout-minutes" content="{{ \App\Models\SessionSetting::getCurrentTimeout() }}">
    <link href="{{ asset('public/admin/css/dashlite.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/admin/css/theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/admin/css/libs/fontawesome-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/admin/css/libs/themify-icons.css') }}" rel="stylesheet" type="text/css" />
    <!-- Select2 CSS -->
    <link href="{{ asset('public/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Custom Select2 CSS to match existing design -->
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid #e5e9f2 !important;
            border-radius: 4px !important;
        }
        
        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 36px !important;
            padding-left: 12px !important;
            color: #333 !important;
        }
        
        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #6576ff transparent transparent transparent !important;
        }
        
        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #6576ff transparent !important;
        }
        
        .select2-dropdown {
            border: 1px solid #e5e9f2 !important;
            border-radius: 4px !important;
        }
        
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #6576ff !important;
        }
        
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #f5f6fa !important;
        }
    </style>
    
    <!-- jQuery (needed for select2) -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="{{ asset('public/assets/libs/select2/js/select2.min.js') }}"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* FMDQ Executive Admin Theme Overrides */
        .nk-content .page-title {
            color: #0f172a !important;
            font-weight: 700 !important;
            letter-spacing: -0.2px;
        }

        /* Primary CTA Buttons -> FMDQ Navy (replaces muddy tan/gold) */
        .nk-content .btn-primary,
        .modal-content .btn-primary {
            background-color: #0c2b70 !important;
            border-color: #0c2b70 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(12, 43, 112, 0.16);
            transition: all 0.2s ease;
        }
        .nk-content .btn-primary:hover,
        .modal-content .btn-primary:hover {
            background-color: #143ca3 !important;
            border-color: #143ca3 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(12, 43, 112, 0.24);
        }

        /* Secondary / Reset / Outline Buttons */
        .nk-content .btn-light,
        .nk-content .btn-outline-light,
        .modal-content .btn-light,
        .modal-content .btn-outline-secondary {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #334155 !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
        }
        .nk-content .btn-light:hover,
        .nk-content .btn-outline-light:hover,
        .modal-content .btn-light:hover,
        .modal-content .btn-outline-secondary:hover {
            background-color: #f8fafc !important;
            border-color: #94a3b8 !important;
            color: #0f172a !important;
        }

        /* Cards */
        .nk-content .card-bordered,
        .nk-content .card-preview {
            border-color: #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04) !important;
        }

        /* Form Inputs & Multi-selects */
        .nk-content .form-control,
        .nk-content .form-select,
        .modal-content .form-control,
        .modal-content .form-select {
            border-color: #cbd5e1 !important;
            border-radius: 8px !important;
            color: #1e293b !important;
            font-size: 13.5px;
        }
        .nk-content .form-control:focus,
        .nk-content .form-select:focus,
        .modal-content .form-control:focus,
        .modal-content .form-select:focus {
            border-color: #0c2b70 !important;
            box-shadow: 0 0 0 3px rgba(12, 43, 112, 0.1) !important;
        }
        .modal-content select[multiple].form-control {
            padding: 6px !important;
            min-height: 135px;
        }
        .modal-content select[multiple].form-control option {
            padding: 6px 10px;
            border-radius: 6px;
            margin-bottom: 2px;
        }
        .modal-content select[multiple].form-control option:checked {
            background: #eef2ff linear-gradient(0deg, #eef2ff 0%, #eef2ff 100%) !important;
            color: #0c2b70 !important;
            font-weight: 600;
        }

        /* Clean Semantic Badges */
        .nk-content .badge {
            border-radius: 20px !important;
            padding: 4px 10px !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
            letter-spacing: 0.1px;
        }
        .nk-content .badge.badge-primary {
            background-color: #eef2ff !important;
            color: #0c2b70 !important;
            border: 1px solid #c7d2fe !important;
        }
        .nk-content .badge.badge-success {
            background-color: #ecfdf5 !important;
            color: #047857 !important;
            border: 1px solid #a7f3d0 !important;
        }
        .nk-content .badge.badge-danger {
            background-color: #fef2f2 !important;
            color: #b91c1c !important;
            border: 1px solid #fecaca !important;
        }
        .nk-content .badge.badge-warning {
            background-color: #fef9ec !important;
            color: #b45309 !important;
            border: 1px solid #fde68a !important;
        }
        .nk-content .badge.badge-dark {
            background-color: #0c2b70 !important;
            color: #ffffff !important;
            border: 1px solid #0c2b70 !important;
        }

        /* DashLite Table Polish */
        .nk-content .nk-tb-list .nk-tb-head .nk-tb-col,
        .nk-content .nk-tb-list .nk-tb-head th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1px solid #e2e8f0 !important;
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }
        .nk-content .nk-tb-list .nk-tb-item:not(.nk-tb-head):hover {
            background-color: #f8fafc !important;
        }
        .nk-content .nk-tb-list .nk-tb-col {
            border-bottom-color: #f1f5f9 !important;
            color: #1e293b;
        }

        /* Modal Polish */
        .modal-content {
            border-radius: 14px !important;
            border: none !important;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.2) !important;
        }
        .modal-content .modal-header {
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 24px;
        }
        .modal-content .modal-body {
            padding: 22px 24px;
        }
        .modal-content .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 14px 24px;
        }

        /* Clean Alphabet Indexing Tiles (Regulations Add / Edit / View) */
        .fmdq-alpha-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .fmdq-alpha-item {
            position: relative;
            margin: 0;
        }
        .fmdq-alpha-radio {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .fmdq-alpha-tile {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            margin: 0 !important;
            transition: all 0.15s ease;
            user-select: none;
        }
        .fmdq-alpha-tile:hover {
            border-color: #0c2b70;
            color: #0c2b70;
            background: #f8fafc;
        }
        .fmdq-alpha-radio:checked + .fmdq-alpha-tile {
            background: #0c2b70 !important;
            border-color: #0c2b70 !important;
            color: #ffffff !important;
            box-shadow: 0 3px 8px rgba(12, 43, 112, 0.25);
        }
        .fmdq-alpha-radio:disabled + .fmdq-alpha-tile {
            cursor: default;
            background: #f8fafc;
            color: #94a3b8;
        }
        .fmdq-alpha-radio:disabled:checked + .fmdq-alpha-tile {
            background: #0c2b70 !important;
            border-color: #0c2b70 !important;
            color: #ffffff !important;
        }
        .nk-content .form-control:disabled,
        .nk-content .form-select:disabled {
            background-color: #f8fafc !important;
            color: #1e293b !important;
            opacity: 1 !important;
        }

        /* Standard Tables & DataTables Polish */
        .nk-content .table thead th,
        .nk-content table.dataTable thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1px solid #e2e8f0 !important;
            border-top: 1px solid #e2e8f0 !important;
            padding: 12px 14px !important;
        }
        .nk-content .table tbody td,
        .nk-content table.dataTable tbody td {
            padding: 13px 14px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #1e293b;
            vertical-align: middle;
        }
        .nk-content .table tbody tr:hover,
        .nk-content table.dataTable tbody tr:hover {
            background-color: #f8fafc !important;
        }

        /* Pagination -> FMDQ Navy Active State */
        .nk-content .pagination .page-item.active .page-link {
            background-color: #0c2b70 !important;
            border-color: #0c2b70 !important;
            color: #ffffff !important;
            font-weight: 600;
        }
        .nk-content .pagination .page-link {
            color: #334155 !important;
            border-color: #e2e8f0 !important;
            border-radius: 6px !important;
            margin: 0 2px;
        }
        .nk-content .pagination .page-link:hover {
            background-color: #f1f5f9 !important;
            color: #0c2b70 !important;
        }
    </style>

</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">

        <div class="nk-main ">
            @include('layouts.sidebar')
            @include('layouts.header')


            @yield('content')

            @include('layouts.footer')



            <script src="{{ asset('public/admin/js/bundle.js') }}"></script>
            <script src="{{ asset('public/admin/js/scripts.js') }}"></script>
            <script src="{{ asset('public/admin/js/charts/chart-ecommerce.js') }}"></script>
            <script src="{{ asset('public/admin/js/libs/datatable-btns.js') }}"></script>




            <link rel="stylesheet" href="{{ asset('public/admin/css/editors/summernote.css') }}">
            <script src="{{ asset('public/admin/js/libs/editors/summernote.js') }}"></script>
            <script src="{{ asset('public/admin/js/editors.js') }}"></script>
            

      @include('layouts.sessioncheck')
      @include('layouts.submit_spinner')

            <script>
                function loading() {
                    $(".btn .fa-spinner").show();
                    $(".btn .btn-text").html("Processing...");
                }

                document.getElementById('subcategoryForm').addEventListener('submit', function(event) {
                    if (this.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        loading();
                        document.getElementById('submitBtn').disabled = true;
                    }
                    this.classList.add('was-validated');
                }, false);

                // Global toast close button dismiss handler
                $(document).on('click', '.toast-close-button, #toast-container .toast-close-button', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var $toast = $(this).closest('.toast, .toastr');
                    $toast.stop(true, true).fadeOut(200, function() {
                        $(this).remove();
                        if ($('#toast-container').children().length === 0) {
                            $('#toast-container').remove();
                        }
                    });
                });
            </script>
</body>

</html>