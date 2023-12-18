@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div data-bs-theme="light" class="card border-0 mb-4 bg-dark" style="max-height: 800px;">
                <div class="card-body">
                    <div class="row mb-0">
                        <div class="col-md-6">
                            <div class="card text-light" style="background: #11101d">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            @php
                                                $imagepath = 'storage/images/'.$ingredient->image;
                                            @endphp
                                            <img src="{{ url($imagepath) }}" alt="{{ $ingredient->name }}" width="100%" class="img-fluid">
                                        </div>
                                        <div class="col-md-8">
                                            <h3 class="card-title fw-bold mb-3">{{ $ingredient->name }}</h3>
                                            <p class="card-text"><label for="stok" class="fw-bold">Stok:</label>  {{ $ingredient->stock }}{{ $ingredient->amount_unit }}</p>
                                            <p class="card-text"><label for="sale-price" class="fw-bold">Purchase Price:</label>  Rp {{ number_format($ingredient->purchase_price) }}</p>
                                        </div>
                                    </div>
                                    <div class="row mx-2 mt-3">
                                        <p class="card-text">
                                            <label for="description" class="fw-bold">Description:</label> 
                                            <br>
                                            <div class="ms-4 fst-italic">
                                                {{ $ingredient->description }}
                                            </div>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end mt-5">
                                        <form action="{{ route('inventory-index.destroy', $ingredient->ingredient_id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger text-light btn-lg d-flex align-items-center gap-2 py-2"
                                                onclick="return confirm('Delete {{ $ingredient->name }} ?')">
                                                <i class='bx bxs-trash' ></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-light" style="background: #11101d">
                                <div class="card-header text-center">
                                    <h3 class="card-title fw-bold mt-3">Required For</h3>
                                </div>
                                <div class="card-body custom-scrollbar" style="max-height: 550px; overflow-y: scroll;">
                                    <p class="card-text">
                                        @php
                                            $uses = [];
                                            foreach ($products as $key => $product) {
                                                $recipe = json_decode($product->recipe, true);
                                                foreach ($recipe as $item) {
                                                    if ($item['name'] === $ingredient->name) {
                                                        $uses[$key] = $product;
                                                        $uses[$key]['amount_use'] = $item['amount'];
                                                    }
                                                }
                                            }
                                            $recipe = json_decode($ingredient->recipe, true);
                                            // dd($uses);
                                        @endphp
                                        @foreach($uses as $product)
                                            <div class="card my-1 text-light" style="background: #1b192d">
                                                @php
                                                    $ig_index = $ingredients->pluck('name')->search($ingredient['name'])
                                                @endphp
                                                <div class="card-body">
                                                    <h5 class="card-title fw-bold mb-3">{{ $product->name }}</h5>
                                                    <p class="card-text py-0 my-1">Amount needed: {{ $product['amount_use'] }} {{ $ingredient->amount_unit }}</p>
                                                    <p class="card-text py-0 my-1">Sale Price: Rp {{ number_format($product->sale_price) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </p>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
