<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HMS') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

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
                    {{ config('app.name', 'HMS') }}
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


                        @else
                            @if(Auth::guard('doctor')->check())
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle w-25x4px" href="#logoutsubmenu" role="button" data-toggle="collapse" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <ul class="collapse list-unstyled" id="logoutsubmenu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('doctor.logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('doctor.logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


            @if(Auth::guard('doctor')->check())
    <div class="mt-2 text-center">
        <form action="{{ route('doctor.search') }}" id="search">
        @csrf
        <input class="search form__field" type="text" name="query" placeholder="Enter patient's name or mobile number">
        {{-- <button type="submit" > Search </button> --}}
    </form></div>
            <main>
                <div class="display-one">
                        <nav id="sidebar">
                            <div class="display-two">
                                <ul class="list-unstyled components">
                                    <li>
                                        <a href="{{ route('doctor.home') }}" class="text-center">
                                            <i class="fas fa-home mb-1"></i>
                                            Home
                                        </a>
                                    </li>
        
                                    <hr>
                                    <li>
                                        <a href="{{ route('doctor.appointmentHistory') }}" class="text-center"> <i class="fas fa-users mb-1"></i>Appointment history </a>
                                            
                                        </a>
                                    </li>
                                    <hr>
                                    <li>
                                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"
                                            class="dropdown-toggle text-center">
                                            <i class="fas fa-procedures mb-1"></i>
                                            Patient
                                        </a>
                                        <ul class="collapse list-unstyled" id="pageSubmenu">
                                            <li>
                                                <a href="{{ route('doctor.showPatients') }}" class="text-center"> Manage patients </a>
                                            </li>
                                            <hr class="back">
                                            <li>
                                                <a href="{{ route('doctor.addPatient') }}" class="text-center"> Add patient </a>
                                            </li>
                                       
                                        </ul>
                                    </li>
                                    <hr>
        
                                    
        
                                    <li>
                                        <a href="{{ route('doctor.updatePasswordForm') }}" class="text-center"> Update password </a>
                                    </li>
                                    
                                    
        
        
                                       
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
