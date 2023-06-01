@extends('shared.layout')

@section('body')


<div class="hero hero-dashboard py-6">
    <div class="container">
        <div class="row hero-stats">
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-subtitle">Today Clicks</h3>
                        <h2 class="card-title text-inherit">{!! $today_clicks !!}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-subtitle">Today Leads</h3>
                        <h2 class="card-title text-inherit">{!! $today_leads !!}</h2>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-sm-4 col-md-3 col-xs-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-subtitle">Today EPC</h3>
                        <h2 class="card-title text-inherit">
                        @if($today_clicks === 0)
                            n/a
                        @else
                            {!! "$".number_format($earnings_today / $today_clicks, 2)."" !!}
                        @endif
                        </h2>
                    </div>
                </div>
            </div>
            -->
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-subtitle">Today CR</h3>
                        <h2 class="card-title text-inherit">
                        @if($today_leads + $today_clicks >= 0)
                            {!! "n/a" !!}
                        @else
                            {!! number_format($today_leads / ($today_leads + $today_clicks) * 100, 2)."%" !!}
                        @endif
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-subtitle">Today Earnings</h3>
                        <h2 class="card-title text-inherit">${!! number_format($earnings_today, 2) !!}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-subtitle">Month Clicks</h3>
                        <h2 class="card-title text-inherit">{!! $today_clicks !!}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-subtitle">Month Earnings</h3>
                        <h2 class="card-title text-inherit">${!! number_format($earnings_month, 2) !!}</h2>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>


<div class="page-container dashboard py-6">
    <div class="container">
        <h2>Earning Activity</h2>

        <div>
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>

        <div class="col-auto col-lg-4">
            <div class="card">
                <div class="card-header">Sort Reports</div>
                <div class="card-body">
                    {!! Form::open(array('url' => 'reports', 'method' => 'get')) !!}
                    <b>Start date:</b>
                    <?php $start_month = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
                    {!! Form::select('startMonth', $start_month, $request->has('startMonth') ? $request->startMonth : \Carbon\Carbon::now()->month) !!}

                    <?php $start_day = array(1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 7 =>  '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12', 13 => '13', 14 => '14', 15 => '15', 16 => '16', 17 => '17', 18 =>  '18', 19 => '19', 20 => '20', 21 => '21', 22 => '22', 23 => '23', 24 => '24', 25 => '25', 26 => '26', 27 => '27', 28 => '28', 29 => '29', 30 => '30', 31 => '31'); ?>
                    {!! Form::select('startDay', $start_day, $request->has('startDay') ? $request->startDay : \Carbon\Carbon::now()->day) !!}

                    <?php 
                        $current_year = date('Y');
                        $start_year = array();

                        for ($i = $current_year; $i >= $current_year - 10; $i--) {
                            $start_year[$i] = $i;
                        }
                    ?>
                    {!! Form::select('startYear', $start_year, $request->has('startYear') ? $request->startYear : \Carbon\Carbon::now()->year) !!}
                    <div class="clearfix"></div>
                    <hr>

                    <b>End date:</b>

                    <?php $end_month = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
                    {!! Form::select('endMonth', $end_month, $request->has('endMonth') ? $request->endMonth : \Carbon\Carbon::now()->month) !!}

                    <?php $end_day = array(1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 7 =>  '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12', 13 => '13', 14 => '14', 15 => '15', 16 => '16', 17 => '17', 18 =>  '18', 19 => '19', 20 => '20', 21 => '21', 22 => '22', 23 => '23', 24 => '24', 25 => '25', 26 => '26', 27 => '27', 28 => '28', 29 => '29', 30 => '30', 31 => '31'); ?>
                    {!! Form::select('endDay', $end_day, $request->has('endDay') ? $request->endDay : \Carbon\Carbon::now()->day) !!}

                    <?php 
                        $current_year = date('Y');
                        $end_year = array();

                        for ($i = $current_year; $i >= $current_year - 10; $i--) {
                            $end_year[$i] = $i;
                        }
                    ?>

                    {!! Form::select('endYear', $end_year, $request->has('endYear') ? $request->endYear : \Carbon\Carbon::now()->year) !!}
                    <div class="clearfix"></div>
                    <hr>
                    <b>Show all by:</b>

                    {!! Form::select('showBy', ['all' => 'All Reports', 1 => 'Clicks', 2 => 'Leads', 3 => 'Reversals'], $request->has('showBy') ? $request->showBy : 'all') !!}
                    <div class="clearfix"></div>
                    <hr>
                    {!! Form::submit('Sort Reports', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                    <br />
                </div>
            </div>
        </div>

        <div class="col-xs-12 no-padding">
            <div class="card">
                <div class="card-header">Reports</div>
                <div class="card-body">
                    @if(count($reports))
                        <table class="table table-lg table-thead-bordered table-bordered table-align-middle card-table table-hover">
                            <thead>
                            <tr>
                                <th>Report ID</th>
                                <th>Campaign</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td>#{!! $report->id !!}</td>
                                    <td>{!! $report->campaign->name !!}</td>
                                    <td>{!! date('m/d/Y g:i A', strtotime($report->created_at)) !!}</td>
                                    <td>
                                    @if($report->status == 1)
                                        Click
                                    @elseif ($report->status == 2)
                                        Lead
                                    @elseif ($report->status == 3)
                                        Reversal
                                    @endif
                                    </td>
                                    <td><a href="{!! url('/report/' . $report->id) !!}">View</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $reports->render() !!}
                    @else
                        <div class="alert alert-danger" role="alert">There are no reports found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div><!--end page-->

@endsection

@section('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js" type='text/javascript'></script>
    <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($earnings_graph->pluck('date')) !!},
                datasets: [
                    {
                        label: "Earnings",
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "#3b76ed",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#3b76ed",
                        pointBackgroundColor: "#3b76ed",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#3b76ed",
                        pointHoverBorderColor: "#3b76ed",
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
                }
            }
        });
    </script>

    <script>
        function load() {
            var colors = ["transparent"];
            var rand = Math.floor(Math.random()*colors.length);
            $.getJSON("../includes/livestats/dashboard.php", { get:"stats" },function(data) {
                $("#today_visits_top").fadeOut().fadeIn().html(data.todayVisits).css("background-color", colors[rand]);
                /*$("#today_visits_top").html(data.todayVisits);*/
                $("#today_visits").fadeOut().fadeIn().html(data.todayVisits).css("background-color", colors[rand]);
                $("#today_clicks").fadeOut().fadeIn().html(data.todayClicks).css("background-color", colors[rand]);
                $("#today_leads_top").fadeOut().fadeIn().html(data.todayLeads).css("background-color", colors[rand]);
                $("#today_leads").fadeOut().fadeIn().html(data.todayLeads).css("background-color", colors[rand]);
                $("#today_earnings_top").fadeOut().fadeIn().html(data.todayEarnings).css("background-color", colors[rand]);
                $("#today_earnings").fadeOut().fadeIn().html(data.todayEarnings).css("background-color", colors[rand]);
                $("#today_cr").fadeOut().fadeIn().html(data.todayCalculateCR).css("background-color", colors[rand]);
                $("#today_epc").fadeOut().fadeIn().html(data.todayEPC).css("background-color", colors[rand]);
                $("#today_ctr").fadeOut().fadeIn().html(data.todayCTR).css("background-color", colors[rand]);

                $("#month_visits_top").html(data.monthVisits);
                $("#month_visits").html(data.monthVisits);
                $("#month_clicks").html(data.monthClicks);
                $("#month_leads").html(data.monthLeads);
                $("#month_earnings").html(data.monthEarnings);
                $("#month_cr").html(data.monthCalculateCR);
                $("#month_epc").html(data.monthEPC);
                $("#month_ctr").html(data.monthCTR);
            });
        }
        $(function() {
            load();//on the page load.
            setInterval(load,30000);
        });
    </script>

@endsection
