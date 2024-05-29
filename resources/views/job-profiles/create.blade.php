@php
    $chatgpt = Utility::getValByName('enable_chatgpt');
@endphp

<form action="{{ route('job-profile.store') }}" method="POST">
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
            <div class="form-group">
                <label for="profile" class="form-label">{{ __('Profile') }} <span class="text-danger">*</span></label>
                <div class="form-icon-user">
                    <input type="text" name="profile_name" id="profile" class="form-control" placeholder="{{ __('Enter Profile Name') }}" required>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="platform" class="form-label">{{ __('Source (Platform)') }}<span class="text-danger">*</span></label>
                <div class="form-icon-user">
                    <input type="text" id="platform" class="form-control" placeholder="{{ __('Enter Platform') }}" name="platform" required>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}<span class="text-danger">*</span></label></label>
                <div class="form-icon-user">
                    <input type="text" id="email" class="form-control" placeholder="{{ __('Enter Email') }}" name="email" required>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="stack" class="form-label">{{ __('Stack') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="stack" class="form-control" placeholder="{{ __('Enter Stack') }}" name="stack">
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="contact" class="form-label">{{ __('Contact Number') }}</label>
                <div class="form-icon-user">
                    <input type="number" id="contact" class="form-control" placeholder="{{ __('Enter Contact') }}" name="contact" >
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="github" class="form-label">{{ __('Github') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="github" class="form-control" placeholder="{{ __('Enter Github') }}" name="github" >
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="linkdin" class="form-label">{{ __('Linkdin') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="linkdin" class="form-control" placeholder="{{ __('Enter Linkdin') }}" name="linkdin" >
                </div>
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