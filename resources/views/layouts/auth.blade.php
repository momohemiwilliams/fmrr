<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Session timeout configuration -->
    <meta name="session-timeout-minutes" content="{{ \App\Models\SessionSetting::getCurrentTimeout() }}">
    <link rel="stylesheet" href="{{ asset('public/users/style.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha384-R334r6kryDNB/GWs2kfB6blAOyWPCxjdHSww/mo7fel+o5TM/AOobJ0QpGRXSDh4" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Modern Auth Design Overrides */
        .onb-bg {
            min-height: 100vh !important;
            height: auto !important;
            padding: 40px 16px !important;
            background-image: url('{{ asset("public/users/assets/bg.png") }}') !important;
            background-color: #cccccc !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            background-attachment: fixed !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-direction: column !important;
            box-sizing: border-box !important;
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
        }

        .login-card {
            background-color: #ffffff !important;
            width: 440px !important;
            max-width: 95vw !important;
            border-top-left-radius: 28px !important;
            border-bottom-left-radius: 28px !important;
            border-bottom-right-radius: 28px !important;
            border-top-right-radius: 6px !important;
            box-shadow: 0 25px 60px -12px rgba(2, 14, 46, 0.6), 0 8px 24px -4px rgba(12, 43, 112, 0.25) !important;
            border: 1.5px solid rgba(213, 167, 59, 0.28) !important;
            padding: 36px 34px 32px 34px !important;
            box-sizing: border-box !important;
            position: relative !important;
            margin: auto !important;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 26px 20px 24px !important;
                border-radius: 22px !important;
            }
            .form-row-2col {
                grid-template-columns: 1fr !important;
                gap: 0 !important;
            }
        }

        .logo-container {
            width: 100% !important;
            padding-top: 0 !important;
            margin-bottom: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .logo-container img {
            width: 140px !important;
            height: auto !important;
        }

        .app-name, .app-name-padding {
            text-align: center !important;
            color: #0c2b70 !important;
            font-weight: 700 !important;
            font-size: 16px !important;
            line-height: 1.35 !important;
            margin: 0 0 22px 0 !important;
            padding: 0 8px !important;
            letter-spacing: -0.2px !important;
            font-family: inherit !important;
        }

        /* Segmented Auth Tabs */
        .auth-tabs-modern {
            display: flex;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 14px;
            margin-bottom: 22px;
            position: relative;
        }

        .auth-tab-modern {
            flex: 1;
            text-align: center;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            text-decoration: none !important;
            border-radius: 11px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-tab-modern:hover {
            color: #0c2b70;
        }

        .auth-tab-modern.active {
            background: #ffffff;
            color: #0c2b70;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(12, 43, 112, 0.12), 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* Modern Form Fields */
        .form-group-modern {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-label-modern {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            text-align: left;
        }

        .req-star {
            color: #dc2626;
            font-weight: 700;
            margin-left: 2px;
        }

        .input-wrapper-modern {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            background: #f8fafc !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 12px !important;
            transition: all 0.2s ease !important;
            height: 48px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .input-wrapper-modern:focus-within {
            background: #ffffff !important;
            border-color: #0c2b70 !important;
            box-shadow: 0 0 0 3px rgba(12, 43, 112, 0.12) !important;
        }

        .input-icon-modern {
            position: absolute !important;
            left: 14px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: #94a3b8 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            pointer-events: none !important;
            transition: color 0.2s ease !important;
            z-index: 2 !important;
        }

        .input-wrapper-modern:focus-within .input-icon-modern {
            color: #0c2b70 !important;
        }

        .form-control-modern {
            width: 100% !important;
            height: 100% !important;
            border: none !important;
            background: transparent !important;
            padding: 0 14px !important;
            font-size: 14px !important;
            color: #1e293b !important;
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
            outline: none !important;
            box-shadow: none !important;
            display: block !important;
            box-sizing: border-box !important;
        }

        input[type="password"].form-control-modern,
        input[type="text"].form-control-modern,
        input[type="email"].form-control-modern,
        input[type="tel"].form-control-modern {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
            font-size: 14px !important;
            letter-spacing: normal !important;
            color: #1e293b !important;
        }

        .form-control-modern.password-input {
            padding-right: 44px !important;
        }

        .form-control-modern::placeholder {
            color: #94a3b8 !important;
            font-size: 13.5px;
        }

        .password-toggle-btn {
            position: absolute !important;
            right: 0 !important;
            top: 0 !important;
            bottom: 0 !important;
            width: 44px !important;
            max-width: 44px !important;
            height: 100% !important;
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            color: #94a3b8 !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            outline: none !important;
            transition: color 0.15s ease !important;
            z-index: 5 !important;
        }

        .password-toggle-btn:hover {
            color: #0c2b70 !important;
        }

        /* 2-Column Grid for Register */
        .form-row-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        /* Password Policy Hint Box */
        .password-policy-box {
            background: #f0f4fd;
            border: 1px solid rgba(12, 43, 112, 0.12);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 12px;
            color: #334155;
            display: flex;
            gap: 8px;
            align-items: flex-start;
            margin-top: 4px;
            margin-bottom: 18px;
            line-height: 1.45;
            text-align: left;
        }

        .password-policy-box svg {
            flex-shrink: 0;
            margin-top: 2px;
            color: #0c2b70;
        }

        /* Auth Submit Button */
        .auth-submit-btn {
            width: 100% !important;
            height: 48px !important;
            background: linear-gradient(135deg, #0c2b70 0%, #17337f 100%) !important;
            border: 1.5px solid #d5a73b !important;
            border-top-left-radius: 14px !important;
            border-bottom-left-radius: 14px !important;
            border-bottom-right-radius: 14px !important;
            border-top-right-radius: 4px !important;
            color: #ffffff !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            letter-spacing: 0.3px !important;
            cursor: pointer !important;
            box-shadow: 0 4px 14px rgba(12, 43, 112, 0.25) !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            margin-top: 6px !important;
            text-decoration: none !important;
        }

        .auth-submit-btn:hover {
            background: linear-gradient(135deg, #103282 0%, #1d3c94 100%) !important;
            border-color: #f4d078 !important;
            box-shadow: 0 6px 18px rgba(213, 167, 59, 0.35) !important;
            transform: translateY(-1px) !important;
            color: #ffffff !important;
        }

        .auth-submit-btn:active {
            transform: translateY(0) !important;
        }

        .forgot-pass-link {
            display: inline-block;
            color: #0c2b70;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            transition: color 0.15s ease;
        }

        .forgot-pass-link:hover {
            color: #d5a73b;
            text-decoration: underline !important;
        }

        .auth-subtitle-modern {
            text-align: center;
            color: #64748b;
            font-size: 13.5px;
            line-height: 1.5;
            margin-bottom: 22px;
            padding: 0 6px;
        }

        .auth-footer-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13.5px;
            color: #64748b;
        }

        .auth-footer-link a {
            color: #0c2b70;
            font-weight: 700;
            text-decoration: none !important;
            margin-left: 4px;
            transition: color 0.15s ease;
        }

        .auth-footer-link a:hover {
            color: #d5a73b;
            text-decoration: underline !important;
        }

        .iqx {
            text-align: center;
            color: rgba(255, 255, 255, 0.75) !important;
            font-size: 12px !important;
            line-height: 1.6 !important;
            margin-top: 24px !important;
        }







    <style>
        .loader-mask {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            z-index: 99999;
        }

        /* .loader {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 50px;
            height: 50px;
            font-size: 0;
            color: #1d326d;
            display: inline-block;
            margin: -25px 0 0 -25px;
            text-indent: -9999em;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        } */

        .loader {
            position: absolute;
            left: 50%;
            top: 50%;
            /* width: 50px;
            height: 50px; */
            font-size: 0;
            color: #1d326d;
            display: inline-block;
            margin: -25px 0 0 -25px;
            text-indent: -9999em;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            width: 40px;
            height: 40px;
            --c: no-repeat linear-gradient(#1d326d 0 0);
            background: var(--c), var(--c), var(--c), var(--c);
            background-size: 21px 21px;
            animation: l5 1.5s infinite cubic-bezier(0.3, 1, 0, 1);
        }

        @keyframes l5 {
            0% {
                background-position: 0 0, 100% 0, 100% 100%, 0 100%
            }

            33% {
                background-position: 0 0, 100% 0, 100% 100%, 0 100%;
                width: 60px;
                height: 60px
            }

            66% {
                background-position: 100% 0, 100% 100%, 0 100%, 0 0;
                width: 60px;
                height: 60px
            }

            100% {
                background-position: 100% 0, 100% 100%, 0 100%, 0 0
            }
        }

        /* .lead {
            font-size: 13px;
        }

        .loader div {
            background-color: #1d326d;
            display: inline-block;
            float: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 50px;
            height: 50px;
            opacity: .5;
            border-radius: 50%;
            -webkit-animation: ballPulseDouble 2s ease-in-out infinite;
            animation: ballPulseDouble 2s ease-in-out infinite;
        }

        .loader div:last-child {
            -webkit-animation-delay: -1s;
            animation-delay: -1s;
        } */
        /*
        @-webkit-keyframes ballPulseDouble {

            0%,
            100% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }

            50% {
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        }

        @keyframes ballPulseDouble {

            0%,
            100% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }

            50% {
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        } */
    </style>











    <title>FMRR Login</title>
</head>

<body>
    {{-- <div class="loader-mask">
        <div class="loader">
            <div></div>
            <div></div>
        </div>
    </div> --}}



    @yield('content')



    <p class="iqx">Powered by iQx Consult Limited. <br>
Copyright © FMDQ Group PLC. All rights reserved.
</p>
    </div>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha384-Si3HKTyQYGU+NC4aAF3ThcOSvK+ZQiyEKlYyfjiIFKMqsnCmfHjGa1VK1kYP9UdS" crossorigin="anonymous"></script>
    <script>
        $(window).load('load', function() {
            // Preloader
            $('.loader').fadeOut();
            $('.loader-mask').delay(250).fadeOut('slow');
        });


        // $(window).load(function() {
        //     // Preloader
        //     $('.loader').fadeOut();
        //     $('.loader-mask').delay(150).fadeOut('slow');
        // });


        $(document).ready(function() {
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "400",
                    "timeOut": "5000",
                    "extendedTimeOut": "1500",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    "tapToDismiss": true
                };
            }

            // Delegated click handler to guarantee immediate dismissal on close button click
            $(document).on('click', '.toast-close-button, #toast-container .toast-close-button', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var $toast = $(this).closest('.toast');
                $toast.stop(true, true).fadeOut(200, function() {
                    $(this).remove();
                    if ($('#toast-container').children().length === 0) {
                        $('#toast-container').remove();
                    }
                });
            });

            @if (isset($errors) && $errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}', '');
                @endforeach
            @endif

            @if (session('success'))
                toastr.success('{{ session('success') }}', '');
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}', '');
            @endif
        });
    </script>

    <script>
        function loading() {
            $(".btn .fa-spinner").show();
            $(".btn .btn-text").html("Processing...");
        }


        document.addEventListener('DOMContentLoaded', function() {
            var groupForm = document.getElementById('groupForm');
            if (groupForm) {
                groupForm.addEventListener('submit', function(event) {
                    if (this.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        loading('addSubmitBtn');
                        var btn = document.getElementById('addSubmitBtn');
                        if (btn) btn.disabled = true;
                    }
                    this.classList.add('was-validated');
                }, false);
            }

            // Robust delegated password toggle with native DOM input type manipulation
            document.addEventListener('click', function(e) {
                var btn = e.target.closest('.password-toggle-btn');
                if (!btn) return;
                e.preventDefault();
                e.stopPropagation();

                var wrapper = btn.closest('.input-wrapper-modern');
                if (!wrapper) return;

                var input = wrapper.querySelector('input');
                if (!input) return;

                if (input.type === 'password') {
                    input.type = 'text';
                    var openIcon = btn.querySelector('.eye-open');
                    var closedIcon = btn.querySelector('.eye-closed');
                    if (openIcon) openIcon.classList.add('d-none');
                    if (closedIcon) closedIcon.classList.remove('d-none');
                    btn.style.color = '#0c2b70';
                } else {
                    input.type = 'password';
                    var openIcon = btn.querySelector('.eye-open');
                    var closedIcon = btn.querySelector('.eye-closed');
                    if (openIcon) openIcon.classList.remove('d-none');
                    if (closedIcon) closedIcon.classList.add('d-none');
                    btn.style.color = '#94a3b8';
                }
            });
        });
    </script>
    @include('layouts.submit_spinner')
</body>
</html>