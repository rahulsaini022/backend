<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel 8 User Roles and Permissions Tutorial') }}</title>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">


    <style>


    </style>
</head>

<body>
    <div id="app">

        <header class="section-header ">
            <nav class="navbar navbar-expand-md navbar-dark bg-blue py-3">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">

                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto"></ul>


                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li><a class="nav-link" href="{{ route('login') }}"> {{ __('Login') }}</a></li>
                                <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @else
                                <li><a class="nav-link" href="{{route('home',Auth::user()->roles[0]->name)  }}"><i
                                            class="fa fa-tachometer-alt"></i> {{ __('Dashboard') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fa fa-user"></i> {{ Auth::user()->name }} <span
                                            class="caret"></span>
                                    </a>


                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                            <i class="fa fa-right-from-bracket"></i> {{ __('Logout') }}
                                        </a>


                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header> <!-- section-header.// -->

        <div class="container">

            <section class="section-content py-4">
                <div class="row">
                    {{-- {{Auth::user()->roles[0]->name}} --}}
                    @hasanyrole('Admin|user|test')
                        <aside class="col-lg-3">
                            <!-- ============= COMPONENT ============== -->
                            <nav class="sidebar card py-2 mb-4">
                                <ul class="nav flex-column" id="nav_accordion">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
                                    </li>
                                    <li><a class="nav-link" href="{{ route('home',Auth::user()->roles[0]->name) }}"><i
                                                class="fa fa-tachometer-alt"></i> {{ __('Dashboard') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#menu_item1"
                                            href="#"><i class="fa fa-cogs"></i> Manage <i
                                                class="bi small bi-caret-down-fill"></i> </a>
                                        <ul id="menu_item1" class="submenu collapse" data-bs-parent="#nav_accordion">

                                            @can('user-list')
                                                <li><a class="nav-link" href="{{ route('users.index',Auth::user()->roles[0]->name) }}"><i
                                                            class="fa fa-users"></i> Users</a></li>
                                                
                                           @endcan
                                            @can('role-list')
                                               
                                                <li><a class="nav-link" href="{{ route('roles.index',Auth::user()->roles[0]->name) }}"><i
                                                            class="fa fa-universal-access"> </i> Role</a></li>
                                               @endcan
                                                      
                                            @can('product-list')
                                                <li><a class="nav-link" href="{{ route('products.index',Auth::user()->roles[0]->name) }}"><i
                                                            class="fa-brands fa-product-hunt"></i> Product</a></li>
                                           @endcan
                                        </ul>

                                    </li>


                                </ul>
                            </nav>
                            <!-- ============= COMPONENT END// ============== -->
                        </aside>
                    @endhasrole

                    <main class=" col-md-9 mx-auto">
                        <div class="container card p-3">
                            @yield('content')
                        </div>
                    </main>
                </div>
            </section>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.min.js"
                integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
