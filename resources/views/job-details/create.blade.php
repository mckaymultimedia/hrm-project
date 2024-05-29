@php
    $chatgpt = Utility::getValByName('enable_chatgpt');
@endphp

<form action="{{ route('job-details.store') }}" method="POST">
    @csrf
<div class="modal-body">

    @if ($chatgpt == 'on')
    <div class="text-end">
        <a href="#" class="btn btn-sm btn-primary" data-size="medium" data-ajax-popup-over="true" data-url="{{ route('generate', ['account-assets']) }}"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}"
            data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i>{{ __(' Generate With AI') }}
        </a>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            @php 
                $users = \App\Models\Employee::where('department_id', 4)->get();
    
            @endphp
            <div class="form-group">
                <label for="user_id" class="form-label">{{ __('Job Applied') }}  <span class="text-danger">*</span></label>
              
              <select class="form-control"  name="user_id" 
                id="choices-multiple" placeholder="Select profile" required>
                <option value="" >Select profile

                </option>
                @foreach ($users as $jobProfile)
                    <option value="{{ $jobProfile->id }}">{{ $jobProfile->name }}</option>
                @endforeach
            </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="Profile" class="form-label">{{ __('Profile') }}  <span class="text-danger">*</span></label>
                <select class="form-control  designation_id select2"  name="profile" 
                id="choices-multiple" placeholder="Select profile" required>
                <option value="" >Select profile</option>
                @foreach ($jobProfiles as $jobProfile)
                    <option value="{{ $jobProfile->id }}">{{ $jobProfile->profile_name }}</option>
                @endforeach
            </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="plateform" class="form-label">{{ __('Plateform') }}</label>
                <input type="text" id="plateform" class="form-control" placeholder="{{ __('Enter Plateform') }}" required name="platform">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('rate', __('Rate'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <input type="number" name="rate" id="rate" class="form-control" placeholder="{{ __('Enter Rate') }}" required>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="location" class="form-label">{{ __('Location') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="location" class="form-control" placeholder="{{ __('Enter Location') }}" name="location"  required>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="stack" class="form-label">{{ __('Stack') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="stack" class="form-control" placeholder="{{ __('Enter Stack') }}" name="stack"  required>
                </div>
            </div>
        </div>   
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="link" class="form-label">{{ __('Link') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="link" class="form-control" placeholder="{{ __('Enter Link') }}" name="link"  required>
                </div>
            </div>   
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="client" class="form-label">{{ __('Client') }}</label>
                <div class="form-icon-user">
                    <select id="client" class="form-control" name="client"  required>
                        <option value="">{{ __('Select Client') }}</option>
                        <option value="old">{{ __('Old') }}</option>
                        <option value="new">{{ __('New') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('applied_at', __('Applied At'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                <input type="date" name="applied_at" id="applied_at" class="form-control d_week current_date" required>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="payment_type" class="form-label
                ">{{ __('Payment Type') }}</label>
                <div class="form-icon-user">
                    <select id="payment_type" class="form-control" name="payment_type">
                        <option value="">{{ __('Select Payment Type') }}</option>
                        <option value="varified">{{ __('Varified') }}</option>
                        <option value="not_varified">{{ __('Not Varified') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="status" class="form-label">{{ __('Status') }}</label>
                <div class="form-icon-user">
                    <select id="status" class="form-control" name="status"  required>
                        <option value="1" selected>{{ __('Pending') }}</option>
                        <option value="2">{{ __('Accepted') }}</option>
                        <option value="3">{{ __('Rejected') }}</option>
                    </select>
                </div>
            </div>
            
        


    </div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script>
    $(document).ready(function() {
        var now = new Date();
        var month = (now.getMonth() + 1);
        var day = now.getDate();
        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;
        $('.current_date').val(today);
    });
</script>