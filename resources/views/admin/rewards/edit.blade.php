@extends('admin.shared.layout')
@section('body')
    <h3>Update Reward</h3>
    @if(Session::has('success'))
        <div class="alert alert-success">
            {!! Session::get('success') !!}
        </div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger">
            {!! Session::get('error') !!}
        </div>
    @else

    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::model($reward, ['method' => 'PATCH', 'url' => '/admin/rewards/'.$reward->id,  'class' => 'form-horizontal', 'files' => 'true'])!!}
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Reward name</label>
        <div class="col-sm-9">
            {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Reward Name', 'required'=>'required', 'size'=>'70' )) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Reward description</label>
        <div class="col-sm-9">
            {!! Form::textarea('description', null, array('class' => 'form-control', 'placeholder' => 'description here....', 'cols' => '30', 'rows' => '6' )) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Reward Points</label>
        <div class="col-sm-9">
            {!! Form::number('points', null, array('class' => 'form-control', 'placeholder' => 'Points', 'required'=>'required', 'size'=>'70' )) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="featured_img" class="col-sm-2 control-label">Reward Image</label>
        <div class="col-sm-9">
    <span class="btn btn-file">
    {!! Form::file('image', null, array('placeholder' => 'Reward Image', 'accept' => 'image/*', 'multiple'=>'false' )) !!}
    </span>
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-2 control-label"></label>
        <div class="col-sm-9">
            <button type="submit" class="btn btn-default">Add Rewards</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection