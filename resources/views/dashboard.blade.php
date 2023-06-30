@extends('layout.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
  
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Registered Users</span>
                  <span class="info-box-number">
                    {{$total_users}}
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-check"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Joined Users</span>
                  <span class="info-box-number">
                    {{$total_allowed_users}}
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Allowed USDT</span>
                  <span class="info-box-number">{{number_format($total_allowed_balance,2)}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-dollar-sign"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Total USDT</span>
                  <span class="info-box-number">{{number_format($total_allowed_balance,2)}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card bg-dark">
              <div class="card-header border-0">
                <h3 class="card-title">
                  This month registrations
                </h3>
              </div>
              <div class="card-body">
                <canvas class="chart" id="thisMonthRegistrations" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-footer -->
            </div>
            </div>
          </div>
          <!-- /.row -->
        </div><!--/. container-fluid -->
      </section>
      <!-- /.content -->
@endsection
@push('script')
    <script>
      // Sales graph chart
      var thisMonthRegistrationChartCanvas = $('#thisMonthRegistrations').get(0).getContext('2d')
      // $('#revenue-chart').get(0).getContext('2d');

      var thisMonthRegistrationData = @json($this_month_registered_users);
      var thisMonthRegistrationChartData = {
        labels: thisMonthRegistrationData['labels'],
        datasets: [
          {
            label: 'Digital Goods',
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#efefef',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#efefef',
            pointBackgroundColor: '#efefef',
            data: thisMonthRegistrationData['data']
          }
        ]
      }

      var thisMonthRegistrationChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            ticks: {
              fontColor: '#efefef'
            },
            gridLines: {
              display: false,
              color: '#efefef',
              drawBorder: false
            }
          }],
          yAxes: [{
            ticks: {
              stepSize: 5000,
              fontColor: '#efefef'
            },
            gridLines: {
              display: true,
              color: '#efefef',
              drawBorder: false
            }
          }]
        }
      }

      // This will get the first returned node in the jQuery collection.
      // eslint-disable-next-line no-unused-vars
      var thisMonthRegistrationChart = new Chart(thisMonthRegistrationChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: thisMonthRegistrationChartData,
        options: thisMonthRegistrationChartOptions
      })
    </script>
@endpush