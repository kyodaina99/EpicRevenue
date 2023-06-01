@extends('shared.layout')

@section('body')
<div class="hero text-center py-6">
    <div class="container">
        <h1 class="hero-heading fw-700">Report # {!! $report->id !!}</h1>
    </div>
</div>
<div class="page-container py-6">
    <div class="container">

        <table class="table table-hover table-bordered">
            <tr>
                <td><b>ID:</b></td>
                <td>{!! $report->id !!}</td>
            </tr>
            <tr>
                <td><b>Campaign name:</b></td>
                <td>{!! $report->campaign->name !!}</td>
            </tr>
            <tr>
                <td><b>Campaign rate:</b></td>
                <td>${!! number_format($report->rate,2) !!}</td>
            </tr>
            <tr>
                <td><b>Status:</b></td>
                @if($report->status == 1)
                    <td>Click</td>
                @elseif ($report->status == 2)
                    <td>Lead</td>
                @elseif ($report->status == 3)
                    <td>Reversal</td>
                @endif
            </tr>
            <tr>
                <td><b>IP:</b></td>
                <td>{!! $report->ip !!}</td>
            </tr>
            <tr>
                <td><b>Subid1:</b></td>
                <td>{!! $report->subid1 !!}</td>
            </tr>
            <tr>
                <td><b>Subid2:</b></td>
                <td>{!! $report->subid2 !!}</td>
            </tr>
            <tr>
                <td><b>Subid3:</b></td>
                <td>{!! $report->subid3 !!}</td>
            </tr>
            <tr>
                <td><b>Subid4:</b></td>
                <td>{!! $report->subid4 !!}</td>
            </tr>
            <tr>
                <td><b>Subid5:</b></td>
                <td>{!! $report->subid5 !!}</td>
            </tr>
        </table><br />

        <div>
            <a class="btn btn-primary btn-lg" href="{!! url('/reports')  !!}">Go Back</a>
        </div>
    </div>
</div>

@endsection

@section('scripts')


@endsection
