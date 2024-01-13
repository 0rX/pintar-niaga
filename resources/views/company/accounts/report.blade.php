@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bold">Account Report</h4>
            </div>
            <div class="card-body">
                <div class="row" data-bs-theme="dark">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="startDate" name="startDate">
                                    <label for="startDate">Start Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="endDate" name="endDate">
                                    <label for="endDate">End Date</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="fw-bold">
                                    <i class="bx bx-left-arrow-alt align-middle"></i> Set Date Range
                                </h4>
                            </div>
                            <div class="col-md-6 text-center">
                                <button type="button" id="printReport" class="btn btn-lg btn-primary text-light fw-bold fs-5">
                                    <i class="bx bxs-printer align-middle"></i> Print
                                </button>
                                <button type="button" id="savePDF" class="btn btn-lg btn-primary text-light fw-bold fs-5">
                                    <i class="bx bxs-download align-middle"></i> PDF
                                </button>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="startAmount" name="startAmount">
                                    <label for="startAmount">Start Amount</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="endAmount" name="endAmount">
                                    <label for="endAmount">End Amount</label>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="card-body" data-bs-theme="dark">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="search" name="search">
                            <label for="search">Search</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="orderBy" name="orderBy">
                                <option value="all">All</option>
                                <option value="sale">Sales</option>
                                <option value="purchase">Purchases</option>
                                <option value="cashin">Cashin</option>
                                <option value="payment">Payment</option>
                            </select>
                            <label for="orderBy">Order By</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table -->
            <div id="tableDiv" class="table" data-bs-theme="light">
                <table class="table table-striped align-middle" id="transactionTable">
                    <!-- Show selected transaction table -->
                </table>
            </div>
        </div>
    </div>
</div>


{{-- <script src="{{ url("storage/scripts/autotable.min.js") }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>

let printButton = document.getElementById('printReport');
let savePDF = document.getElementById('savePDF');
let tableWhole = document.getElementById('tableDiv');

savePDF.addEventListener('click', function() {
    let tableContent = document.getElementById('tableContent');
    // Check if table content is empty
    if (tableContent === null || tableContent.innerHTML.trim() === '') {
        alert('No content to save')
        return;
    }
    // Generate the PDF
    const options = {
        filename: 'table.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };

    // Save the tableWhole HTML as PDF
    html2pdf().set(options).from(tableWhole).save();
    // location.reload();
    
});

printButton.addEventListener('click', function() {
    let tableContent = document.getElementById('tableContent');
    // Check if table content is empty
    if (tableContent === null) {
        alert('No content to print')
        return;
    } else if (tableContent.innerHTML.trim() === '') {
        alert('No content to print')
        return;
    }
    printTable(tableWhole);
});

function printTable(table) {
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = table.innerHTML;
    window.print();
    
    alert("Report printed!");
    console.log("Report printed!");

    document.body.innerHTML = originalContents;
    location.reload();
}


function setEndDateMin() {
  const startDateInput = document.getElementById('startDate');
  const endDateInput = document.getElementById('endDate');
  endDateInput.min = startDateInput.value;
}

function setStartDateMax() {
    const endDateInput = document.getElementById('endDate');
    const startDateInput = document.getElementById('startDate');
    startDateInput.max = endDateInput.value;
}

// Get the transactionTable element
const transactionTable = document.getElementById('tableDiv');
// Get the startDate and endDate input fields
const startDateInput = document.getElementById('startDate');
const endDateInput = document.getElementById('endDate');

// Function to format the date in "day, month year" format
function formatDate(date) {
  const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false };
  var date = new Date(date);
  return date.toLocaleTimeString('en-UK', options);
}

function formatDate2(date) {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  var date = new Date(date);
  return date.toLocaleDateString('en-UK', options);
}


function formatCurrency(number) {
    var output = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
    return output;
}

// Function to generate the table rows for transactions
function generateTransactionRows(transactions) {
  // Sort the transactions by date in ascending order
  transactions.sort((a, b) => {
    const dateA = new Date(a.created_at);
    const dateB = new Date(b.created_at);
    return dateA - dateB;
  });

  let rows = '';
  transactions.forEach((transaction) => {
    const transactionDate = formatDate(transaction.created_at);
    const description = transaction.description !== undefined ? transaction.description : 'No Description';

    // Convert the amount to negative for "purchase" or "payment" transactions
    let amount = parseInt(transaction.total_amount);
    if (transaction.type === 'purchase' || transaction.type === 'payment') {
        amount = -amount;
    }
    var saleAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                currencyDisplay: 'symbol',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
    const amountClass = amount < 0 ? 'text-danger' : 'text-dark';
    rows += `
      <tr>
        <td>${transactionDate}</td>
        <td class="text-center">${transaction.type}</td>
        <td class="${amountClass} text-end">${saleAmount}</td>
        <td>${description}</td>
      </tr>
    `;
  });
  return rows;
}

let totalAmount = 0;
let totalExpense = 0;
let totalIncome = 0;
// Function to update the transaction table
function updateTransactionTable(transactions) {
  // Generate the table rows
  const tableRows = generateTransactionRows(transactions);

  const totalAmountClass = totalAmount < 0 ? 'text-danger' : 'text-dark';
  const dateNow = new Date();

  // Update the transactionTable with the generated rows
  transactionTable.innerHTML = `
    <div>
        <table class="table table-striped align-middle" id="transactionTable">
            <tr>
                <th>Start:  ${formatDate2(document.getElementById('startDate').value)}</th>
                <th class="text-end">Type:</th>
                <th>${document.getElementById('orderBy').value}</th>
            </tr>
            <tr>
                <th>End:  ${formatDate2(document.getElementById('endDate').value)}</th>
                <th class="text-end">Keyword:</th>
                <th>${document.getElementById('search').value}</th>
            </tr>
            <tr>
                <th colspan="3">Printed At: ${formatDate(dateNow)}</th>
            </tr>
        </table>
    </div>
    <div>
        <table class="table table-striped align-middle" id="transactionTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody id="tableContent" class="table-light">
            ${tableRows}
            <tr class="text-start fw-bold">
                <td colspan="4">Transaction Count: ${transactions.length}</td>
            </tr>
            <tr class="text-end fw-bold">
                <td colspan="2">Total Income:</td>
                <td>${formatCurrency(totalIncome)}</td>
                <td></td>
            </tr>
            <tr class="text-end fw-bold">
                <td colspan="2">Total Expense:</td>
                <td class="text-danger">${formatCurrency(totalExpense)}</td>
                <td></td>
            </tr>
            <tr class="text-end fw-bold">
                <td colspan="2">Final Amount:</td>
                <td class="${totalAmountClass}">${formatCurrency(totalAmount)}</td>
                <td></td>
            </tr>
            </tbody>
            
        </table>
    </div>
  `;
}

// Example transactions data
let transactions = {!! json_encode($transactions) !!}

// Function to handle changes in the search input field
function handleSearchChange() {
  // Get the search query, order by value, start date, and end date
  setEndDateMin();
  setStartDateMax();
  totalAmount = 0;
  totalExpense = 0;
  totalIncome = 0;
  const searchInput = document.getElementById('search');
  const orderBySelect = document.getElementById('orderBy');
  const startDateInput = document.getElementById('startDate');
  const endDateInput = document.getElementById('endDate');
  
  // Get the search query, order by value, start date, and end date
  const searchQuery = searchInput.value.toLowerCase();
  const orderByValue = orderBySelect.value;
  const startDate = startDateInput.value;
  const endDate = endDateInput.value;

  // Filter the transactions based on the search query, order by value, and date range
  let filteredTransactions = transactions.filter((transaction) => {
    const description = transaction.description !== undefined ? transaction.description.toLowerCase() : '';
    const type = transaction.type.toLowerCase();
    const transactionDate = new Date(transaction.created_at).setHours(0, 0, 0, 0);
    const startDateTime = new Date(startDate).setHours(0, 0, 0, 0);
    const endDateTime = new Date(endDate).setHours(0, 0, 0, 0);

    return (
      (description.includes(searchQuery) || type.includes(searchQuery)) &&
      (orderByValue === 'all' || type === orderByValue) &&
      (transactionDate >= startDateTime && transactionDate <= endDateTime)
    );
  });

  filteredTransactions.forEach(element => {
    if (element.type === 'purchase' || element.type === 'payment') {
        totalAmount -= parseInt(element.total_amount);
        totalExpense -= parseInt(element.total_amount);
    }
    else{
        totalAmount += parseInt(element.total_amount);
        totalIncome += parseInt(element.total_amount);
    }
  });

  // Update the transaction table with the filtered transactions
  updateTransactionTable(filteredTransactions);
}

// Function to handle changes in the order by select element
function handleOrderByChange() {
  handleSearchChange();
}

// Function to handle changes in the start date input field
function handleStartDateChange() {
  handleSearchChange();
}

// Function to handle changes in the end date input field
function handleEndDateChange() {
  handleSearchChange();
}

// Add event listeners to the input fields, select element, and date input fields
document.getElementById('search').addEventListener('input', handleSearchChange);
document.getElementById('orderBy').addEventListener('change', handleOrderByChange);
document.getElementById('startDate').addEventListener('change', handleStartDateChange);
document.getElementById('endDate').addEventListener('change', handleEndDateChange);
</script>

@endsection