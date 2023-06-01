@extends('shared.layout')

@section('body')

    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-8">
                {!! Form::model($snapmoney, array('url' => '/', 'method' => 'post', 'class' => '','style' => '')) !!}
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Wall Setup</h3>
                    </div>
                    <div class="panel-body">
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
                        <div class="form-group">
                            {!! Form::label('page_header', 'Page Header', array()) !!}
                            {!! Form::select('page_header', array('text' => 'Text', 'image' => 'Image'), null, array('id' => 'page_header', 'class' => 'form-control', 'style' => 'margin-bottom:5px;')) !!}
                            {!! Form::text('page_header_title', null, array('id' => 'page_header_title', 'class' => 'form-control', 'placeholder' => 'Page Header Text')) !!}
                            {!! Form::file('page_header_image', array('id' => 'page_header_image', 'class' => '', 'style' => 'display:none')) !!}
                        </div>
                        <hr>
                        <div class="form-group">
                            {!! Form::label('title', 'Main Page Title', array()) !!}
                            {!! Form::text('title', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Main Page Description', array()) !!}
                            {!! Form::text('description', null, array('class' => 'form-control')) !!}
                        </div>
                        <hr>
                        <div class="form-group">
                            {!! Form::label('instructions', 'Instructions', array()) !!}
                            {!! Form::textarea('instructions', null, array('class' => 'form-control')) !!}
                        </div>
                        <hr>
                        <div class="form-group">
                            {!! Form::label('login_title', 'Login Page Title', array()) !!}
                            {!! Form::text('login_title', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('login_description', 'Login Page Description', array()) !!}
                            {!! Form::text('login_description', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('login_background_image', 'Login Page Background Image', array()) !!}
                            {!! Form::text('login_background_image', null, array('class' => 'form-control')) !!}
                        </div>
                        <hr>
                        <div class="form-group">
                            {!! Form::label('custom_color', 'Custom Color', array()) !!}
                            {!! Form::select('custom_color', array('No', 'Yes'), null, array('id' => 'custom_color', 'class' => 'form-control')) !!}
                            {!! Form::text('custom_color_value', null, array('id' => 'custom_color_value', 'class' => 'form-control', 'style' => 'display:none;')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('exclude_cpa', 'Exclude CPA', array()) !!}
                            {!! Form::text('exclude_cpa', null, array('class' => 'form-control')) !!}
                        </div>
                        <hr>
                    </div>
                    <div class="panel-footer">
                        <div class="clearfix"></div>
                        <div>
                        {!! Form::submit('Submit', array('class' => 'btn btn-primary btn-lg pull-right')) !!}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Preview</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                    <div class="panel-footer">Panel footer</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/evol-colorpicker.min.js" type="text/javascript" charset="utf-8"></script>

    <script type="text/javascript">
        $("#page_header" ).change(function() {
            if($("#page_header" ).val() == 'text') {
                $("#page_header_title").show();
                $("#page_header_image" ).hide();
            }else if ($("#page_header" ).val() == 'image')
            {
                $("#page_header_title").hide();
                $("#page_header_image" ).show();
            }
//          alert( "Handler for .change() called.  " +  );
        });

        $("#custom_color" ).change(function() {
            if($("#custom_color" ).val() == 1) {
                $("#custom_color_value").show();
            }else if ($("#custom_color" ).val() == 0) {
                $("#custom_color_value").hide();
            }
//          alert( "Handler for .change() called.  " +  $("#custom_color" ).val());
        });
    </script>

@endsection