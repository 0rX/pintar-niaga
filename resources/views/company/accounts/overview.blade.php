@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-11">
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
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-start">
                            <h3 class="card-title fw-bold">Account Transactions</h3>
                        </div>
                        <div class="col-md-6 mb-3" >
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="flex-column mx-2">
                                    <label for="transactionSelect" class="me-2 fw-bold fs-4"> Select Transaction</label>
                                </div>
                                <div class="flex-column mx-2">
                                    <select name="transactionSelect" id="transactionSelect" class="form-select fs-5" data-bs-theme="dark">
                                        <option value=""></option>
                                        <option value="sales">Sales</option>
                                        <option value="purchases">Purchases</option>
                                        <option value="payments">Payments</option>
                                        <option value="cashins">Cashins</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table">
                            <table class="table" id="transactionTable">
                                <!-- Show selected transaction table -->
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            Please Select Transaction
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

// Get the select element
const selectElement = document.getElementById('transactionSelect');

// Get the table element
const tableElement = document.getElementById('transactionTable');

// Add an event listener to the select element
selectElement.addEventListener('change', function() {
    // Get the selected option value
    const selectedOption = selectElement.value;

    // Clear the table content
    tableElement.innerHTML = '';

    // Update the table content based on the selected option
    if (selectedOption === 'sales') {
        // Add table content for sales
        var sales = {!! $sales !!}
        // console.log(sales);
        var salesTableBody = '';
        sales.forEach(function(sale, index) {
            var dateOptions = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
            var dateCreated = new Date(sale.created_at).toLocaleDateString('en-ID', dateOptions);
            var saleAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(sale.total_amount);
            var row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>sale-${sale.sale_id}</td>
                    <td>${saleAmount}</td>
                    <td>${dateCreated}</td>
                </tr>
            `;
            salesTableBody += row;
            
        });

        tableElement.innerHTML = `<thead>
            <tr>
                <th>no</th>
                <th>Sale ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody id="salesTable">
                ${salesTableBody}
            </tbody>`;
    } else if (selectedOption === 'purchases') {
        // Add table content for sales
        var purchases = {!! $purchases !!}
        // console.log(sales);
        var purchasesTableBody = '';
        purchases.forEach(function(purchase, index) {
            var dateOptions = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
            var dateCreated = new Date(purchase.created_at).toLocaleDateString('en-ID', dateOptions);
            var purchaseAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(purchase.total_amount);
            var row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>sale-${purchase.purchase_id}</td>
                    <td>${purchaseAmount}</td>
                    <td>${dateCreated}</td>
                </tr>
            `;
            purchasesTableBody += row;
            
        });

        tableElement.innerHTML = `<thead>
            <tr>
                <th>no</th>
                <th>Sale ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody id="purchasesTable">
                ${purchasesTableBody}
            </tbody>`;
    } else if (selectedOption === 'payments') {
        // Add table content for payments
        tableElement.innerHTML = '<tr><td>Payments content goes here</td></tr>';
    } else if (selectedOption === 'cashins') {
        // Add table content for cashins
        tableElement.innerHTML = '<tr><td>Cashins content goes here</td></tr>';
    }
});

</script>

@endsection
