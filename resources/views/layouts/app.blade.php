<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
    {{-- <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css?v=3.2.0"> --}}
    
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('/storage/assets/logo/favicon.ico') }}" type="x-icon">
    <link rel="icon" href="{{ url('/storage/assets/logo/favicon.ico') }}" type="x-icon">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script> --}}
    {{-- <script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ url("storage/scripts/Chart.min.js") }}"></script>
    {{-- <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script> --}}
    <script src="{{ url("storage/scripts/adminlte.min.js") }}"></script>
    {{-- <script src="{{ url("storage/scripts/demo.js") }}"></script> --}}

</head>
<body class="antialiased fs-5" data-bs-theme="dark">
    <div id="app">
        @php
            $topnavroute = ['index','profile','/','register','login','password/reset']
        @endphp
        @if (in_array(Route::current()->uri, $topnavroute))
            @include('layouts.navigation.top')
            <style>
                .home-section {
                    left: 0;
                    width: 100%;
                }
            </style>
        @else
            @include('components.component.company.sidenav')
        @endif
        <main class="home-section py-4 px-4">
            @yield('content')
        </main>
    </div>

    <script>

        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e)=>{
                let arrowParent = e.target.parentElement.parentElement;
                // console.log(arrowParent);
                arrowParent.classList.toggle("showMenu");

                localStorage.setItem('arrowToggle', arrowParent.classList.contains('showMenu'));
            });
        };
    
        let sidebar = document.querySelector(".sidebar-nav");
        let sidebarBtn = document.querySelectorAll(".side-toggle");
        for (var i = 0; i < sidebarBtn.length; i++) {
            sidebarBtn[i].addEventListener("click", (e)=>{
                let btnParent = e.target.parentElement.parentElement;
                // console.log(btnParent);
                sidebar.classList.toggle("close");

                localStorage.setItem('sidebarToggle', sidebar.classList.contains('close'));
            });
        };

        // Retrieve the toggle states from local storage when the page loads
        // const arrowToggle = localStorage.getItem('arrowToggle');
        const sidebarToggle = localStorage.getItem('sidebarToggle');

        // // Apply the toggle states to the respective elements
        // if (arrowToggle === 'true') {
        // let arrow = document.querySelectorAll(".arrow");
        // for (var i = 0; i < arrow.length; i++) {
        //     arrow[i].addEventListener("click", (e)=>{
        //         let arrowParent = e.target.parentElement.parentElement;
        //         arrowParent.classList.add('showMenu');
                
        //     });
        // };
        // } else {
        // let arrow = document.querySelectorAll(".arrow");
        // for (var i = 0; i < arrow.length; i++) {
        //     arrow[i].addEventListener("click", (e)=>{
        //         let arrowParent = e.target.parentElement.parentElement;
        //         arrowParent.classList.remove('showMenu');
                
        //     });
        // };
        // }

        if (sidebarToggle === 'true') {
        // Close the sidebar
        sidebar.classList.add('close');
        } else {
        // Open the sidebar
        sidebar.classList.remove('close');
        }

    
    </script>
</body>
</html>