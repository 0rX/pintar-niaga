@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Account Transactions</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table rows for sales -->
                            @foreach ($sales as $sale)
                            @php
                                $sl_index = $sales->pluck('sale_id')->search($sale->sale_id) + 1;
                            @endphp
                                <tr>
                                    <td>Sale - {{ $sl_index }}</td>
                                    <td>Rp. {{ number_format($sale->total_amount) }}</td>
                                    <td>{{ $sale->created_at }}</td>
                                </tr>
                            @endforeach
                            
                            <!-- Table rows for purchases -->
                            @foreach ($purchases as $purchase)
                            @php
                                $pc_index = $purchases->pluck('purchase_id')->search($purchase->purchase_id) + 1;
                            @endphp
                                <tr>
                                    <td>Purchase - {{ $pc_index }}</td>
                                    <td>Rp. {{ number_format($purchase->total_amount) }}</td>
                                    <td>{{ $purchase->created_at }}</td>
                                </tr>
                            @endforeach
                            
                            <!-- Table rows for cashins -->
                            @foreach ($cashins as $cashin)
                            @php
                                $ci_index = $cashins->pluck('cash_in_id')->search($cashin->cash_in_id) + 1;
                            @endphp
                                <tr>
                                    <td>(Cashin - {{ $ci_index }}) {{ $cashin->title }} </td>
                                    <td>Rp. {{ number_format($cashin->total_amount) }}</td>
                                    <td>{{ $cashin->created_at }}</td>
                                </tr>
                            @endforeach
                            
                            <!-- Table rows for payments -->
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>Payment</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Content for the second card -->
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Content for the third card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
