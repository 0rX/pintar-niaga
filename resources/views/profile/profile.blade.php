@extends('layouts.app')

@section('content')

@section('title')
    Profile
@endsection

<div class="container d-flex flex-column">
    <div data-bs-theme="light" class="card border-1 mb-4" style="max-height: 700px;">
        <div class="card-header d-flex fw-bold">
            <div class="me-auto">
                {{ __('Staff Positions') }}
            </div>
        </div>
        <div class="card-body">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            Update Profile
                        </div>
                    </div>
        
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            Update Password
                        </div>
                    </div>
        
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            Deactivate your account
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection