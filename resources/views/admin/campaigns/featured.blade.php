@extends('admin.shared.layout')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#campaigns').select2({
                closeOnSelect: false
            });

            @if(is_null(old('campaigns', null)))
                $('#campaigns').val({!!$selected->toJson()!!});
            @else
                $('#campaigns').val({!! collect(old('campaigns', []))->toJson()!!});
            @endif
            $('#campaigns').trigger('change');
        });
    </script>
@endsection

@section('body')

    <h2>Homepage Featured Campaigns</h2>
    <hr>
    {!! Form::open(array('url' => '/admin/campaigns/featured', 'method' => 'post')) !!}
    <div class="container">
        {{-- Was there an error? --}}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <td valign="top">Campaigns:</td>
            <td>
                {!! Form::select('campaigns[]', $campaigns, $selected, array('id' => 'campaigns', 'class' => 'form-control', 'multiple' => 'multiple')) !!}
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                {!! Form::submit('Submit', array('class' => 'btn btn-default')) !!}
            </td>
        </tr>
    </table>
    {!! Form::close() !!}

@endsection