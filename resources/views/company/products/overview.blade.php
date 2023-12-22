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
                                                $imagepath = 'storage/images/'.$product->image;
                                            @endphp
                                            <img src="{{ url($imagepath) }}" alt="{{ $product->name }}" width="100%" class="img-fluid">
                                        </div>
                                        <div class="col-md-8 mt-3">
                                            <h3 class="card-title text-center fw-bold mb-4">{{ $product->name }}</h3>
                                            <p class="card-text"><label for="category" class="fw-bold">Category:</label>  {{ $product->category->name }}</p>
                                            <p class="card-text"><label for="sale-price" class="fw-bold">Sale Price:</label>  Rp{{ $product->sale_price }}</p>
                                        </div>
                                    </div>
                                    <div class="row mx-2 mt-2">
                                        <p class="card-text">
                                            <label for="description" class="fw-bold">Description:</label> 
                                            <br>
                                            <div class="ms-4 fst-italic">
                                                {{ $product->description }}
                                            </div>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end mt-5">
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#addModal{{ $product->product_id }}"
                                            class="btn btn-lg btn-primary text-white d-flex align-items-center gap-2 mx-2">
                                            <i class='bx bx-edit'></i> Edit
                                        </button>
                                        {{-- @if ($company->id > 0) --}}
                                        <form action="{{ route('products-index.destroy', $product->product_id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger text-light btn-lg d-flex align-items-center gap-2 py-2"
                                                onclick="return confirm('Delete {{ $product->name }} ?')">
                                                <i class='bx bxs-trash' ></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                    <div class="modal fade" id="addModal{{ $product->product_id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="width: 600px;">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fw-bold fs-5 text-dark">Edit {{ $product->name }}</h1>
                                                    <button type="button" class="btn btn-danger px-1 py-0 my-0" data-bs-dismiss="modal"
                                                        aria-label="Close"><i class='bx bx-x fs-3 pt-1'></i></button>
                                                </div>
                                                <div class="modal-body mx-4">
                                                    <form enctype="multipart/form-data" action="{{ route('products-index.update', $product->product_id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-5 text-dark">
                                                            <label for="name" class="ms-2 fw-bold">Product Name</label>
                                                            <input value="{{ $product->name }}" type="text" name="name" id="name" class="form-control mb-3 fs-5" required>
                                                            <label for="category" class="ms-2 fw-bold">Category</label>
                                                            <select name="category_id" id="category_id" class="form-select mb-3 fs-5" required>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->category_id }}"
                                                                        {{ $category->category_id == $product->category_id ? 'selected' : '' }}>
                                                                        {{ $category->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div id="ingredients" class="my-4 ms-3">
                                                                <div class="ingredient">
                                                                    <div class="table">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-start" style="width: 225px;">Ingredient</th>
                                                                                    <th class="text-center" style="width: 172px;">Amount</th>
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
                                                                                @php
                                                                                    $recipe = json_decode($product->recipe, true);
                                                                                @endphp
                                                                                @if ($recipe == null)
                                                                                    <tr>
                                                                                        <td>
                                                                                            <select class="mt-2 py-1" name="ingredients[0][name]">
                                                                                                @foreach($ingredients as $ingredient)
                                                                                                    <option value="{{ $ingredient->name }}">{{ $ingredient->name }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input class="mt-2" type="number" name="ingredients[0][amount]" placeholder="Amount">
                                                                                        </td>
                                                                                        <td>
                                                                                            <button type="button" class="remove-ingredient btn btn-lg btn-danger">
                                                                                                <i class="bx bx-trash fs-5"></i>
                                                                                            </button>
                                                                                        </td>
                                                                                    </tr>
                                                                                @else
                                                                                    @foreach($recipe as $index => $item)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <select class="mt-2 py-1" name="ingredients[{{ $index }}][name]">
                                                                                                    @foreach($ingredients as $ingredient)
                                                                                                        <option value="{{ $ingredient->name }}" {{ $ingredient->name == $item['name'] ? 'selected' : '' }}>
                                                                                                            {{ $ingredient->name }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </td>
                                                                                            <td >
                                                                                                <input class="mt-2" type="number" name="ingredients[{{ $index }}][amount]" placeholder="Amount" value="{{ $item['amount'] }}">
                                                                                            </td>
                                                                                            <td>
                                                                                                <button type="button" class="remove-ingredient btn btn-lg btn-danger">
                                                                                                    <i class="bx bx-trash fs-5"></i>
                                                                                                </button>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <label for="sale_price" class="ms-2 fw-bold">Sale Price</label>
                                                            <input value="{{ $product->sale_price }}" type="number" name="sale_price" id="sale_price" class="form-control mb-3 fs-5" required>
                                                            <label for="image" class="ms-2 fw-bold">Image</label>
                                                            <input type="file" name="image" id="image" accept="image/.jpg, image/.png, image/.jpeg" class="form-control mb-3 fs-5">
                                                            <label for="description" class="ms-2 fw-bold">Description</label>
                                                            <textarea name="description" id="description" class="form-control mb-3 fs-5" row="3" style="resize:none;">{{ $product->description }}</textarea>
                                                        </div>
                                                        <div class="text-center mb-4">
                                                            <button class="btn btn-primary px-4 fw-bold" type="submit">
                                                                Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-light" style="background: #11101d">
                                <div class="card-header text-center mt-3">
                                    <h3 class="card-title fw-bold">Ingredients</h3>
                                </div>
                                <div class="card-body custom-scrollbar" style="max-height: 550px; overflow-y: scroll;">
                                    <p class="card-text">
                                        @php
                                            $recipe = json_decode($product->recipe, true);
                                        @endphp
                                        @if ($recipe != null)
                                            
                                        @foreach($recipe as $ingredient)
                                            <div class="card my-1 text-light" style="background: #1b192d">
                                                @php
                                                    $ig_index = $ingredients->pluck('name')->search($ingredient['name'])
                                                @endphp
                                                <div class="card-body">
                                                    <h5 class="card-title fw-bold mb-3">{{ $ingredient['name'] }}</h5>
                                                    <p class="card-text py-0 my-1">Amount: {{ $ingredient['amount'] }} {{ $ingredients[$ig_index]->amount_unit }}</p>
                                                    <p class="card-text py-0 my-1">In Stock: {{ $ingredients[$ig_index]->stock }} {{ $ingredients[$ig_index]->amount_unit }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                        @else
                                            <p class="card-text text-center fst-italic">No ingredients yet . . .</p>
                                        @endif
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
