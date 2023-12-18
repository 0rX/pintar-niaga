@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div data-bs-theme="light" class="card border-1 mb-4" style="max-height: 800px;">
                <div class="card-body">
                    <div class="row fs-2 fw-bold">
                        <div class="col-md-6 text-start">
                            Transaction Detail
                        </div>
                        <div class="col-md-6 text-end">
                            Deposit
                        </div>
                    </div>
                    <hr>
                    <div class="row my-1 px-1">
                        <h3 class="card-title fw-bold">{{ $payment->title }}</h3>
                        <div class="ms-3 mt-3">
                            <p class="card-text"><label for="sale-price" class="fw-bold">Account:</label> {{ $account->name }}</p>
                            <p class="card-text"><label for="category" class="fw-bold">Deposit:</label> Rp. {{ number_format($payment->total_amount) }}</p>
                            <p class="card-text">
                                <label for="description" class="fw-bold">Description:</label> 
                                <br>
                                <div class="ms-4 fst-italic">
                                    {{ $payment->description }}
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
