@extends('layouts.app')

@section('content')
@guest
    @include('layouts.navigation.offcanvaslogin')
@endguest

@section('title')
    Welcome
@endsection

<div class="welcome">
    <div class="content-track d-flex flex-row">
        <div id="splitter-1" class="splitter">
            <img class="wc-logo-frame" src="storage/assets/logo/logo-blank-bg-1-frame.svg" alt="">
            <img class="wc-logo-accent" src="storage/assets/logo/logo-blank-bg-1-accent.svg" alt="">
            <div class="masking"></div>
        </div>
    </div>
</div>

@if (Session::has('flareOCV'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let offcanvasElement = document.querySelector('#offcanvaslogin');
            let bootstrapOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
            bootstrapOffcanvas.show();
            
            // Remove the showOffcanvas flag from the session
            fetch('/remove-ocv-flag')
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error(error));

        });
    </script>
@endif

@endsection
