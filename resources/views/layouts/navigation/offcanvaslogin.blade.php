
<style>
    /** Custom CSS items */
</style>


<!-- offcanvas Section start-->
<div class="offcanvas offcanvas-end bg-dark text-secondary d-flex flex-row position-fixed" tabindex="-1" id="offcanvaslogin" aria-labelledby="offcanvasLoginLabel">
    <div class="pt-4 ps-3" data-bs-theme="dark">
        <button type="button" class="btn-close text-reset fs-6" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="me-4">
        <div class="offcanvas-header d-flex flex-row justify-content-center">
            <h5 class="h2 p-2" id="offcanvasLoginLabel">Login</h5>
        </div>
    
        <div class="offcanvas-body d-flex flex-column">
            <div class="mx-2 mt-5 pt-5">
                <form id="sambit" method="POST" onsubmit="return submitValid(this);">
                    @csrf
    
                    <div class="d-flex flex-column">
                        <label for="email" class="mx-auto pb-2">{{ __('Email Address') }}</label>
    
                        <div class="">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror fs-5" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert" data-bs-toggle="offcanvas" aria-controls="offcanvaslogin" data-bs-target="#offcanvaslogin">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
    
                        <label for="password" class="mx-auto pt-4 pb-2">{{ __('Password') }}</label>
    
                        <div class="">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror font-monospace" name="password" required autocomplete="current-password">
    
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="d-flex flex-row justify-content-center pt-3">
                        <div class="form-check fs-6">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
    
                    <div class="d-flex flex-column justify-content-center pt-3 mx-4">
                        
                        <button type="submit" class="btn btn-primary px-5 mx-2" >
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="d-flex flex-row mb-3 mt-5">
                <hr class="ms-auto px-4">
                <p id="content-change-text" class="pt-1 px-2 text-light"> Don't have account yet ? </p>
                <hr class="me-auto px-4">
            </div>
            <div class="mx-auto">
    
                <a href="{{ url('/register') }}" class="btn btn-link text-decoration-none fs-5">Create Account</a>
    
            </div>
        </div>
    </div>
</div>
<!-- offcanvas end -->


<script>

function submitValid(form) {
  form.action = "/logincanvas";
  //window.onerror=alert(form.action);
  return form.action;
};

//document.addEventListener('DOMContentLoaded', function() {
//    let offcanvasElement = document.getElementById('#offcanvaslogin');
//    console.log('it flared');
//    let bootstrapOffcanvas = bootstrap.Offcanvas(offcanvasElement);
//    bootstrapOffcanvas.show();
//});
</script>