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
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Create Product</h1>
                                <button type="button" class="btn btn-danger px-1 py-0 my-0" data-bs-dismiss="modal"
                                    aria-label="Close"><i class='bx bx-x fs-3 pt-1'></i></button>
                            </div>
                            <div class="modal-body">
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
                                        <div id="ingredients">
                                            <label>Ingredients:</label>
                                            <button type="button" id="add-ingredient" class="">Add Ingredient</button>
                                            <div class="ingredient">
                                                <select name="ingredients[0][name]">
                                                    @foreach($ingredients as $ingredient)
                                                        <option value="{{ $ingredient->name }}">{{ $ingredient->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="number" name="ingredients[0][amount]" placeholder="Amount">
                                                {{-- <button type="button" class="remove-ingredient">Remove</button> --}}
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
                                        <th class="text-center" scope="col">Price</th>
                                        <th class="text-start" scope="col">Description</th>
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
                                            <td style="max-width: 100px;">{{ $product->category->name }}</td>
                                            <td style="max-width: 100px;">{{ $product->sale_price }}</td>
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
  const ingredientsContainer = document.getElementById('ingredients');
  let ingredientCounter = 1;

  function cloneOptions(sourceSelect, targetSelect) {
    const options = sourceSelect.querySelectorAll('option');
    options.forEach(function(option) {
      const clonedOption = option.cloneNode(true);
      clonedOption.selected = option.selected;
      targetSelect.appendChild(clonedOption);
    });
  }

  addIngredientButton.addEventListener('click', function() {
    const ingredientDiv = document.createElement('div');
    ingredientDiv.classList.add('ingredient');

    const ingredientSelect = document.createElement('select');
    ingredientSelect.name = `ingredients[${ingredientCounter}][name]`;

    const firstSelect = document.querySelector('#ingredients select[name^="ingredients"]');
    cloneOptions(firstSelect, ingredientSelect);

    const amountInput = document.createElement('input');
    amountInput.type = 'number';
    amountInput.name = `ingredients[${ingredientCounter}][amount]`;
    amountInput.placeholder = 'Amount';

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.classList.add('remove-ingredient');
    removeButton.textContent = 'Remove';

    ingredientDiv.appendChild(ingredientSelect);
    ingredientDiv.appendChild(amountInput);
    ingredientDiv.appendChild(removeButton);

    ingredientsContainer.appendChild(ingredientDiv);

    ingredientCounter++;
  });

  ingredientsContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-ingredient')) {
      const ingredientDiv = event.target.closest('.ingredient');
      ingredientDiv.remove();
    }
  });

});

</script>

@endsection
