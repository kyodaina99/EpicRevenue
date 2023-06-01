@extends('shared.layout')

@section('body')
<div class="hero text-center border-bottom py-6">
    <div class="container">

        <h1 class="hero-heading">{{ $campaign->name }}</h1>
        @if(!is_null($custom_rate))
            <p class="get-paid">Get paid <span style="text-decoration: line-through;">${{ $campaign->rate }} </span><b>${{ $custom_rate->rate }}</b> per lead.</p>
        @else
            @if($campaign->network_rate_type == 4)
                @php
                    $percentage = (((1000 * (1 - ($campaign->rate / 100))) * ($campaign->network_rate / 100)) / 1000) * 100;
                @endphp
                <p class="get-paid">Get paid <b>{{ round($percentage, 2) }}%</b> of purchases.</p>
            @else
                <p class="get-paid">Get paid <b>${{ $campaign->rate }}</b> per lead. </p>
            @endif
        @endif
    </div>
</div>
<div class="page-container py-6">
    <div class="container">
        @if($cap_daily_status)
            <div class="alert alert-danger">This campaign has reached its daily cap ({{ $campaign->cap_daily }} leads a day). It will reset at midnight.</div>
        @endif
        <div class="mb-2">
            <h2>Category: {{ $campaign->category->name }}</h2>
        </div>
        <div class="mb-2">
            <p>{{ $campaign->description }}</p>
        </div>
        <div class="mb-2">
            <h5><strong>Requirements:</strong></h5>
            <p>{{ $campaign->requirements }}</p>
        </div>

        @if(auth()->user()->role == 1 || auth()->user()->role == 2)
            @unless($cap_daily_status)
            <div class="input-group promotional-link">
                <span class="input-group-text">Promotional Link</span>
                <input type="text" id="copyTarget" class="form-control" value="{{ url('/track/'. $campaign->id . '/' . auth()->user()->id) }}">
                <span id="copyButton" class="input-group-addon btn btn-primary" title="Click to copy">
                    <i id="copiedText" class="bi bi-clipboard"></i>
                </span>
            </div>
            @endunless
        @endif

        <hr>

        <div>
            <a class="btn btn-primary btn-lg" href="{!! url('/campaigns') !!}">Go Back</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function() {
  "use strict";

  function copyToClipboard(elem) {
    var target = elem;

    // select the content
    var currentFocus = document.activeElement;

    target.focus();
    target.setSelectionRange(0, target.value.length);

    // copy the selection
    var succeed;

    try {
      succeed = document.execCommand("copy");
    } catch (e) {
      console.warn(e);
      succeed = false;
    }

    // Restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
      currentFocus.focus();
    }

    if (succeed) {
        $('#copiedText').removeClass('bi-clipboard');
        $('#copiedText').addClass('bi-clipboard-check-fill');
        $('#copyButton').removeClass('btn-primary');
        $('#copyButton').addClass('btn-success');
    }

    return succeed;
  }

  $("#copyButton, #copyTarget").on("click", function() {
    copyToClipboard(document.getElementById("copyTarget"));
  });
})();
</script>
@endsection
