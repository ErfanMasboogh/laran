<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laran Panel</title>

    <link href="{{ asset('vendor/laran/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/laran/fonts/vazir/font-face.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/laran/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('head')
    @yield('head')

    <style>
        .sidebar {
            width: 250px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .rotated-icon {
            transform: rotate(90deg);
            transition: transform 0.15s ease;
        }

        #user-dropdown-toggle::after {
            transition: transform 0.15s ease-in-out !important;
        }

        #user-dropdown-toggle.dropdown-rotate-left::after {
            transform: rotate(90deg) !important;
        }
    </style>
</head>

@php
    $imagePath = asset('vendor/laran/images/userIcon.png');

    $imageSID = auth()->guard('manager')->user()->imageSID;
    if ($imageSID) {
        $imagePath = route('storage.download', $imageSID);
    }
@endphp

<body style="font-family: Vazir;">

<div class="page-content d-flex h-100 flex-row-reverse">

    <div class="content-wrapper flex-grow-1 overflow-auto">

        <nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm">
            <div class="container-fluid">
                <button class="btn d-lg-none" data-bs-toggle="collapse" data-bs-target="#sidebar">
                    <i class="fa-solid fa-list"></i>
                </button>

                @php
                if (app()->getLocale() == 'fa') {
                    $date = Morilog\Jalali\Jalalian::forge(now())->format('l d F %Y');
                } else {
                    $date = now()->isoFormat('dddd D MMMM YYYY');
                }
                @endphp

                <div class="collapse navbar-collapse">
                    <div class="ms-auto">
                        <i class="fa-solid fa-calendar"></i>
                         {{ lt('Today') . ' ' . $date }}
                    </div>
                </div>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="user-dropdown-toggle" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ $imagePath }}" class="rounded-circle me-2 mx-1" width="32" height="32">
                            <span class="m-1" >{{ auth()->guard('manager')->user()?->fullName }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="{{ route('admin.logout') }}" class="dropdown-item">
                                    <i class="fa fa-right-from-bracket mx-1"></i> {{ lt('Logout') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="p-4 m-3">
            <div class="content-inner">
                <!-- Page header -->
                <div class="page-header">
                    <div class="page-header-content d-lg-flex">
                        <div class="d-flex">
                            @yield('pageHeader')
                        </div>
                    </div>
                </div>
                <!-- /page header -->

                <!-- Content area -->
                <div class="content">
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <h4 class="mb-3" style="margin-top: -12px">
                                        @yield('pageTitle')
                                    </h4>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible mb-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            {{$error}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                {{session('success')}}
                            </div>
                        @endif
                    </div>
                    @yield('content')
                </div>
                </div>
        </main>
        <footer class="navbar navbar-sm border-top p-2 mt-auto">
            <div class="container-fluid d-flex justify-content-between">
                <span class="text-muted mx-auto">&copy; {{ date('Y') }} Laran Panel</span>
            </div>
        </footer>
    </div>

    <div class="sidebar text-white bg-dark overflow-auto">
        <div class="sidebar-content p-3">
            <div class="d-flex flex-column align-items-center text-center mb-2 mt-2">
                <img src="{{ $imagePath }}" class="rounded-circle mb-3" width="60" height="60">
                <div class="mb-1">
                    <div class="fw-semibold text-white">
                        {{ auth()->guard('manager')->user()?->fullName }}
                    </div>
                    <small class="text">{{ lt('Administrator') }}</small>
                </div>
            </div>
            @include('laran::layouts.menu')
        </div>
    </div>
</div>

<script src="{{ asset('vendor/laran/js/bootstrap.bundle.min.js') }}"></script>
@stack('js')
@yield('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userDropdownToggle = document.getElementById('user-dropdown-toggle');
        const userDropdown = userDropdownToggle ? userDropdownToggle.closest('.dropdown') : null;

        if (userDropdown && userDropdownToggle) {
            userDropdown.addEventListener('show.bs.dropdown', function () {
                userDropdownToggle.classList.add('dropdown-rotate-left');
            });

            userDropdown.addEventListener('hide.bs.dropdown', function () {
                userDropdownToggle.classList.remove('dropdown-rotate-left');
            });
        }
    });
</script>

</body>
</html>
