@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 0.5em;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background-color: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: transparent;
    }
</style>

@php
    $collection = [];
@endphp


<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="row ms-1" style="max-height: 750px;">
            <div class="col-md-8">
                <div class="card" style="height: 500px;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <h3 class="card-title fw-bold text-start align-self-center">
                                    Sale
                                </h3>
                            </div>
                            <div class="col-md-7 justify-content-end">
                                <div class="row">
                                    <div class="col-md-5 text-end align-self-center">
                                        <label class="fw-bold" for="select">Select Account:</label>
                                    </div>
                                    <div class="col-md-7 justify-content-start" data-bs-theme="dark">
                                        <select name="account" id="account" class="form-select me-2 fs-5" required>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->account_id }}">{{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body card-data-table" style="max-height: 362px">
                        <div class="table">
                            <table class="table table-stripped">
                                <thead>
                                    <tr>
                                        <th class="text-start" style="width: 130px;" scope="col">Item</th>
                                        <th class="text-center" style="width: 140px;" scope="col">Quantity</th>
                                        <th class="text-center" style="width: 70px;" scope="col">Price</th>
                                        <th class="text-center" style="width: 70px;" scope="col">Total</th>
                                        <th class="text-center" style="width: 80px;" scope="col"><i class='bx bxs-trash' ></i></th>
                                    </tr>
                                </thead>
                                <tbody id="items-cart">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="d-flex ms-3">
                                <button id="clear-cart" type="button" class="btn btn-md btn-danger fs-5 text-light d-flex align-items-center gap-1 mx-2 fw-bold">
                                    <i class='bx bx-x-circle fs-4'></i> Clear
                                </button>
                                <form action="{{ route('sale-index.store') }}" method="post" id="cart-form">
                                    @csrf
                                    <button class="btn btn-md btn-success fs-5 text-light 
                                    d-flex align-items-center gap-1 mx-2 fw-bold submit-purchase"
                                    type="button">
                                        <i class='bx bx-check fs-4'></i> Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-7 fs-4 fw-bold">
                            <div class="d-flex">
                                <label for="grand-total-table">
                                    Grand Total: 
                                </label>
                                <p class="grand-total-table mx-1" data-total-amount="0">
                                    Rp 0
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card px-3 py-2"  style="height: 500px;">
                    <div id="receipt-print" class="card-body px-0 mx-0 custom-scrollbar align-self-center" style="overflow-y:auto; width: 312px;">
                        <div class="row" style="max-height: 140px;">
                            <div class="col-md-4 justify-content-center align-items-center text-center">
                                <img style="height: 90px;" src="/storage/assets/logo/logo-blank-bg-1.svg" alt="">
                            </div>
                            <div class="col-md-8 text-start">
                                <h5 class="my-1 fw-bold">
                                    {{ $company->name }}
                                </h5>
                                <p class="my-0" style="font-size: 12px;">
                                    {{ $company->address }}
                                </p>
                                <p class="my-0" style="font-size: 12px;">
                                    Phone: {{ $company->phone }}
                                </p>
                                <p class="my-0" style="font-size: 12px;">
                                    {{ $company->email }}
                                </p>
                                <br>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="table">
                                <table class="table table-stripped" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th class="text-start" style="width: 130px;" scope="col">Item</th>
                                            <th class="text-center" style="width: 140px;" scope="col">Quantity</th>
                                            <th class="text-center" style="width: 70px;" scope="col">Price</th>
                                            <th class="text-center" style="width: 70px;" scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-receipt">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Grand Total</td>
                                            <td class="grand-total-receipt text-end fw-bold" data-total-receipt="0">
                                                Rp 0
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div data-bs-theme="dark" class="row ms-1 mt-4 justify-content-center">
            <div class="col-md-12">
                <div class="card border-0" style="border-radius: 0%;">
                    <div class="card-header border-0" style="background-color:rgb(43, 48, 62);">
                        <div data-bs-theme="light" class="d-flex align-items-center">
                            <div class="d-flex me-auto">
                                <h3 class="card-title fw-bold">Product List</h3>
                            </div>
                            <div class="d-flex ms-auto">
                                <label for="search" class="mt-2">
                                    <i class='bx bx-search fs-1'></i> 
                                </label>
                                <input name="search" id="search" class="form-control my-1 mx-3 border border-dark fs-5" style="width: 200px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="max-height: 800px; overflow: auto; background-color:rgb(36, 40, 48)">
                        <div id="items-container" class="row">
                            <style>
                            .invisible-layer {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 48%;
                                background-color: rgba(0, 0, 2, 0); /* Adjust the opacity and color as needed */
                                display: block;
                            }
                            
                            .add-item {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background-color: rgba(0, 0, 0, 0); /* Adjust the opacity and color as needed */
                                display: none;
                            }
                            
                            .item-button {
                                position: absolute;
                                opacity: 0%;
                                text-decoration: none;
                            }
                            
                            .item-button i {
                                color: red;
                            }
                            
                            .invisible-layer:hover .add-item {
                                background-color: rgba(24, 93, 38, 0.7); /* Adjust the opacity and color as needed */
                                display: block;
                                height: 100%;
                                opacity: 100%;
                            }
                            
                            .invisible-layer:hover .item-button { /* Adjust the opacity and color as needed */
                                display: block;
                                opacity: 100%;
                            }
                            
                            </style>
                            @foreach ($products as $product)
                                <div class="col-md-3 my-2">
                                    <div data-bs-theme="light" class="card border border-0">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                @php
                                                    $imagepath = 'storage/images/'.$product->image;
                                                @endphp
                                                <img class="img-fluid" style="height: 192px; width: auto;" src="{{ asset($imagepath) }}" alt="">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex flex-column justify-content-center mt-2" style="height: 30px;">
                                                        <h4 class="card-title card-hovering text-center fw-bold">{{ $product->name }}</h4>
                                                    </div>
                                                    <hr>
                                                    <div class="custom-scrollbar" style="max-height: 140px; overflow-y: scroll;">
                                                        <p class="card-text py-0 my-1"><label for="sale-price" class="fw-bold">Price:</label> Rp {{ number_format($product->sale_price) }}</p>
                                                        @php
                                                            $recipes = json_decode($product->recipe, true);
                                                        @endphp
                                                        <p class="card-text py-0 my-1"><label for="uses" class="fw-bold">Uses:</label>
                                                            <br>
                                                            @if ($recipes != null)
                                                                @foreach ($recipes as $recipe)
                                                                    @php
                                                                        $ingredient = $company->ingredients->firstWhere('name', $recipe['name']);
                                                                        // dd($ingredient);
                                                                    @endphp
                                                                    {{ $ingredient->name }} <strong class="text-primary">[{{ $recipe['amount'] }} {{ $ingredient->amount_unit }}]</strong>
                                                                    @if (!$loop->last)
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <p>Ingredient Component Empty</p>
                                                            @endif
                                                        </p>
                                                        <p class="card-text py-0 my-1">
                                                            <label for="description" class="fw-bold">Description:</label> 
                                                            <br>
                                                            <div class="ms-4 fst-italic">
                                                                {{ $product->description }}
                                                            </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invisible-layer">
                                            <div class="add-item d-flex justify-content-center align-items-center">
                                                <a href="#items-container" data-item="{{ $product }}" data-item-id="{{ $product->product_id }}" data-item-name="{{ $product->name }}" class="item-button">
                                                    <i class='bx bx-cart-add' style="font-size: 500%;"></i>
                                                </a>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            @endforeach
                            {{-- <p class="fst-italic fs-1 text-center text-danger">Search your items <i class='bx bx-search fs-1'></i></p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>

var inventory = {!! json_encode($ingredients) !!}
var startInventory = {!! json_encode($ingredients) !!}
var products = {!! json_encode($products) !!}
// console.log(inventory);
// console.log(products);

function printComponent() {
    // Print Receipt
    var printContents = document.getElementById("receipt-print").innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    
    alert("Receipt printed!");
    console.log("Receipt printed!");

    document.body.innerHTML = originalContents;
}

document.querySelector('.submit-purchase').addEventListener('click', function() {
  var cartData = getCartData(); // Replace this with your code to retrieve the cart data
  if (cartData[1] === "quantity-zero") {
    alert('Some items has zero quantity. Please fill those first!')
    return
  }
  if (parseInt(cartData[1].length) === 0) {
      // Cart is empty, display an error message or prevent submission
    alert('The cart is empty. Please add items before submitting.');
    return;
  }
  // Get all quantity input fields
  var quantityInputs = document.querySelectorAll('.quantity-input');
  // Check if any quantity input field has an error
  var hasError = Array.from(quantityInputs).some(function(input) {
    return input.classList.contains('error');
  });

  if (hasError) {
    console.log('Form error');
    event.preventDefault();
    event.stopPropagation();
    alert('Some item Quantity exceeds stock');
    return;
    // Handle the form error
    // ...
  }

  submitCartData(cartData); // Replace this with your code to submit the cart data to the server
});

function getCartData() {
  // Retrieve the cart data from the items-cart table
  var cartData = [];
  var currentUrl = window.location.pathname;
  var cp_index = currentUrl.split("/")[2];
  var account_id = $('#account').val();

  cartData[0] = {
                cp_index:cp_index,
                account_id:account_id};

  cartData[1] = [];
  $('#items-cart tr').each(function() {
    var itemName = $(this).find('.item-name').text();
    var quantity = $(this).find('.quantity').val();
    var price = $(this).find('.purchase-base').data('base-price');
    var total = quantity * price;

    if ((parseInt(quantity) === 0) || (quantity === "") ) {
        // Quantity is zero, returns "quantity-zero" cartData
        cartData[1] = "quantity-zero";
        return
    }

    cartData[1].push({
      itemName: itemName,
      quantity: quantity,
      price: price,
      total: total
    });
  });

  return cartData;
}

function submitCartData(cartData) {
  // Send the cart data to the server using AJAX or form submission
  // Replace this with your code to handle the server-side submission
  var cartInput = document.createElement('input');
  cartInput.type = 'hidden';
  cartInput.name = 'cartData';
  cartInput.value = JSON.stringify(cartData);

  var form = document.getElementById('cart-form');
  form.appendChild(cartInput);

  form.submit();
  printComponent();
}

$(document).ready(function() {

    $(document).on('click', '.item-button', function() {
        var item = $(this).data('item');
        var itemPrice = item['sale_price'];
        // Check if the item already exists in the table
        var exists = false;
        $('#items-cart tr').each(function() {
            var itemName = $(this).find('.text-start').text().trim();
            if (itemName === item['name']) {
                exists = true;
                return false; // Exit the loop if a duplicate is found
            }
        });

        if (!exists) {
            var newRow = '<tr data-prod-id="'+item['product_id']+'">' +
                '<td id="prod-'+item['product_id']+'" class="text-start item-name">' + item['name'] + '</td>' +
                '<td class="d-flex justify-content-center"><input type="number" value="0" name="quantity" id="quantity'+item['product_id']+'" class="quantity quantity-input form-control my-1 border-1 border-dark" style="width: 120px;" min="0" required></td>' +
                '<td id="purchase-base'+item['product_id']+'" class="text-center purchase-base" data-base-price="'+ item['sale_price'] +'">' + parseInt(item['sale_price']).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', currencyDisplay: 'symbol', minimumFractionDigits: 0, maximumFractionDigits: 0 }) + '</td>' +
                '<td id="purchase-total'+item['product_id']+'" class="text-center purchase-total" data-total-price="0">' + 0 + '</td>' +
                '<td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-button">Remove</button></td>' +
                '</tr>';
            $('#items-cart').append(newRow)
        } else {
            console.log('Item already exists in cart.')
        }
    });
    // Calculate purchase total based on quantity and purchase price
    // var previousQuantity = 0;
    $(document).on('input', '.quantity', function() {
        var quantity = $(this).val();
        var productId = $(this).closest('tr').data('prod-id');
        // console.log(productId);
        var product = products.find(function(item) {
            return item.product_id === productId;
        });

        // console.log(product.previousQuantity);
        
        if (product.previousQuantity == null) {
            product.previousQuantity = 0;
        }


        if (product.previousQuantity !== null) {
            var quantityChange = quantity - product.previousQuantity;
            // console.log('Variable quantityChange -> ', quantityChange)
            if (quantityChange > 0) {
                console.log('Quantity', product.name, 'increased by:', quantityChange);
            } else if (quantityChange < 0) {
                console.log('Quantity', product.name, 'decreased by:', Math.abs(quantityChange));
            } else {
                console.log('Quantity remains unchanged');
            }
        }
        product.previousQuantity = quantity;

        // console.log('product found:', product);
        updateInventory(product, quantityChange);
        // console.log('Updated inventory: ', inventory);

        var purchasePrice = $(this).closest('tr').find('.purchase-base').eq(0).data('base-price');
        var purchaseTotal = quantity * purchasePrice;
        $(this).closest('tr').find('.purchase-total').data('total-price', purchaseTotal);
        $(this).closest('tr').find('.purchase-total').text(purchaseTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', currencyDisplay: 'symbol', minimumFractionDigits: 0, maximumFractionDigits: 0 }));
        var grandTotal = 0;
        $('#items-cart tr').each(function() {
            var itemTotal = $(this).find('.purchase-total').data('total-price');
            grandTotal += itemTotal
        });
        $('.grand-total-table').data('total-amount', grandTotal);
        $('.grand-total-table').text(grandTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', currencyDisplay: 'symbol', minimumFractionDigits: 0, maximumFractionDigits: 0 }));
        $('.grand-total-receipt').data('total-receipt', grandTotal);
        $('.grand-total-receipt').text(grandTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', currencyDisplay: 'symbol', minimumFractionDigits: 0, maximumFractionDigits: 0 }));
        // console.log('Table total: '+grandTotal);
    });
    
});

function updateInventory(product, quantityChange) {
    console.log(product.recipe);
    var recipe = JSON.parse(product.recipe);
    var recipeCount = Object.keys(recipe).length;
    var errorPass = 0;

    // Iterate over each ingredient in the recipe
    recipe.forEach(function(ingredient) {
        var ingredientName = ingredient.name;
        var ingredientAmount = ingredient.amount;

        function getItemFromInventory(ingredientName) {
            for (var i = 0; i < inventory.length; i++) {
                if (inventory[i].name === ingredientName) {
                return inventory[i];
                }
            }
            
            // Return null if the item is not found
            return null;
        }

        var item = getItemFromInventory(ingredientName);

        
        // Update the stock of the ingredient based on the quantity change
        if (quantityChange >= 0) {
            item['stock'] -= ingredientAmount * quantityChange;
            console.log('stock ',item.name,': ',item.stock)
            if (item['stock'] < 0) {
                console.log('Error occurs for ->', item.name);
            } else {
                errorPass++;
                console.log('No error occurs');
            }
        } else {
            item['stock'] += ingredientAmount * Math.abs(quantityChange);
            console.log('stock ',item.name,': ',item.stock)
            if (item['stock'] < 0) {
                console.log('Error occurs for ->', item.name);
            } else {
                errorPass++;
                console.log('No error occurs')
            }
        }
    });
    if (errorPass !== recipeCount) {
        var elementID = 'quantity'+product['product_id'];
        var quantityInput = document.getElementById(elementID);
        quantityInput.classList.add('error')
        quantityInput.setCustomValidity('Item stock is insufficient');
        quantityInput.reportValidity();
    } else {
        var elementID = 'quantity'+product['product_id'];
        var quantityInput = document.getElementById(elementID);
        quantityInput.classList.remove('error');
        quantityInput.setCustomValidity('');
        quantityInput.reportValidity();
    }
}

$(document).on('click', '.remove-button', function() {
    var index = $(this).closest('tr').index(); // Get the index of the clicked row
    var purchaseTotal = $('.purchase-total').eq(index).data('totalPrice'); // Get the purchase-total value of the corresponding row
    var clickedRow = $(this).closest('tr');
    var quantityInput = clickedRow.find('.quantity');
    var quantity = quantityInput.val();
    quantity = -parseInt(quantity);
    // console.log('Last input quantity of removed row: ', quantity);
    
    var productId = clickedRow.data('prod-id')
    var product = products.find(function(item) {
        return item.product_id === productId;
    });

    console.log('product name: ', product.name);
    console.log('stok kopi blend before: ', inventory[0]['stock']);
    // console.log('previous quantity: ', product.previousQuantity);
    updateInventory(product, quantity);
    // console.log('stok kopi blend after: ', inventory[0]['stock']);

    product.previousQuantity = null;

    var grandTotal = $('.grand-total-table').data('total-amount');
    grandTotal -= purchaseTotal;
    $('.grand-total-table').data('totalAmount', grandTotal);
    $('.grand-total-table').text(grandTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', currencyDisplay: 'symbol', minimumFractionDigits: 0, maximumFractionDigits: 0 }));
    $('.grand-total-receipt').data('total-receipt', grandTotal);
    $('.grand-total-receipt').text(grandTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', currencyDisplay: 'symbol', minimumFractionDigits: 0, maximumFractionDigits: 0 }));
    $(this).closest('tr').remove();
});

function resetProductQuantities() {
  products.forEach(function(product) {
    product.previousQuantity = 0;
  });
}

function resetInventoryStocks() {
    for (var i = 0; i < inventory.length; i++) {
        var startItem = startInventory[i];
        if (startItem) {
            inventory[i].stock = startItem.stock;
        }
    }
}

$(document).on('click', '#clear-cart', function() {
    $('.grand-total-table').data('totalAmount', 0);
    $('.grand-total-table').text('Rp 0');
    $('.grand-total-receipt').data('total-receipt', 0);
    $('.grand-total-receipt').text('Rp 0');
    $('#items-cart').empty();
    resetProductQuantities();
    resetInventoryStocks();
    // console.log(products[0]['previousQuantity']);
});

$('#items-cart').on('DOMSubtreeModified', function() {
    // Update the #items-receipt table
    $('#items-receipt').empty();

    $('#items-cart tr').each(function() {
        var itemName = $(this).find('.item-name').text();
        var quantity = $(this).find('.quantity').val();
        var price = $(this).find('.purchase-base').data('base-price');
        var total = quantity * price;

        var newRow = '<tr>' +
            '<td class="text-start item-name">' + itemName + '</td>' +
            '<td class="text-center">' + quantity + '</td>' +
            '<td class="text-center">' + price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', currencyDisplay: 'symbol', minimumFractionDigits: 0, maximumFractionDigits: 0 }) + '</td>' +
            '<td class="text-end">' + total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', currencyDisplay: 'symbol', minimumFractionDigits: 0, maximumFractionDigits: 0 }) + '</td>' +
            '</tr>';

        $('#items-receipt').append(newRow);
    });

    // Update the grand-total-receipt value
    var grandTotal = $('.grand-total-table').data('total-amount');
    var formattedGrandTotal = grandTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', currencyDisplay: 'symbol', minimumFractionDigits: 0, maximumFractionDigits: 0 });
});

$(document).ready(function() {
    $('#search').on('input', function() {
        var searchQuery = $(this).val();
        var currentRoute = window.location.pathname;
        var routeArray = currentRoute.split('/');
        var company_index = routeArray[2];

        // Send AJAX request to the server with the search query
        $.ajax({
        url: '/search-product', // Replace with the actual URL for handling the search request
        method: 'GET',
        data: { query: searchQuery,
                cp_index: company_index 
        },
        success: function(response) {
            // Update the items-container element with the filtered data
            $('#items-container').empty();
            $('#items-container').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle any errors that occur during the AJAX request
            console.error('Error:', errorThrown);
        }
        });
    });
});

</script>

@endsection
