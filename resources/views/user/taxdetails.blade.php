@extends('shared.layout')

@section('scripts')
    <script type="text/javascript">
        $('#ssn').keyup(function() {
            var val = this.value.replace(/\D/g, '');
            var newVal = '';
            if(val.length > 4) {
                this.value = val;
            }
            if((val.length > 3) && (val.length < 6)) {
                newVal += val.substr(0, 3) + '-';
                val = val.substr(3);
            }
            if (val.length > 5) {
                newVal += val.substr(0, 3) + '-';
                newVal += val.substr(3, 2) + '-';
                val = val.substr(5);
            }
            newVal += val;
            this.value = newVal;
        });
    </script>
@endsection

@section('body')
    <div class="page-container no-shadow">
        <div class="container">
            @if(isset($success))
                <div class="alert alert-success" role="alert">Tax details (xxx-xx-xx{!! $tax_details->tax_id !!}) submitted on {!! \Carbon\Carbon::now()->format('d/m/y') !!}. You can update your tax details at any time by re-submitting the form below.</div>
            @endif
            <div class="alert alert-info" role="alert">
                <h4>Request for Taxpayer Identification Number and Certification</h4>
                <p>All tax IDs are encrypted before they are stored in our database. Your privacy is important to us.</p>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Electronic W9 Form</div>
                <div class="panel-body">
                    <div class="alert alert-info">
                        A W-9 (US) tax form is required to receive payments for all US residents. INTL users do not need to provide this information.
                        US residents, please complete our secure electronic tax form below. If you do not have a Tax Identification Number (TIN/SSN/EIN) then please contact your Performance Manager.
                    </div>
                    {{--Was there an error?--}}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::open(array('url' => 'taxdetails', 'method' => 'post')) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('business_name', 'Business Name (If different than above)') !!}
                        {!! Form::text('business_name', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('appropriate_type', 'Appropriate Type') !!}
                        {!! Form::select('appropriate_type', array('Corporation' => 'Corporation', 'Partnership'  => 'Partnership', 'Individual/Sole Proprietor' => 'Individual/Sole Proprietor', 'Other' => 'Other'), null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('address', 'Address (NUMBER, STREET, AND APT. OR SUITE NO.)') !!}
                        {!! Form::text('address', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('location', 'City, State And ZIP Code') !!}
                        {!! Form::text('location', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('tax_id', 'TAXPAYER IDENTIFICATION NUMBER (TIN)') !!}
                        {!! Form::text('tax_id', null, array('class' => 'form-control', 'id' => 'ssn', "maxlength" => "11", "required" => "required", "placeholder" => "|___-__-____")) !!}
                        <p class="help-block">Please Enter your SSN (For Individuals) or EIN (For Businesses)</p>
                    </div>
                    <div class="alert alert-info">
                        <h3 style="margin-top: 5px">Certification</h3>
                        <b>Under penalties of perjury, I certify that:</b>

                        <ol>
                            <li>
                                The number shown on this form is my correct taxpayer identification number (or I am waiting for a number to be issued to me), and
                            </li>
                            <li>
                                I am not subject to backup withholding because: (a) I am exempt from backup withholding, or (b) I have not been notified by the Internal Revenue Service (IRS) that I am subject to backup withholding as a result of a failure to report all interest or dividends, or (c) the IRS has notified me that I am no longer subject to backup withholding, and
                            </li>
                        </ol>
                        <p>
                            <b>Certification instructions: </b>You may disregard item 2 above if you have been notified by the IRS that you are currently subject to backup withholding because you have failed to report all interest and dividends on your tax return.
                        </p>
                        <p>
                            *I agree that I am electronically signing a W-9/W-8 form and that all of the above information is accurate and if not, I will be prosecuted to the fullest extent of the law.
                        </p>
                    </div>
                    <div class="form-group">
                        {!! Form::label('signature', 'Signature') !!}
                        {!! Form::text('signature', null, array('class' => 'form-control')) !!}
                        {!! Form::checkbox('form', null, false) !!} By checking this box you agree to electronically sign and date your name here. Today's date is: <b>{!! \Carbon\Carbon::now()->format('d/m/y') !!}</b>
                    </div>
                    {!! Form::submit("Update Tax Details Info", array('class' => 'btn btn-default')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection