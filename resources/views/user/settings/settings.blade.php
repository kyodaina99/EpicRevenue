@extends('shared.layout')

@section('body')
<div class="hero text-center py-6">
    <div class="container">
                    <h1 class="hero-heading fw-700">Settings</h1>
            <p class="hero-p">Make changes to your account information.</p>
            </div>
</div>
<div class="page-container py-6">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 mx-auto">
				<div class="row">
					<div class="col-sm-8">
						<div class="card">
							<div class="card-header">Account Information</div>
							<div class="card-body">
								@if (count($errors) > 0)
									<div class="alert alert-danger">
										@foreach ($errors->all() as $error)
											<div class="alert alert-danger" role="alert">
												<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
												{{ $error }}
											</div>
										@endforeach
									</div>
								@endif
								{!! Form::model($user, array('url' => '/settings/updateInfo', 'method' => 'post', 'class' => 'form-horizontal'))!!}
								<div class="form-group">
									{!! Form::label('firstname', 'First name', array('class' => 'col-sm-2 control-label')) !!}
									{!! Form::text('firstname', null, array('class' => 'form-control', 'placeholder' => 'First name', 'required'=>'required', 'size'=>'70' )) !!}
								</div>
								<div class="form-group">
									{!! Form::label('lastname', 'Last name', array('class' => 'col-sm-2 control-label')) !!}
									{!! Form::text('lastname', null, array('class' => 'form-control', 'placeholder' => 'Last name', 'cols' => '30', 'rows' => '6' )) !!}
								</div>
								<div class="form-group">
									{!! Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) !!}
									{!! Form::email('email', null, array('class' => 'form-control', 'disabled' )) !!}
								</div>
								<div class="form-group">
									{!! Form::label('address1', 'Address', array('class' => 'col-sm-2 control-label')) !!}
									{!! Form::text('address1', null, array('class' => 'form-control', 'placeholder' => 'Address line 1', 'required'=>'required', 'size'=>'70' )) !!}
								</div>
								<div class="form-group">
									{!! Form::label('address2', '', array('class' => 'col-sm-2 control-label')) !!}
									{!! Form::text('address2', null, array('class' => 'form-control', 'placeholder' => 'Address line 2', 'required'=>'required' )) !!}
								</div>
								<div class="form-group">
									{!! Form::label('city', 'City', array('class' => 'col-sm-2 control-label')) !!}
									{!! Form::text('city', null, array('class' => 'form-control', 'placeholder' => 'City', 'required'=>'required' )) !!}
								</div>
								<div class="form-group">
									{!! Form::label('state', 'State', array('class' => 'col-sm-2 control-label')) !!}
									{!! Form::text('state', null, array('class' => 'form-control', 'placeholder' => 'State')) !!}
								</div>
								<div class="form-group">
									{!! Form::label('zip', 'Zipcode', array('class' => 'col-sm-2 control-label')) !!}
									{!! Form::text('zip', null, array('class' => 'form-control', 'placeholder' => 'Zipcode')) !!}
								</div>

								<div class="form-group">
									{!! Form::submit('Update Info', array('class' => 'btn btn-primary')) !!}
								</div>
								{!! Form::close() !!}
							</div>
						</div>
					</div><!--end grid_4-->

					<div class="col-sm-4">
						<div class="card">
							<div class="card-header">Email Notifications</div>
							<div class="card-body">
								{!! Form::open(array('url' => '/settings/updateNotifications', 'method' => 'post'))!!}
								<div class="form-group">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="newsletters" @if($user->emailNotification->newsletters === 'yes') checked @endif> Newsletter & Emails from Support
										</label>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="leads" @if($user->emailNotification->leads === 'yes') checked @endif> New lead email
										</label>
									</div>
								</div>
								{!! Form::submit('Update Notifications', array('class' => 'btn btn-primary')) !!}
								{!! Form::close() !!}
							</div>
						</div>
						<div class="mb-2">
							<div class="panel-body">
								<a href="{!! url('/settings/password') !!}">Click here to change password</a>
							</div>
						</div>
						<div class="panel">
							<div class="panel-body">
								<a href="{!! url('/taxdetails') !!}">Click here to submit or update tax information</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--- end .row -->
	</div><!--- end .container -->
</div><!--- end .page-container -->
@endsection
