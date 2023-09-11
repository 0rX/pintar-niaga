@extends('layouts.app')

@section('content')
@guest
    @include('layouts.navigation.offcanvaslogin')
@endguest
<div class="container cover justify-content-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <section class="parallax">
                <div id="parallax-text1" class="text-danger px-1 fst-italic">{{ __('Vegas') }}</div>
                <div id="middlebox" class="text-danger fst-italic">{{ __('Finance') }}</div>
                <div id="parallax-text2" class="text-danger px-1 fst-italic">{{ __('Delta') }}</div>
            </section>
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
