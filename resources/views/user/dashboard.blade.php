@extends('shared.layout')

@section('body')

<div class="hero hero-dashboard py-6">
    <div class="container">
        <div class="row hero-stats">
        <div class="col-lg-8 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-2">
                            <h3 class="card-subtitle mb-0">Today Clicks</h3>
                            <span class="card-title text-inherit fs-18">{!! $today_clicks !!}</span>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <h3 class="card-subtitle mb-0">Today EPC</h3>
                            <span class="card-title text-inherit fs-18">
                            @if($today_clicks === 0)
                                n/a
                            @else
                                {!! "$".number_format($earnings_today / $today_clicks, 2)."" !!}
                            @endif
                            </span>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <h3 class="card-subtitle mb-0">Today Earnings</h3>
                            <span class="card-title text-inherit fs-18">${!! number_format($earnings_today, 2) !!}</span>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <h3 class="card-subtitle mb-0">Today Conversions</h3>
                            <span class="card-title text-inherit fs-18">
                            @if($today_clicks === 0)
                                n/a
                            @else
                                {!! "$".number_format($earnings_today / $today_clicks, 2)."" !!}
                            @endif
                            </span>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <h3 class="card-subtitle mb-0">Today CR</h3>
                            <span class="card-title text-inherit fs-18">
                            @if($today_leads + $today_clicks >= 0)
                                {!! "n/a" !!}
                            @else
                                {!! number_format($today_leads / ($today_leads + $today_clicks) * 100, 2)."%" !!}
                            @endif
                            </span>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <span class="card-title text-inherit fs-18">View Details</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <h3 class="card-subtitle">Today</h3>
                            <h2 class="card-title text-inherit">${!! number_format($earnings_month, 2) !!}</h2>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <h3 class="card-subtitle">This Week</h3>
                            <h2 class="card-title text-inherit">${!! number_format($earnings_month, 2) !!}</h2>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <h3 class="card-subtitle">This Month</h3>
                            <h2 class="card-title text-inherit">${!! number_format($earnings_month, 2) !!}</h2>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <h3 class="card-subtitle">Last Month</h3>
                            <h2 class="card-title text-inherit">${!! number_format($earnings_month, 2) !!}</h2>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <h3 class="card-subtitle">This Year</h3>
                            <h2 class="card-title text-inherit">${!! number_format($earnings_month, 2) !!}</h2>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <h3 class="card-subtitle">All Time</h3>
                            <h2 class="card-title text-inherit">${!! number_format($earnings_month, 2) !!}</h2>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>  
    </div>
</div>
        
<div class="page-container py-6 dashboard">
    <div class="container">
        
        <div class="card">
            <div class="card-header">Earnings</div>
            <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    @if($is_mobile)
        <div class="container" style="height: 50px;">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Top campaigns</strong></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    @foreach($top_campaigns as $campaign)
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <a href="/campaign/{!! $campaign->id !!}"><h4>{{ $campaign->name }}</h4></a>
                                <!--<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>-->
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
        </div>
    @endif
</div>

@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js" type='text/javascript'></script>
    <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($earnings_graph->pluck('date')) !!},
                datasets: [
                    {
                        label: "Earnings",
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "#ca6e6e",
                        borderColor: "#960000",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#960000",
                        pointBackgroundColor: "#960000",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#960000",
                        pointHoverBorderColor: "#960000",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: {{ json_encode($earnings_graph->pluck('value')) }},
                        spanGaps: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                       label: function(tooltipItem) {
                              return tooltipItem.yLabel;
                       }
                    }
                }
            }
        });
    </script>
@endsection
