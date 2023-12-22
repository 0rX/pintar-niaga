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
   
    var amountSoldByProduct = {!! json_encode($amountSoldByProduct) !!}
    
		//--------------
		//- AREA CHART -
		//--------------
    
		// Get context with jQuery - using jQuery's .get() method.
		var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    
    var sales = {!! $sales !!}

    var salesDates = sales.map(function(sale) {
      var formattedDate = new Date(sale.created_at).toLocaleDateString()
      return formattedDate
    });

    var salesAmounts = sales.map(function(sale) {
      return sale.total_amount
    });

    // console.log(sales)
    
		var areaChartData = {
			labels: salesDates,
			datasets: [{
					label: 'Daily Sales',
					backgroundColor: 'rgba(60,141,150,0.3)',
					borderColor: 'rgba(60,141,150,0.8)',
					pointRadius: 3,
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
    
    var categoryLabels = amountSoldByCategory.map(function(item) {
      return item.name;
    });

    var totalSalesAmounts = amountSoldByCategory.map(function(item) {
      return item.total_sold;
    });

    currentMonth = '{!! now()->format('F') !!}'

		var barChartData = {
      labels: categoryLabels,
      datasets: [{
        label: currentMonth.concat(' Sale'),
        backgroundColor: 'rgba(60,141,150,0.3)',
        borderColor: 'rgba(60,141,150,0.8)',
        borderWidth: 1,
        data: totalSalesAmounts
      }
    ]
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
		var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
		var donutData = {
			labels: [
				'Chrome',
				'IE',
				'FireFox',
				'Safari',
				'Opera',
				'Navigator',
			],
			datasets: [{
				data: [700, 500, 400, 600, 300, 100],
				backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
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
