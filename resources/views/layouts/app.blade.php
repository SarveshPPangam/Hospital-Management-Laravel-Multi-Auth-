<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('sidebar.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white">

                <a class="navbar-brand ml-8" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle w-25x4px" href="#logoutsubmenu" role="button" data-toggle="collapse" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="collapse list-unstyled" id="logoutsubmenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </li>
                                </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
           
        </nav>
         @if(Auth::guard('web')->check())
            <main>
                <div class="display-one mt-2">
                        <nav id="sidebar">
                            <div class="display-two">
                                <ul class="list-unstyled components">
                                    <li>
                                        <a href="{{ route('home') }}" class="text-center">
                                            <i class="fas fa-home mb-1"></i>
                                            Home
                                        </a>
                                    </li>
        
                                    <hr>
                                    <li>
                                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"
                                            class="dropdown-toggle text-center">
                                            <i class="fas fa-user-md mb-1"></i>
                                            Appointment
                                        </a>
                                        <ul class="collapse list-unstyled" id="pageSubmenu">
                                            <li>
                                                <a href="{{ route('bookAppointment') }}" class="text-center">Book Appointment</a>
                                                
                                            </li>
                                            <hr class="back">
                                            <li>
                                                <a href="{{ route('appointmentHistory') }}" class="text-center"> Appointment history </a>
                                            </li>
                                            
                                        </ul>
                                    </li>
                                    <hr>
        
                                    <li>
                                        <a href="{{ route('medicalHistory') }}" class="text-center"> Medical history </a>
                                    </li>
                                    <hr>
        
                                    <li>
                                        
                                        
                                    </li>
                                    <li>
                                        <a href="#profileSubmenu" data-toggle="collapse" aria-expanded="false"
                                            class="dropdown-toggle text-center">
                                            <i class="fas fa-user-md mb-1"></i>
                                            Profile
                                        </a>
                                        <ul class="collapse list-unstyled" id="profileSubmenu">
                                            <li>
                                                <a href="{{ route('home.updateUser') }}" class="text-center"> Update profile </a>
                                            </li>
                                            <hr class="back">
                                            <li>
                                                <a href="{{ route('home.updatePasswordForm') }}" class="text-center"> Update password </a>
                                            </li>
                                        </ul>
        
        
                                       
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        <button type="button" id="sidebarCollapse" class="navbar-btn">
                            <span></span>
                            <span></span>
                          </button>
                    @endif
                    <div class=" w-75x text-center">
            @yield('content')
        </main>
    </div>
</body>
</html>
