@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div data-bs-theme="light" class="card border-1 mb-4" style="max-height: 600px;">
                <div class="card-header d-flex fw-bold">
                    <div class="me-auto">
                        {{ $title }}
                    </div>
                    <div class="ms-auto">
                        <button type="button" data-bs-toggle="modal"
                            data-bs-target="#addAccModal"
                            class="btn btn btn-primary text-white d-flex align-items-center gap-2">
                            <i class='bx bx-plus-circle fs-4'></i> New Item
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="addAccModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Create Item</h1>
                                <button type="button" class="btn btn-danger px-1 py-0 my-0" data-bs-dismiss="modal"
                                    aria-label="Close"><i class='bx bx-x fs-3 pt-1'></i></button>
                            </div>
                            <div class="modal-body">
                                <form enctype="multipart/form-data" action="{{ route('inventory-index.store') }}" method="post">
                                    @csrf
                                    <div class="mb-5">
                                        <label for="cp_index" class="ms-2">Company Index</label>
                                        <input type="text" value="{{ $cp_index }}" name="cp_index" id="cp_index" class="form-control mb-3 fs-5" readonly>
                                        <label for="name" class="ms-2">Item Name</label>
                                        <input type="text" name="name" id="name" class="form-control mb-3 fs-5" required>
                                        <label for="purchase_price" class="ms-2">Purchase Price</label>
                                        <input type="number" name="purchase_price" id="purchase_price" class="form-control mb-3 fs-5" required>
                                        <label for="stock" class="ms-2">Stock</label>
                                        <input type="number" name="stock" id="stock" class="form-control mb-3 fs-5" required>
                                        <label for="amount_unit" class="ms-2">Measure Unit</label>
                                        <input type="text" name="amount_unit" id="amount_unit" class="form-control mb-3 fs-5" required>
                                        <label for="image" class="ms-2">Image</label>
                                        <input type="file" name="image" id="image" accept="image/.jpg, image/.png, image/.jpeg" class="form-control mb-3 fs-5" required>
                                        <label for="description" class="ms-2">Description</label>
                                        <textarea name="description" id="description" class="form-control mb-3 fs-5" row="3" style="resize:none;"></textarea>
                                    </div>
                                    <div class="d-flex my-3 align-items-center justify-content-center gap-2">
                                        <button class="btn btn-primary" type="submit">
                                            Create
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body card-data-table">
                    @if ($ingredients->count() > 0)
                        @php
                            $cp_index += 1;
                        @endphp
                        <div class="table">
                            <table class="table table-striped align-middle table-primary">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">No</th>
                                        <th class="text-start" scope="col">Picture</th>
                                        <th class="text-start" scope="col">Name</th>
                                        <th class="text-start" scope="col">Stock</th>
                                        <th class="text-center" scope="col">Price</th>
                                        <th class="text-start" scope="col">Description</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    @foreach ($ingredients as $key => $ingredient)
                                        <tr>
                                            <td class="text-center align-self-middle">{{ ++$key }}</td>
                                            <td style="max-width: 100px;">
                                                @php
                                                    $imagepath = 'storage/images/'.$ingredient->image;
                                                @endphp
                                                <img src="{{ url($imagepath) }}" alt="{{ $ingredient->name }}" width="90px" class="img-fluid">
                                            </td>
                                            @php
                                                $ig_index = $ingredient->pluck('name')->search($ingredient->name) + 1;
                                            @endphp
                                            <td style="max-width: 100px;">
                                                <a href="/manage/{{ $cp_index }}/inventory/{{ $ig_index }}/">
                                                    {{ $ingredient->name }}
                                                </a>
                                            </td>
                                            <td style="max-width: 100px;">{{ number_format($ingredient->stock) }} {{ $ingredient->amount_unit }}</td>
                                            <td class="text-center" style="max-width: 100px;">Rp. {{ number_format((int)$ingredient->purchase_price) }}</td>
                                            <td style="max-width: 150px;">{{ $ingredient->description }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#addModal{{ $ingredient->ingredient_id }}"
                                                        class="btn btn-sm btn-primary text-white d-flex align-items-center gap-2">
                                                        <i class='bx bx-edit'></i> Edit
                                                    </button>
                                                    {{-- @if ($company->id > 0) --}}
                                                    <form action="{{ route('inventory-index.destroy', $ingredient->ingredient_id) }}" method="post"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm d-flex align-items-center gap-2 py-2"
                                                            onclick="return confirm('Delete {{ $ingredient->name }} ?')">
                                                            <i class='bx bxs-trash' ></i>
                                                        </button>
                                                    </form>
                                                    {{-- @endif --}}
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="addModal{{ $ingredient->ingredient_id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">Edit {{ $ingredient->name }}</h1>
                                                        <button type="button" class="btn btn-danger px-1 py-0 my-0" data-bs-dismiss="modal"
                                                            aria-label="Close"><i class='bx bx-x fs-3 pt-1'></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form enctype="multipart/form-data" action="{{ route('inventory-index.update', $ingredient->ingredient_id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-5">
                                                                <label for="name" class="ms-2">Item Name</label>
                                                                <input value="{{ $ingredient->name }}" type="text" name="name" id="name" class="form-control mb-3 fs-5" required>
                                                                <label for="stock" class="ms-2">Stock</label>
                                                                <input value="{{ $ingredient->stock }}" type="number" name="stock" id="stock" class="form-control mb-3 fs-5" required>
                                                                <label for="amount_unit" class="ms-2">Measure Unit</label>
                                                                <input value="{{ $ingredient->amount_unit }}" type="text" name="amount_unit" id="amount_unit" class="form-control mb-3 fs-5" required>
                                                                <label for="purchase_price" class="ms-2">Purchase Price</label>
                                                                <input value="{{ $ingredient->purchase_price }}" type="number" name="purchase_price" id="purchase_price" class="form-control mb-3 fs-5" required>
                                                                <label for="image" class="ms-2">Image</label>
                                                                <input type="file" name="image" id="image" accept="image/.jpg, image/.png, image/.jpeg" class="form-control mb-3 fs-5">
                                                                <label for="description" class="ms-2">Description</label>
                                                                <textarea name="description" id="description" class="form-control mb-3 fs-5" row="3" style="resize:none;">{{ $ingredient->description }}</textarea>
                                                            </div>
                                                            <button class="btn btn-primary px-4" type="submit">
                                                                Save Changes
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0 text-danger text-center">Nothing here</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
