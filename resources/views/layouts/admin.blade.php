<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laran Panel</title>

    <link href="{{ asset('vendor/laran/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/laran/fonts/vazir/font-face.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Custom styles for sidebar width and icon animation --}}
    <style>
        .sidebar {
            width: 250px; /* Specific width for the sidebar */
        }

        /* CSS for rotating the icon */
        .rotated-icon {
            transform: rotate(-90deg);
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body style="font-family: Vazir;">

{{-- The main page container. d-flex enables flexbox. flex-row-reverse makes the content flow from right-to-left,
     but we will then order the elements to visually place the sidebar on the left. --}}
<div class="page-content d-flex h-100 flex-row-reverse">

    {{-- Main content wrapper. For RTL with flex-row-reverse, this should come first in the HTML to appear on the left. --}}
    <div class="content-wrapper flex-grow-1 overflow-auto">

        <nav class="navbar navbar-expand-lg shadow bg-white">
            <div class="container-fluid">
                <button class="btn d-lg-none" data-bs-toggle="collapse" data-bs-target="#sidebar">
                    <i class="fa-solid fa-list"></i>
                </button>

                <div class="collapse navbar-collapse">
                    <div class="me-auto">
                        <i class="fa-solid fa-calendar"></i>
                        {{-- {{ lt('today') .' '. verta()->format('l d F %Y') }} --}}
                    </div>
                </div>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                            <img src="{{ asset('vendor/laran/images/userIcon.png') }}" class="rounded-circle me-2" width="32" height="32">
                            <span>{{ auth()->guard('manager')->user()?->fullName }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="{{ route('admin.logout') }}" class="dropdown-item">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> {{ lt('Logout') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="p-4">
            <header class="mb-4">
                <h4>@yield('pageTitle')</h4>
                @yield('pageHeader')
            </header>

            @yield('content')
        </main>
        <footer class="navbar navbar-sm border-top p-2 mx-auto">
            <div class="container-fluid d-flex justify-content-between">
                <span class="text-muted">&copy; {{ date('Y') }} Laran Panel</span>
            </div>
        </footer>
    </div>

    {{-- Sidebar. With flex-row-reverse on the parent, this needs to be after the main content in the HTML
         to visually appear on the left. --}}
    <div class="sidebar bg-dark text-white overflow-auto">

        <div class="sidebar-section p-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="fw-bold">
                    <i id="laran-icon" class="fa-solid fa-angle-down me-1"></i>
                    <span>{{ lt('Laran Admin') }}</span>
                </a>
                <div>
                    <button class="btn btn-sm btn-outline-light d-none d-lg-inline-flex">
                        <i class="fa-solid fa-arrows-left-right"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-light d-lg-none">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="sidebar-content p-3">
            <div class="d-flex align-items-center mb-3">
                <img src="{{ url('vendor/laran/images/userIcon.png') }}" class="rounded-circle me-2" width="40" height="40">
                <div>
                    <div class="fw-semibold">
                        {{ auth()->guard('manager')->user()?->fullName }}
                    </div>
                    <small class="text-muted">{{ lt('Administrator') }}</small>
                </div>
            </div>
             @include('laran::layouts.menu')
        </div>
    </div>
</div>

<script src="{{ asset('vendor/laran/js/bootstrap.bundle.min.js') }}"></script>
@yield('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const laranLink = document.querySelector('.sidebar-section .fw-bold');
        const laranIcon = document.getElementById('laran-icon');

        if (laranLink && laranIcon) {
            laranLink.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                laranIcon.classList.toggle('rotated-icon');
            });
        }
    });
</script>

</body>
</html>
