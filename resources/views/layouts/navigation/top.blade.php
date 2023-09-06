<style>
    /** Custom CSS Styles here */
</style>

<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand text-secondary fs-1 fw-bolder fst-italic" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto border border-dark">
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
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Keluar Bro') }}
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