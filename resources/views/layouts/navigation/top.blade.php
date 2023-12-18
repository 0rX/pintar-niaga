<style>
    /** Custom CSS Styles here */
</style>

<nav class="navbar navbar-expand-md">
    <div class="container-fluid px-4">
        <a class="d-flex navbar-brand text-secondary fs-2 fw-bolder fst-italic" href="{{ url('/') }}">
            <img class="align-self-center px-1" style="width: 60px;" src="/storage/assets/logo/logo-blank-bg-1.svg" alt="Home">
            <div class="align-self-center px-1">
                <span id="logo-nav-start">Pintar</span>
                <span id="logo-nav-end">NIAGA</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @auth
                    <ul class="navbar-nav me-auto fst-italic fs-4">
                        <li class="nav-item">
                            <a class="nav-link left-menu py-auto mt-1 {{ (request()->is('index')) ? 'active' : '' }}" href="{{ url('/index') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link left-menu py-auto mt-1 {{ (request()->is('management/employee*')) ? 'active' : '' }}" href="{{ url('/management/employee') }}">Employee</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link left-menu py-auto mt-1 {{ (request()->is('management/reports*')) ? 'active' : '' }}" href="{{ url('/management') }}">Reports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link left-menu py-auto mt-1 {{ (request()->is('management/task*')) ? 'active' : '' }}" href="{{ url('/management') }}">Task</a>
                        </li>
                    </ul>
            @else
                <ul class="navbar-nav me-auto fst-italic fw-bolder fs-4">
                    <li class="nav-item">
                        <a class="nav-link left-menu py-auto mt-1" href="{{ url('/') }}">About</a>
                    </li>
                </ul>
            @endauth
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @php
                    $disabledCanvas = ['register','password/reset','login']
                @endphp

                @guest
                    @unless (in_array(Route::getCurrentRoute()->uri, $disabledCanvas))
                    <li class="nav-item">
                        <a class="nav-link fs-5 py-auto" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvaslogin" data-bs-target="#offcanvaslogin">{{ __('Login') }}</a>
                    </li>
                    @elseif (Route::getCurrentRoute()->uri === 'login')
                        <li class="nav-item">
                            <a class="nav-link fs-5 py-auto" href="{{ url('register') }}">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link fs-5 py-auto" href="{{ url('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endunless
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{-- <a class="nav-link fs-5" href="{{ url('profile') }}">{{ Auth::user()->name }}</a> --}}
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a href="{{ route('profile') }}" class="dropdown-item">
                                {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>