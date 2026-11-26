<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Session timeout configuration -->
    <meta name="session-timeout-minutes" content="{{ \App\Models\SessionSetting::getCurrentTimeout() }}">
    <link rel="stylesheet" href="{{ asset('public/users/style.css') }}" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>FMRR - {{ $marketTag->name }}</title>

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

        .loader {
            position: absolute;
            left: 50%;
            top: 50%;
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
    </style>
</head>

<body>
    <div class="loader-mask" id="loader-mask">
        <div class="loader">
            <div></div>
        </div>
    </div>

    <script>
        function dismissLoader() {
            var mask = document.getElementById('loader-mask');
            if (mask && mask.style.display !== 'none') {
                if (typeof $ !== 'undefined') {
                    $('.loader').fadeOut(200);
                    $('.loader-mask').fadeOut(300);
                } else {
                    mask.style.display = 'none';
                }
            }
        }
        window.addEventListener('load', dismissLoader);
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(dismissLoader, 600); // Safety fallback: prevents stuck blank page
        });
    </script>

    <div class="full-page">
        <div class="content">
            @include('layouts.externalheadertag')



            @yield('content')


            @include('layouts.footer')
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sessionTimeoutMinutes = parseInt(document.querySelector('meta[name="session-timeout-minutes"]')?.content || 30);
        const sessionTimeoutMs = sessionTimeoutMinutes * 60 * 1000;
        const warningTimeMs = 2 * 60 * 1000; // 2 minutes before expiry
        
        let timeoutWarning;
        let timeoutExpiry;
        
        function resetSessionTimer() {
            clearTimeout(timeoutWarning);
            clearTimeout(timeoutExpiry);
            
            // Set warning timer
            timeoutWarning = setTimeout(() => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Session Warning',
                    text: 'Your session will expire in 2 minutes due to inactivity.',
                    confirmButtonColor: '#3c4d62'
                });
            }, sessionTimeoutMs - warningTimeMs);
            
            // Set expiry timer
            timeoutExpiry = setTimeout(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Session Expired',
                    text: 'Your session has expired. Please log in again.',
                    confirmButtonColor: '#3c4d62'
                }).then(() => {
                    window.location.href = '/login';
                });
            }, sessionTimeoutMs);
            
            // Keep session alive on server
            fetch('/keep-alive', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        }
        
        // Track user activity
        const activityEvents = ['mousedown', 'keydown', 'scroll', 'touchstart'];
        activityEvents.forEach(event => {
            document.addEventListener(event, resetSessionTimer, true);
        });
        
        // Initialize timer
        resetSessionTimer();
    });

    $(document).ready(function() {
        @if ($errors->any())
            @php
                $errorMessages = implode('<br>', $errors->all());
            @endphp
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: '{!! $errorMessages !!}',
                confirmButtonColor: '#3c4d62'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#3c4d62'
            });
        @endif
    });
</script>
@include('layouts.submit_spinner')

</html>
