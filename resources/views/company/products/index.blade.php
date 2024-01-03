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
                            class="btn btn-sm btn-primary text-white d-flex align-items-center gap-2">
                            <i class='bx bx-plus-circle fs-4'></i> New Product
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="addAccModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="width: 720px;">
                            <div class="modal-header">
                                <h1 class="modal-title fw-bold fs-5 text-dark">Create Product</h1>
                                <button type="button" class="btn btn-danger px-1 py-0 my-0" data-bs-dismiss="modal"
                                    aria-label="Close"><i class='bx bx-x fs-3 pt-1'></i></button>
                            </div>
                            <div class="modal-body mx-4">
                                <form enctype="multipart/form-data" action="{{ route('products-index.store') }}" method="post">
                                    @csrf
                                    <div class="mb-5">
                                        <label for="cp_index" class="ms-2">Company Index</label>
                                        <input type="text" value="{{ $cp_index }}" name="cp_index" id="cp_index" class="form-control mb-3 fs-5" readonly>
                                        <label for="name" class="ms-2">Product Name</label>
                                        <input type="text" name="name" id="name" class="form-control mb-3 fs-5" required>
                                        <label for="category_id" class="ms-2">Category</label>
                                        <select name="category_id" id="category_id" class="form-select mb-3 fs-5" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div id="ingredients" class="my-4 ms-3">
                                            <div class="ingredient">
                                                <div class="table">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-start" style="width: 400px;">Ingredient</th>
                                                                <th class="text-center">Amount</th>
                                                                <th class="text-center">
                                                                    <i class="bx bx-trash align-self-center mx-2"></i>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" class="text-center">
                                                                    <button type="button" id="add-ingredient" class="btn btn-success mx-2 px-5">
                                                                        <i class="bx bx-plus"></i> Add Ingredient
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody">
                                                            <tr>
                                                                <td>
                                                                    <select class="mt-2 py-1" name="ingredients[0][name]" required>
                                                                        @foreach($ingredients as $ingredient)
                                                                            <option value="{{ $ingredient->name }}">{{ Str::limit($ingredient->name, 30) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="mt-2" type="number" name="ingredients[0][amount]" placeholder="Amount" required>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="remove-ingredient btn btn-lg btn-danger">
                                                                        <i class="bx bx-trash fs-5"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <label for="sale_price" class="ms-2">Sale Price</label>
                                        <input type="number" name="sale_price" id="sale_price" class="form-control mb-3 fs-5" required>
                                        <label for="image" class="ms-2">Image</label>
                                        <input type="file" name="image" accept="image/.png, image/.jpg, image/.jpeg" id="image" class="form-control mb-3 fs-5">
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
                    @if ($products->count() > 0)
                        @php
                            $cp_index += 1;
                        @endphp
                        <div class="table">
                            <table class="table table-striped align-middle table-warning">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">No</th>
                                        <th class="text-start" scope="col">Picture</th>
                                        <th class="text-start" scope="col">Name</th>
                                        <th class="text-center" scope="col">Category</th>
                                        <th class="text-start" scope="col">Price</th>
                                        <th class="text-center" scope="col">Description</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td class="text-center">{{ ++$key }}</td>
                                            <td style="max-width: 100px;">
                                                @php
                                                    $imagepath = 'storage/images/'.$product->image;
                                                @endphp
                                                <img src="{{ asset($imagepath) }}" alt="{{ $product->name }}" width="90px" class="img-fluid">
                                            </td>
                                            @php
                                                $pd_index = $products->pluck('name')->search($product->name) + 1;
                                            @endphp
                                            <td style="max-width: 100px;">
                                                <a href="/manage/{{ $cp_index }}/products/{{ $pd_index }}/">
                                                    {{ $product->name }}
                                                </a>
                                            </td>
                                            <td class="text-center" style="max-width: 100px;">{{ $product->category->name }}</td>
                                            <td style="max-width: 100px;">Rp {{ number_format($product->sale_price) }}</td>
                                            <td style="max-width: 150px;">{{ $product->description }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    {{-- @if ($company->id > 0) --}}
                                                    <form action="{{ route('products-index.destroy', $product->product_id) }}" method="post"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm d-flex align-items-center gap-2 py-2"
                                                            onclick="return confirm('Delete {{ $product->name }} ?')">
                                                            <i class='bx bxs-trash' ></i>
                                                        </button>
                                                    </form>
                                                    {{-- @endif --}}
                                                </div>
                                            </td>
                                        </tr>
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

<script>

document.addEventListener('DOMContentLoaded', function() {
    const addIngredientButton = document.getElementById('add-ingredient');
  const ingredientsContainer = document.getElementById('tbody');

  addIngredientButton.addEventListener('click', function() {
    const ingredientRow = document.createElement('tr');
    ingredientRow.innerHTML = `
      <td>
        <select class="mt-2 py-1" name="ingredients[${ingredientsContainer.childElementCount}][name]">
          @foreach($ingredients as $ingredient)
          <option value="{{ $ingredient->name }}">{{ $ingredient->name }}</option>
          @endforeach
        </select>
      </td>
      <td>
        <input class="mt-2" type="number" name="ingredients[${ingredientsContainer.childElementCount}][amount]" placeholder="Amount">
      </td>
      <td>
        <button type="button" class="remove-ingredient btn btn-lg btn-danger">
          <i class="bx bx-trash fs-5"></i>
        </button>
      </td>
    `;

    ingredientsContainer.appendChild(ingredientRow);
  });

  ingredientsContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-ingredient')) {
      const ingredientRow = event.target.closest('tr');
      ingredientRow.remove();
    }
  });

});

</script>

@endsection
