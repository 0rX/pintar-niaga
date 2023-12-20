@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="row">
                <div class="col-md-4" style="height: 400px;">
                    <div class="card mb-3" style="height: 375px;">
                        <div class="card-header">
                            <h4 class="fw-bold">Account Overview</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $balance = $account->balance;
                                $transaction_count = 0;
                                $transaction_count = $sales->count() + $purchases->count() + $payments->count() + $cashins->count();
                                $expenses = 0;
                                $income = 0;
                                $reconciliation = 0;
                                foreach ($purchases as $key => $purchase) {
                                    $expenses += $purchase->total_amount;
                                }
                                foreach ($payments as $key => $payment) {
                                    $expenses += $payment->total_amount;
                                }
                                foreach ($cashins as $key => $cashin) {
                                    $income += $cashin->total_amount;
                                }
                                foreach ($sales as $key => $sale) {
                                    $income += $sale->total_amount;
                                }
                                $reconciliation = $income - $expenses;
                            @endphp
                            <table>
                                <tr style="height: 45px;">
                                    <td><label for="balance" class="fw-bold">Balance </label></td>
                                    <td class="text-center fw-bold" style="width: 40px;"> : </td>
                                    <td>Rp. {{ number_format($balance) }}</td>
                                </tr>
                                <tr style="height: 45px;">
                                    <td><label for="transaction-count" class="fw-bold">Transaction</label></td>
                                    <td class="text-center fw-bold"> : </td>
                                    <td>{{ $transaction_count }}</td>
                                </tr>
                                <tr style="height: 45px;">
                                    <td><label for="expense" class="fw-bold">Expenses</label></td>
                                    <td class="text-center fw-bold"> : </td>
                                    <td>Rp. {{ number_format($expenses) }}</td>
                                </tr>
                                <tr style="height: 45px;">
                                    <td><label for="income" class="fw-bold">Income</label></td>
                                    <td class="text-center fw-bold"> : </td>
                                    <td>Rp. {{ number_format($income) }}</td>
                                </tr>
                                <tr style="height: 45px;">
                                    <td><label for="balance" class="fw-bold">Reconciliation</label></td>
                                    <td class="text-center fw-bold"> : </td>
                                    <td>Rp. {{ number_format($reconciliation) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8" style="height: 400px;">
                    <div class="card mb-3" style="height: 375px;">
                        <div class="card-body">
                            <div class="row">
                                <h3 class="fw-bold text-center">Cash Flow Charts</h3>
                            </div>
                            <div class="row">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body" style="max-height: 400px;">
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
                                        <option value="all">All</option>
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
                        <div class="card-body card-data-table custom-scrollbar-2" style="max-height: 280px">
                            <div class="table">
                                <table class="table table-striped align-middle" id="transactionTable">
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
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// Get the canvas element
var canvas = document.getElementById('lineChart');

var salesData = {!! $sales !!}

var purchasesData = {!! $purchases !!}

var paymentsData = {!! $payments !!}

var cashinsData = {!! $cashins !!}

var incomesData = salesData.concat(cashinsData);

var expensesData = purchasesData.concat(paymentsData)

var dailySums = {};

// Loop through the sales data
for (var i = 0; i < incomesData.length; i++) {
    var income = incomesData[i];
    var day = new Date(income.created_at).toLocaleDateString();
    if (dailySums[day]) {
        dailySums[day].incomes += income.total_amount;
    } else {
        dailySums[day] = { incomes: income.total_amount, expenses: 0 };
    }
}

// Loop through the purchases data
for (var i = 0; i < expensesData.length; i++) {
    var expense = expensesData[i];
    var day = new Date(expense.created_at).toLocaleDateString();
    if (dailySums[day]) {
        dailySums[day].expenses += expense.total_amount;
    } else {
        dailySums[day] = { incomes: 0, expenses: expense.total_amount };
    }
}

var labels = [];
var expensesData = [];
var incomesData = [];

for (var day in dailySums) {
    labels.push(day);
    incomesData.push(dailySums[day].incomes);
    expensesData.push(dailySums[day].expenses);
}

var last7Days = labels.slice(-7);
var last7IncomesData = incomesData.slice(-7);
var last7ExpensesData = expensesData.slice(-7);

var chart = new Chart(canvas, {
    type: 'line',
    data: {
        labels: last7Days,
        datasets: [
            {
                label: 'Income',
                data: last7IncomesData,
                borderColor: 'blue',
                backgroundColor: 'blue',
                pointBackgroundColor: 'blue',
                pointRadius: 1,
                pointHoverRadius: 4,
                borderWidth: 2
            },
            {
                label: 'Expense',
                data: last7ExpensesData,
                borderColor: 'red',
                backgroundColor: 'red',
                pointBackgroundColor: 'red',
                pointRadius: 1,
                pointHoverRadius: 4,
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

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
    if (selectedOption === 'all') {
        // Add table content for all transactions
        var transactions = null;
        var sales = {!! $sales !!}
        sales = sales.map((item, index) => {
            return { ...item, index_id: index + 1 };
        });
        var purchases = {!! $purchases !!}
        purchases = purchases.map((item, index) => {
            return { ...item, index_id: index + 1 };
        })
        var payments = {!! $payments !!}
        payments = payments.map((item, index) => {
            return { ...item, index_id: index + 1 };
        })
        var cashins = {!! $cashins !!}
        cashins = cashins.map((item, index) => {
            return { ...item, index_id: index + 1 };
        })
        transactions = sales.concat(purchases, payments, cashins);
        var transactionsTableBody = '';
        transactions.forEach(function(transaction, index) {
            var dateOptions = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false };
            var dateCreated = new Date(transaction.created_at);
            dateCreated = dateCreated.toLocaleTimeString('en-UK', dateOptions);

            
            var transactionAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(transaction.total_amount);
            var transaction_id = '';
            if (transaction.sale_id != null) {
                transaction_id = 'sale-' + transaction.index_id;
            } else if (transaction.purchase_id) {
                transaction_id = 'purchase-' + transaction.index_id;
            } else if (transaction.cash_in_id) {
                transaction_id = 'cashin-' + transaction.index_id;
            } else if (transaction.payment_id) {
                transaction_id = 'payment-' + transaction.index_id;
            }
            var row = `
                <tr>
                    <td>${transaction_id}</td>
                    <td>${transactionAmount}</td>
                    <td>${dateCreated}</td>
                </tr>
            `;
            transactionsTableBody += row;
        });
        tableElement.innerHTML = `<thead>
            <tr>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="transactionsTable">
            ${transactionsTableBody}
        </tbody>`;
        // console.log(transactions);
    }
    if (selectedOption === 'sales') {
        // Add table content for sales
        var sales = {!! $sales !!}
        sales = sales.map((item, index) => {
            return { ...item, index_id: index + 1 };
        })
        // console.log(sales);
        var salesTableBody = '';
        sales.forEach(function(sale, index) {
            var dateOptions = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false };
            var dateCreated = new Date(sale.created_at);
            dateCreated = dateCreated.toLocaleTimeString('en-UK', dateOptions);
            var saleAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(sale.total_amount);
            var row = `
                <tr>
                    <td>sale-${sale.index_id}</td>
                    <td>${saleAmount}</td>
                    <td>${dateCreated}</td>
                </tr>
            `;
            salesTableBody += row;
            
        });

        tableElement.innerHTML = `<thead>
            <tr>
                <th>Sale ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody id="salesTable">
                ${salesTableBody}
            </tbody>`;
    } else if (selectedOption === 'purchases') {
        // Add table content for purchases
        var purchases = {!! $purchases !!}
        purchases = purchases.map((item, index) => {
            return { ...item, index_id: index + 1 };
        })
        // console.log(purchases);
        var purchasesTableBody = '';
        purchases.forEach(function(purchase, index) {
            var dateOptions = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false };
            var dateCreated = new Date(purchase.created_at);
            dateCreated = dateCreated.toLocaleTimeString('en-UK', dateOptions);
            var purchaseAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(purchase.total_amount);
            var row = `
                <tr>
                    <td>purchase-${purchase.index_id}</td>
                    <td>${purchaseAmount}</td>
                    <td>${dateCreated}</td>
                </tr>
            `;
            purchasesTableBody += row;
            
        });

        tableElement.innerHTML = `<thead>
            <tr>
                <th>Purchase ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody id="purchasesTable">
                ${purchasesTableBody}
            </tbody>`;
    } else if (selectedOption === 'payments') {
        // Add table content for payments
        var payments = {!! $payments !!}
        payments = payments.map((item, index) => {
            return { ...item, index_id: index + 1 };
        })
        // console.log(payments);
        var paymentsTableBody = '';
        payments.forEach(function(payment, index) {
            var dateOptions = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false };
            var dateCreated = new Date(payment.created_at);
            dateCreated = dateCreated.toLocaleTimeString('en-UK', dateOptions);
            var paymentAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(payment.total_amount);
            var row = `
                <tr>
                    <td>payment-${payment.index_id}</td>
                    <td>${payment.title}</td>
                    <td>${paymentAmount}</td>
                    <td>${payment.description}</td>
                    <td>${dateCreated}</td>
                </tr>
            `;
            paymentsTableBody += row;
            
        });

        tableElement.innerHTML = `<thead>
            <tr>
                <th>Payment ID</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody id="paymentsTable">
                ${paymentsTableBody}
            </tbody>`;
    } else if (selectedOption === 'cashins') {
        // Add table content for cashins
        var cashins = {!! $cashins !!}
        cashins = cashins.map((item, index) => {
            return { ...item, index_id: index + 1 };
        })
        // console.log(payments);
        var cashinsTableBody = '';
        cashins.forEach(function(cashin, index) {
            var dateOptions = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false };
            var dateCreated = new Date(cashin.created_at);
            dateCreated = dateCreated.toLocaleTimeString('en-UK', dateOptions);
            var cashinAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(cashin.total_amount);
            var row = `
                <tr>
                    <td>cashin-${cashin.index_id}</td>
                    <td>${cashin.title}</td>
                    <td>${cashinAmount}</td>
                    <td>${cashin.description}</td>
                    <td>${dateCreated}</td>
                </tr>
            `;
            cashinsTableBody += row;
            
        });

        tableElement.innerHTML = `<thead>
            <tr>
                <th>Cashin ID</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody id="cashinsTable">
                ${cashinsTableBody}
            </tbody>`;
    }
    // JavaScript code here
    // ...
    // Get the table element
    var table = tableElement;
    
    // Get all the table header cells
    var headerCells = table.getElementsByTagName("th");
    
    // Convert the header cells to an array
    var headerCellsArray = Array.from(headerCells);
    
    // Add click event listeners to each header cell
    headerCellsArray.forEach(function(cell, columnIndex) {
        if (cell.innerHTML.trim() === "Date") {
            cell.addEventListener("click", function() {
                // console.log('clicked')
                sortTable(columnIndex);
            });
        } else if (cell.innerHTML.trim() === "Amount") {
            cell.addEventListener("click", function() {
                // console.log('clicked')
                sortCurrencyTable(columnIndex);
            });
        } else if (cell.innerHTML.trim() === "Transaction ID" || cell.innerHTML.trim() === "Sale ID" || cell.innerHTML.trim() === "Purchase ID" || cell.innerHTML.trim() === "Payment ID" || cell.innerHTML.trim() === "Cashin ID") {
            cell.addEventListener("click", function() {
                // console.log('clicked')
                sortIdTable(columnIndex);
            });
        }
    });
    
    // Function to sort the table based on the selected column index
    function sortTable(columnIndex) {
        var rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        var tableBody = table.getElementsByTagName("tbody")[0];
        switching = true;
        dir = "asc"; // Default sorting direction is ascending
        
        // Start the loop that will continue until no switching has been done
        while (switching) {
            switching = false;
            rows = tableBody.getElementsByTagName("tr");
        
            // Loop through all table rows (except the first row, which contains the table headers)
            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;
        
                // Get the two elements to be compared
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];
        
                // Check if the two elements should switch places based on the sorting direction
                if (dir === "asc") {
                    if (compareTableData(x.innerHTML, y.innerHTML) > 0) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir === "desc") {
                    if (compareTableData(x.innerHTML, y.innerHTML) < 0) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        
            if (shouldSwitch) {
                // If a switch has been marked, make the switch and mark the loop as completed
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                // If no switching has been done and the sorting direction is ascending, switch to descending
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
    
    function compareTableData(a, b) {
        // Parse the date and time values
        var dateA = parseDateValue(a);
        var dateB = parseDateValue(b);
    
        if (dateA && dateB) {
            // Compare the parsed date values
            if (dateA < dateB) {
                return -1;
            } else if (dateA > dateB) {
                return 1;
            } else {
                return 0;
            }
        } else {
            // Compare as strings if parsing fails
            return a.localeCompare(b);
        }
    }
    
    function parseDateValue(value) {
        // Parse the value using the specified format
        // var parsedDate = Date.parse(value);
        const dateString = value;
        const parsedDate = moment(dateString, "DD MMMM YYYY [at] HH:mm:ss").toDate();

        // console.log(parsedDate);
        
        // Check if the parsing was successful
        if (!isNaN(parsedDate)) {
            return new Date(parsedDate);
        } else {
            return null;
        }
    }

    function sortCurrencyTable(columnIndex) {
        var rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        var tableBody = table.getElementsByTagName("tbody")[0];
        switching = true;
        dir = "asc"; // Default sorting direction is ascending
        
        // Start the loop that will continue until no switching has been done
        while (switching) {
            switching = false;
            rows = tableBody.getElementsByTagName("tr");
        
            // Loop through all table rows (except the first row, which contains the table headers)
            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;
        
                // Get the two elements to be compared
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];
        
                // Check if the two elements should switch places based on the sorting direction
                if (dir === "asc") {
                    if (compareCurrencyData(x.innerHTML, y.innerHTML) > 0) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir === "desc") {
                    if (compareCurrencyData(x.innerHTML, y.innerHTML) < 0) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        
            if (shouldSwitch) {
                // If a switch has been marked, make the switch and mark the loop as completed
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                // If no switching has been done and the sorting direction is ascending, switch to descending
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
    
    function compareCurrencyData(a, b) {
        // Extract the numeric values from the currency values
        var numericValueA = extractNumericValue(a);
        var numericValueB = extractNumericValue(b);
    
        return numericValueA - numericValueB;
    }
    
    function extractNumericValue(value) {
        // Remove the currency symbol and any non-numeric characters
        var numericValue = value.replace(/[^0-9]/g, '');
    
        // Parse the numeric value into an integer
        return parseInt(numericValue);
    }

    function sortIdTable(columnIndex) {
        var rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        var tableBody = table.getElementsByTagName("tbody")[0];
        switching = true;
        dir = "asc"; // Default sorting direction is ascending
        
        // Start the loop that will continue until no switching has been done
        while (switching) {
            switching = false;
            rows = tableBody.getElementsByTagName("tr");
        
            // Loop through all table rows (except the first row, which contains the table headers)
            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;
        
                // Get the two elements to be compared
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];
        
                // Check if the two elements should switch places based on the sorting direction
                if (dir === "asc") {
                    if (compareAlphanumericData(x.innerHTML, y.innerHTML) > 0) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir === "desc") {
                    if (compareAlphanumericData(x.innerHTML, y.innerHTML) < 0) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        
            if (shouldSwitch) {
                // If a switch has been marked, make the switch and mark the loop as completed
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                // If no switching has been done and the sorting direction is ascending, switch to descending
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }

    function compareAlphanumericData(a, b) {
        // Compare the alphanumeric values using localeCompare
        return a.localeCompare(b, undefined, { numeric: true, sensitivity: 'base' });
    }

});


</script>

@endsection
