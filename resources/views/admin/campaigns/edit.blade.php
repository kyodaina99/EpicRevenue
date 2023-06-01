@extends('admin.shared.layout', ['activePage' => 'campaigns', 'title' => 'Edit Campaigns', 'navName' => 'editampaigns', 'activeButton' => 'blog'])

@section('body')
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-no-gutter">
                    <li class="breadcrumb-item"><a class="breadcrumb-link" href="#">Campaigns</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Campaign</li>
                </ol>
            </nav>

            <h1 class="page-header-title">Edit Campaign</h1>

            <div class="mt-2">
                <a class="text-body" href="#">
                    <i class="bi-eye me-1"></i> Preview
                </a>
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
</div>

    {!! Form::model($campaign, array('url' => '/admin/campaigns/' . $campaign->id, 'method' => 'put', 'enctype' => 'multipart/form-data', 'id' => 'addCamp')) !!}
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-header-title mb-0">Campaign Details</h3>
                </div>
                <div class="card-body">
                    {{-- Was there an error? --}}
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2 fw-700">Campaign Name:</label>
                        {!! Form::text('name', null, array('class' => 'form-control' ,'size' => '70')) !!}
                    </div>

                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2 fw-700">Campaign Category:</label>
                        {!! Form::select('category', $campaign_categories, $campaign->category->id, ['placeholder' => 'Select Category', 'class' => 'form-control']) !!}
                    </div>

                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2 fw-700">Campaign Description:</label>
                        {!! Form::textarea('description', null, array('cols' => '30', 'rows' => '6', 'class' => 'form-control')) !!}
                    </div>

                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2 fw-700">Campaign Requirements:</label>
                        {!! Form::textarea('requirements', null, array('class' => 'form-control', 'cols' => '30', 'rows' => '6')) !!}
                    </div>

                    <div class="mb-2">
                        <label for="name" class="w-100 mb-1 fw-700">Campaign URL:</label>
                        <div class="mb-2 fs-12">({hash} = credit hash, {pubid} = publisher id), {email} = email for prepop</div>
                        {!! Form::text('url', null, array('class' => 'form-control', 'size' => '70')) !!} 
                        <div class="mb-2">
                            <a href="#" onclick="addCamp.url.value=addCamp.url.value + '{hash}'; return false;">Add Credit Hash</a> | <a href="#" onclick="addCamp.url.value=addCamp.url.value + '{pubid}'; return false;">Add PubID</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- !card -->

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-header-title mb-0">Targeting</h3>
                </div>
                <div class="card-body">
                    <div id="entry1" class="clonedInput mb-4" style="display:none;">
                        {{--<input type="hidden" name="tar_id[]" value="0">--}}
                        <div class="row">
                            <div class="col-12 url mb-2">
                                <label for="name" class="w-100 mb-2 fw-700">URL</label>
                                <input class="form-control" type="text" name="tar_url[]" value="http://" />
                            </div>
                            <div class="col-4 mb-2">
                                <label for="name" class="w-100 mb-2 fw-700">Select Country</label>
                                <select class="form-control" name="tar_country[]">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $id => $name)
                                        <option value="{{ $name }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 mb-2">
                                <label for="name" class="w-100 mb-2 fw-700">Select OS</label>
                                <select class="form-control" name="tar_os[]">
                                    <option value="">Select OS</option>
                                    <option value="AndroidOS">Android</option>
                                    <option value="iOS">iOS</option>
                                </select>
                            </div>
                            <div class="col-4 mb-2">
                                <label for="name" class="w-100 mb-2 fw-700">Select Device</label>
                                <select name="tar_device[]" class="form-control">
                                    <option value>Select Device</option>
                                    <option value="Desktop">Desktop</option>
                                    <option value="Mobile">Mobile</option>
                                    <option value="Tablet">Tablet</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="name" class="w-100 mb-2 fw-700">Rate</label>
                                <input class="form-control" type="number" name="tar_rate[]" placeholder="Rate" value="" step='0.01' />
                            </div>
                            <div class="col-4">
                                <label for="name" class="w-100 mb-2 fw-700">Network Rate</label>
                                <input class="form-control" type="number" name="tar_network_rate[]" placeholder="Network Rate" value="" step='0.01' />
                            </div>
                            <div class="col-auto">
                                <label for="name" class="w-100 mb-2 fw-700">Active ?</label>
                                <select name="tar_active[]" class="form-control">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php $a = 2; ?>
                    @foreach($campaign_targets as $c)
                        <div id="entry{{ $a }}" class="clonedInput mb-4" style="display:block;">
                            <div class="row">
                                {{--<input type="hidden" name="tar_id[]" value="{{ $c->id }}">--}}
                                <div class="col-12 url mb-2">
                                    <label for="name" class="w-100 mb-2 fw-700">URL</label>
                                    <input class="form-control" type="text" name="tar_url[]" value="{{ $c->url }}" />
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="name" class="w-100 mb-2 fw-700">Select Country</label>
                                    <select class="form-control" name="tar_country[]">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $id => $name)
                                            <option value="{{ $name }}"@if($c->country == $name) selected @endif>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="name" class="w-100 mb-2 fw-700">Select OS</label>
                                    <select class="form-control" name="tar_os[]">
                                        <option value="">Select OS</option>
                                        <option value="AndroidOS" @if($c->operating_system === 'AndroidOS') selected @endif>Android</option>
                                        <option value="iOS" @if($c->operating_system == 'iOS') selected @endif>iOS</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="name" class="w-100 mb-2 fw-700">Select Device</label>
                                    <select name="tar_device[]" class="form-control">
                                        <option value>Select Device</option>
                                        <option value="desktop" @if($c->device === 'Desktop') selected @endif>Desktop</option>
                                        <option value="mobile" @if($c->device === 'Mobile') selected @endif>Mobile</option>
                                        <option value="tablet" @if($c->device === 'Tablet') selected @endif>Tablet</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="name" class="w-100 mb-2 fw-700">Rate</label>
                                    <input class="form-control" type="number" name="tar_rate[]" placeholder="Rate" step='0.01' value="{{ $c->rate }}" />
                                </div>
                                <div class="col-4">
                                    <label for="name" class="w-100 mb-2 fw-700">Network Rate</label>
                                    <input class="form-control" type="number" name="tar_network_rate[]" placeholder="Network Rate" value="{{ $c->network_rate }}" step='0.01' />
                                </div>
                                <div class="col-auto">
                                    <label for="name" class="w-100 mb-2 fw-700">Active ?</label>
                                    <select name="tar_active[]" class="form-control">
                                        <option value="yes" @if($c->active === 'yes') selected @endif>Yes</option>
                                        <option value="no" @if($c->active === 'no') selected @endif>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php $a = $a + 1; ?>
                    @endforeach
                    <div id="addDelButtons">
                        <input type="button" class= "btn btn-primary" id="btnAdd" value="Add rule"> <input type="button" class= "btn btn-danger" id="btnDel" value="Remove rule above">
                    </div>
                </div>
            </div>
            <!-- !card -->

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-header-title mb-0">Tracking</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label for="name" class="w-100 mb-1 fw-700">Postback URL:</label>
                        {!! Form::text('postback_url', null, array('class' => 'form-control', 'size' => '70')) !!}
                    </div>
                    <div class="mb-2">
                        <label for="name" class="w-100 mb-1 fw-700">Tracking Pixel:</label>
                        {!! Form::textarea('tracking', null, array('class' => 'form-control', 'rows' => '6', 'cols' => '30')) !!}
                    </div>
                </div>
            </div>
            <!-- !card -->

            <div class="card mb-4">
                <div class="card-header">
                    <div class="card-header-title d-flex w-100">
                        <h3 class="mr-auto mb-0">Creatives</h3>
                        <a href="javascript:;" class="text-primary" id="getCreativesManger">Select images</a>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="creatives_list" id="creatives_list" value="{{$campaign->creatives}}"/>
                    @php
                        $campaign->creatives = $campaign->creatives ? explode(',', $campaign->creatives) : array();
                    @endphp
                    <div class="no-creatives {{count($campaign->creatives) == 0 ? '' : 'd-none'}}">
                        No Creatives
                    </div>
                    <div class="creatives-list d-flex" style="flex-flow: wrap;">
                        @foreach ($campaign->creatives as $creative)
                            @php
                                $creative_image = $creative ? App\Models\Upload::find($creative) : null;
                            @endphp
                            <div class="text-center creatives-item" creative-id="{{$creative}}" style="width:150px;margin:10px;box-shadow: 2px 2px 8px #6c6969;">
                                <img 
                                    src="{{$creative_image->getImageOptimizedFullPath(400)}}" 
                                    style="width:150px;height:150px;margin:auto;"
                                >
                                <div class="px-3 d-flex">
                                    <a class="btn btn-sm mr-auto" href="{{$creative_image->getImageOriginFullPath()}}" target="_blank"><i class="fa fa-eye"></i></a>
                                    <a href="javascript:;" class="btn btn-sm text-danger" onclick="removeCreatives({{$creative}})"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- !card -->
            
        </div>
        <!-- !col-md-8 -->

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-header-title mb-0">Options</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2 pb-2 border-bottom">
                        <label for="name" class="w-100 mb-2 fw-700">Active ?</label>
                        {!! Form::radio('active', 'yes', true) !!} Yes
                        {!! Form::radio('active', 'no', false) !!} No
                    </div>
                    <div class="mb-2 border-bottom">
                        @if($campaign->mobile === 'yes')
                            {!! Form::checkbox('mobile', 'yes', true) !!}
                        @else
                            {!! Form::checkbox('mobile', 'yes', false) !!}
                        @endif
                        <label class="form-check-label" for="flexCheckDefault">Mobile App Wall ?</label>
                        <div class="mb-2 fs-12">Campaign will show on mobile app wall if checked.</div>
                    </div>
                    <div class="mb-2 border-bottom">
                        @if($campaign->incent === 'yes')
                            {!! Form::checkbox('incent', 'yes', true) !!}
                        @else
                            {!! Form::checkbox('incent', 'yes', false) !!}
                        @endif
                        <label class="form-check-label" for="flexCheckDefault">Incentive ?</label>
                        <div class="mb-2 fs-12">This will be an incentive campaign if checked.</div>
                    </div>
                    <div class="mb-2">
                        @if($campaign->private === 'yes')
                            {!! Form::checkbox('private', 'yes', true) !!}
                        @else
                            {!! Form::checkbox('private', 'yes', false) !!}
                        @endif
                        <label class="form-check-label" for="flexCheckDefault">Private ?</label>
                        <div class="mb-2 fs-12">This will be a private campaign if checked.</div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-header-title mb-0">Rates</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label for="network_rate_type" class="w-100 mb-1 fw-700">Commission Type:</label>
                        <select name="network_rate_type" id="commission-type" class="form-control">
                            <option value="0" {{ $campaign->network_rate_type == 0 ? 'selected' : '' }}>CPL (Cost per Lead)</option>
                            <option value="1" {{ $campaign->network_rate_type == 1 ? 'selected' : '' }}>CPS (Cost per Sale)</option>
                            <option value="2" {{ $campaign->network_rate_type == 2 ? 'selected' : '' }}>CPA (Cost per Action)</option>
                            <option value="3" {{ $campaign->network_rate_type == 3 ? 'selected' : '' }}>CPI (Cost per Install)</option>
                            <option value="4" {{ $campaign->network_rate_type == 4 ? 'selected' : '' }}>Percentage (e.g. 10% of sale)</option>
                            <option value="5" {{ $campaign->network_rate_type == 5 ? 'selected' : '' }}>CPC (Cost per Click)</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2 fw-700">Our Percentage:</label>
                        <div class="mb-2 fs-12">If network rate is dynamic we will use percentage.</div>
                        {!! Form::number('rate_percentage', '30', array('class' => 'form-control')) !!}
                    </div>
                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2 fw-700">Rate:</label>
                        {!! Form::number('rate', null, array('class' => 'form-control', 'min' => '0.01', 'step' => '0.01')) !!}
                    </div>
                    <div class="mb-2">
                        <label for="name" class="w-100 mb-1 fw-700">Network Rate:</label>
                        <div class="mb-2 fs-12">Amount advertiser pays us per action</div>
                        {!! Form::number('network_rate', null, array('class' => 'form-control', 'min' => '0.01', 'step' => '0.01')) !!}
                    </div>
                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2 fw-700">Network:</label>
                        {!! Form::select('network_id', $networks, $campaign->network_id, array('placeholder' => 'Select Network', 'class' => 'form-control')) !!}
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-header-title mb-0">Cap</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2 fw-700">Cap:</label>
                        {!! Form::number('cap', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2 fw-700">Daily Cap:</label>
                        {!! Form::number('cap_daily', null, array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-header-title mb-0">Allowed countries</h3>
                </div>
                <div class="card-body">
                    {!! Form::select('countries[]', $countries, $campaign->countries->pluck('id')->toArray(), array('id' => 'country', 'class' => 'form-control h-200px', 'multiple', 'style' => '')) !!}
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-header-title mb-0">Featured Image</h3>
                </div>
                <div class="card-body">
                    <div class="imagePreview img-thumbnail p-2 text-center">
                        @php
                            $featured_img = $campaign->featured_img ? App\Models\Upload::find($campaign->featured_img) : null;
                        @endphp
                        <img 
                            id="fileManagerPreview" 
                            src="{{$featured_img ? $featured_img->getImageOptimizedFullPath(400) : null}}" 
                            style="max-width: 100%;"
                        >
                    </div>
                    <div class="d-flex mt-3">
                        <span class="btn btn-primary btn-sm me-auto" id="getFileManager">Browse</span>
                        <span class="btn btn-danger btn-sm" id="clearSelectedFile">Clear</span>
                    </div>
                    <input type="hidden" id="fileManagerId" name="feature_image" value="{{$featured_img ? $featured_img->id : null}}">
                </div>
            </div>

        </div>
        <!-- !col-md-4 -->
    </div>
    <!-- !row -->
        
    <div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
        <!-- Card -->
        <div class="card card-sm bg-dark border-dark mx-2">
            <div class="card-body">
                <div class="row justify-content-center justify-content-sm-between">
                    <div class="col">
                        <a href="{{ url('/admin/#/campaigns/') }}" class="btn btn-danger">Cancel</a>
                    </div>
                    <!-- End Col -->

                    <div class="col-auto">
                        <div class="d-flex gap-3">
                            {!! Form::submit('Update Campaign', array('class' => 'btn btn-primary')) !!}
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Card-body --> 
        </div>
        <!-- End Card --> 
    </div>
            
    {!! Form::close() !!}
    <div id="fileManagerContainer"></div>
    <div id="creativesManagerContainer"></div>
@endsection

@section('scripts')
    <script src="{{ url('/admin_assets/js/script_upload_images.js') }}"></script>
    <script src="{{ url('/admin_assets/js/clone-form-td-2.js') }}"></script>
    <script>

        var getSelectedItem = function (selectedId, filePath) {
            $('#fileManagerId').val(selectedId);
            $('#fileManagerPreview').attr('src', filePath);
        }

        var getSelectedCreatives = function (selectedId, filePath, originPath) {
            $('#creatives_list').val(selectedId);
            var creatives_html = "";
            if(filePath.length == 0) {
                $('.no-creatives').removeClass('d-none');
                $('.creatives-list').html('');
            } else {
                $('.no-creatives').addClass('d-none');
                filePath.forEach((item, index) => {
                    creatives_html += `
                        <div class="text-center creatives-item" creative-id="${selectedId[index]}" style="width:150px;margin:10px;box-shadow: 2px 2px 8px #6c6969;">
                            <img 
                                src="${item}"
                                alt="creatives-image"
                                style="width:150px;height:150px;margin:auto;"
                            >
                            <div class="px-3 d-flex">
                                <a class="btn btn-sm mr-auto" href="${originPath[index]}" target="_blank"><i class="fa fa-eye"></i></a>
                                <a href="javascript:;" class="btn btn-sm text-danger" onclick="removeCreatives(${selectedId[index]})"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    `;
                });
                $('.creatives-list').html(creatives_html);
            }
        }
        
        var removeCreatives = function (index) {
            var creatives = $('#creatives_list').val() == '' ? [] : $('#creatives_list').val().split(',');
            var new_creatives = creatives.filter(item => item * 1 !== index);
            $('#creatives_list').val(new_creatives);
            $(`.creatives-item[creative-id='${index}']`).remove();
            if(new_creatives.length == 0){
                $('.no-creatives').removeClass('d-none');
                $('.creatives-list').html('');
            }
        }

        $('#clearSelectedFile').click(function () {
            clearSelected();
            $('#fileManagerPreview').attr('src', null);
            $('#fileManagerId').val(null);
        });
        $('#getFileManager').click(function () {
            $.ajax({
                url: "{{ url('/file/show') }}",
                success: function (data) {
                    if (!$.trim($('#fileManagerContainer').html()))
                        $('#fileManagerContainer').html(data);

                    $('#fileManagerModal').modal('show');
                    $('#fileManagerModal #file_upload_type').val("campaigns")

                    setSelectedItemsCB(getSelectedItem, $('#fileManagerId').val() == '' ? [] : [$('#fileManagerId').val()], false);
                }
            })
        });
        $('#getCreativesManger').click(function() {
            $.ajax({
                url: "{{ url('/file/show') }}",
                success: function (data) {
                    if (!$.trim($('#creativesManagerContainer').html()))
                        $('#creativesManagerContainer').html(data);

                    $('#creativesManagerContainer #fileManagerModal').modal('show');
                    $('#creativesManagerContainer #fileManagerModal #file_upload_type').val("campaigns")

                    setSelectedItemsCB(getSelectedCreatives, $('#creatives_list').val() == '' ? [] : $('#creatives_list').val().split(','), true);
                }
            })
        });
    </script>
@endsection
