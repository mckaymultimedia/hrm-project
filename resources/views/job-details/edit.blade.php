@php
    $chatgpt = Utility::getValByName('enable_chatgpt');
@endphp

<form action="{{ route('job-details.update', $jobDetail->id) }}" method="POST">
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
              {{ Form::label('job_applied', __('Job Applied'), ['class' => 'form-label']) }}
              <select class="form-control"  name="user_id" 
                id="choices-multiple" placeholder="Select profile" required>
                <option value="" >Select profile</option>
                @foreach ($users as $jobProfile)
                    <option value="{{ $jobProfile->id }}" @if ($jobProfile->id == $jobDetail->user_id) selected @endif>
                        {{ $jobProfile->name }}</option>
                @endforeach
            </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('profile', __('Profile'), ['class' => 'form-label' ]) }}
                <select class="form-control  designation_id select2"  name="profile" 
                id="choices-multiple" placeholder="Select profile" required>
                <option value="" >Select profile</option>
                @foreach ($jobProfiles as $jobProfile)
                    <option value="{{ $jobProfile->id }}" @if ($jobProfile->id == $jobDetail->profile) selected @endif>{{ $jobProfile->profile_name }}</option>
                @endforeach
            </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="plateform" class="form-label">{{ __('Plateform') }}</label>
                <input type="text" id="plateform" class="form-control" placeholder="{{ __('Enter Plateform') }}" name="platform"  required value="{{ $jobDetail->platform }}">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('rate', __('Rate'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <input type="number" name="rate" id="rate" class="form-control" placeholder="{{ __('Enter Rate') }}"  required value="{{ $jobDetail->rate }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="location" class="form-label">{{ __('Location') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="location" class="form-control" placeholder="{{ __('Enter Location') }}" name="location"  required value="{{ $jobDetail->location }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="stack" class="form-label">{{ __('Stack') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="stack" class="form-control" placeholder="{{ __('Enter Stack') }}" name="stack"  required value="{{ $jobDetail->stack }}">
                </div>
            </div>
        </div>   
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="link" class="form-label">{{ __('Link') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="link" class="form-control" placeholder="{{ __('Enter Link') }}" name="link"  required value="{{ $jobDetail->link }}">
                </div>
            </div>   
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="client" class="form-label">{{ __('Client') }}</label>
                <div class="form-icon-user">
                    <select id="client" class="form-control" name="client"  required>
                        <option value="old" @if ($jobDetail->client_type == 'old') selected @endif>{{ __('Old') }}</option>
                        <option value="new" @if ($jobDetail->client_type == 'new') selected @endif>{{ __('New') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('applied_at', __('Applied At'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
            <span>{{$jobDetail->applied_at}}</span>
                    <input type="date" name="applied_at" id="applied_at" class="form-control d_week " required value="{{ $jobDetail->applied_at }}">
        </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="payment_type" class="form-label
                ">{{ __('Payment Type') }}</label>
                <div class="form-icon-user">
                    <select id="payment_type" class="form-control" name="payment_type">
                        <option value="varified" @if ($jobDetail->payment_type == 'varified') selected @endif>{{ __('Varified') }}</option>
                        <option value="not_varified" @if ($jobDetail->payment_type == 'not_varified') selected @endif>{{ __('Not Varified') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="status" class="form-label">{{ __('Status') }}</label>
                <div class="form-icon-user">
                    <select id="status" class="form-control" name="status"  required>
                        <option value="1" @if ($jobDetail->status == 1) selected @endif>{{ __('Pending') }}</option>
                        <option value="2" @if ($jobDetail->status == 2) selected @endif>{{ __('Accepted') }}</option>
                        <option value="3" @if ($jobDetail->status == 3) selected @endif>{{ __('Rejected') }}</option>
                    </select>
                </div>
            </div>
            
    </div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
</form>

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