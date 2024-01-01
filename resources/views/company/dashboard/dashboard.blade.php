@extends('layouts.app')

@section('content')
@section('title')
	Company Dashboard
@endsection

<div class="container" data-bs-theme="light">
	<div class="row justify-content-center">
		<div class="col-md-11">
			<div class="wrapper">

				<div class="content-wrapper">

					<section class="content-header">
						<div class="container-fluid">
							<div class="row mb-2">
								<div class="col-sm-6">
									<h1>Dashboard</h1>
								</div>
							</div>
						</div>
					</section>

					<section class="content">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12 mb-3">

									<div class="card card-primary">
										<div class="card-header">
											<div class="d-flex">
												<h3 class="card-title">Daily Sales</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class='bx bxs-up-arrow'></i>
													</button>
												</div>
											</div>
										</div>
										<div class="card-body">
											<div class="chart">
												<canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
											</div>
										</div>

									</div>
								</div>
								<div class="col-md-6 mb-3">

									<div class="card card-success">
										<div class="card-header">
											<div class="d-flex">
												<h3 class="card-title">Category Data</h3>
												<div class="card-tools ms-3">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class='bx bxs-up-arrow'></i>
													</button>
													<button type="button" class="btn btn-tool" data-card-widget="remove">
														<i class="fas fa-times"></i>
													</button>
												</div>
											</div>
										</div>
										<div class="card-body">
											<div class="chart">
												<canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="card card-danger">
										<div class="card-header">
											<div class="d-flex">
												<h3 class="card-title">Product Chart</h3>
												<div class="card-tools ms-3">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class='bx bxs-up-arrow'></i>
													</button>
													<button type="button" class="btn btn-tool" data-card-widget="remove">
														<i class="fas fa-times"></i>
													</button>
												</div>
											</div>
										</div>
										<div class="card-body">
                      <div class="chart">
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</section>

				</div>

			</div>
		</div>
	</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
$(function() {
    /* ChartJS
    * -------
    * Here we will create a few charts using ChartJS
    */
    
	//--------------
	//- AREA CHART -
	//--------------

	// Get context with jQuery - using jQuery's .get() method.
	var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    
    var sales = {!! $sales !!}
    
    // console.log(sales)

	var salesByDate = {}

	sales.forEach(function(sale) {
		var date = new Date(sale.created_at).toLocaleDateString()
		if (salesByDate[date]) {
			salesByDate[date] += parseInt(sale.total_amount)
		} else {
			salesByDate[date] = parseInt(sale.total_amount)
		}
	});

	// console.log(salesByDate)

    var salesDates = []

	Object.keys(salesByDate).forEach(function(date) {
	  salesDates.push(date)
	})

    var salesAmounts = []
	Object.keys(salesByDate).forEach(function(date){
		salesAmounts.push(salesByDate[date])
	})
    // console.log(sales)
    
	var areaChartData = {
		labels: salesDates,
		datasets: [{
				label: 'Daily Sales',
				backgroundColor: 'rgba(156, 254, 167, 0.3)',
				borderColor: 'rgba(60,141,150,0.8)',
				pointRadius: 5,
				pointColor: '#3b8bba',
				pointStrokeColor: 'rgba(60,141,188,1)',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(60,141,188,1)',
				data: salesAmounts
			},
		]
	}

	var areaChartOptions = {
		maintainAspectRatio: false,
		responsive: true,
		legend: {
			display: false
		},
		scales: {
			xAxes: [{
				gridLines: {
					display: true,
				}
			}],
			yAxes: [{
				gridLines: {
					display: true
				}
			}]
		}
	}

	// This will get the first returned node in the jQuery collection.
	new Chart(areaChartCanvas, {
		type: 'line',
		data: areaChartData,
		options: areaChartOptions
	})

	//-------------
	//- BAR CHART -
	//-------------
	var barChartCanvas = $('#barChart').get(0).getContext('2d')

    var amountSoldByCategory = {!! json_encode($amountSoldByCategory) !!}
    // console.log(amountSoldByCategory)
    
    var categoryLabels = Object.values(amountSoldByCategory).map(function(item) {
      return item.name;
    });

    var totalSalesAmounts = Object.values(amountSoldByCategory).map(function(item) {
      return parseInt(item.total_sold);
    });

	var randomColors = categoryLabels.map(function() {
		return '#' + Math.floor(Math.random() * 16777215).toString(16);
	});

    currentMonth = '{!! now()->format('F') !!}'

	var barChartData = {
		labels: categoryLabels,
		datasets: [{
			label: currentMonth.concat(' Sale'),
			backgroundColor: 'rgba(60,141,150,0.3)',
			borderColor: 'rgba(60,141,150,0.8)',
			borderWidth: 1,
			data: totalSalesAmounts,
			backgroundColor: randomColors
		}]
	};


	var barChartOptions = {
		responsive: true,
				legend: {
					display: false
				},
		maintainAspectRatio: false,
		datasetFill: false,
		scales: {
			xAxes: [{
			stacked: true,
			}],
			yAxes: [{
			stacked: true
			}]
		}
    }

	new Chart(barChartCanvas, {
		type: 'bar',
		data: barChartData,
		options: barChartOptions
	})

	//-------------
	//- DONUT CHART -
	//-------------
	// Get context with jQuery - using jQuery's .get() method.

	var amountSoldByProduct = {!! json_encode($amountSoldByProduct) !!}

	var donutChartCanvas = $('#donutChart').get(0).getContext('2d')

	productLabels = []
	totalProductSales = []

	// console.log(amountSoldByProduct)

	Object.keys(amountSoldByProduct).forEach(function(item){
		name = amountSoldByProduct[item].name
		productLabels.push(name)
	})

	Object.keys(amountSoldByProduct).forEach(function(item){
		amount = amountSoldByProduct[item].total_sold
		totalProductSales.push(amount)
	})

	var randomColors = productLabels.map(function() {
		return '#' + Math.floor(Math.random() * 16777215).toString(16);
	});

	var donutData = {
		labels: productLabels,
		datasets: [{
			data: totalProductSales,
			backgroundColor: randomColors,
		}]
	}
	var donutOptions = {
		maintainAspectRatio: false,
		responsive: true,
	}
	//Create pie or douhnut chart
	// You can switch between pie and douhnut using the method below.
	new Chart(donutChartCanvas, {
		type: 'doughnut',
		data: donutData,
		options: donutOptions
	})

})
</script>
@endsection
