@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="row justify-content-end px-4 fs-2">
                <div class="fw-bold">
                    Category {{ $category->name }}
                </div>
            </div>
            <div data-bs-theme="light" class="card border-1 mb-4" style="max-height: 500px;">
                <div class="card-body card-data-table">
                    @if ($products->count() > 0)
                        <div class="table">
                            <table class="table table-success table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="max-width: 15px;" scope="col">No</th>
                                        <th class="text-start" style="max-width: 75px;" scope="col">Picture</th>
                                        <th class="text-start" style="max-width: 40px;" scope="col">Product</th>
                                        <th class="text-center" style="max-width: 100px;" scope="col">Sell Price</th>
                                        <th class="text-start" style="max-width: 100px;" scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td class="text-center">{{ ++$key }}</td>
                                            <td class="text-start" style="max-width: 100px;">
                                                @php
                                                    $imagepath = 'storage/images/'.$product->image;
                                                @endphp
                                                <img src="{{ url($imagepath) }}" alt="{{ $product->name }}" width="90px" class="img-fluid">
                                            </td>
                                            <td class="text-start" style="max-width: 40px;">{{ $product->name }}</td>
                                            <td class="text-center" style="max-width: 100px;">{{ $product->sale_price }}</td>
                                            <td class="text-start" style="max-width: 100px;">{{ $product->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0 text-center">Nothing here</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
