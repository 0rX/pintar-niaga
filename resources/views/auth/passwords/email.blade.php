@extends('layouts.app')

@section('content')

@section('title')
    Password Reset
@endsection

<div class="container" data-bs-theme="dark">
    <div class="row justify-content-center">
        <div class="col-md-8 text-md-center">
            <div class="card text-center">
                <div class="card-header text-start">{{ __('Reset Password') }}</div>

                <div class="card-body text-secondary">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form data-bs-theme="light" method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="mb-3 pt-3">{{ __('Your Registered Email Address') }}</label>

                            <div class="col-md-6 offset-md-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror fs-5" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary mb-2 fs-5">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
