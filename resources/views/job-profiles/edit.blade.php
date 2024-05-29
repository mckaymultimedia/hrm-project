@php
    $chatgpt = Utility::getValByName('enable_chatgpt');
@endphp

<form action="{{ route('job-profile.update', $jobProfile->id) }}" method="POST">
        @csrf
<form class="modal-body">

  

    <div class="row p-4">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('profile', __('Profile'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <input type="text" name="profile_name" id="profile" class="form-control" placeholder="{{ __('Enter Profile') }}" value="{{$jobProfile->profile_name}}">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="stack" class="form-label">{{ __('Stack') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="stack" class="form-control" placeholder="{{ __('Enter Stack') }}" name="stack" required value="{{$jobProfile->stack}}">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="platform" class="form-label">{{ __('Source (Platform)') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="platform" class="form-control" placeholder="{{ __('Enter Platform') }}" name="platform" required value="{{$jobProfile->platform}}" required>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <div class="form-icon-user">
                    <input type="email" id="email" class="form-control" placeholder="{{ __('Enter Email') }}" name="email" required value="{{$jobProfile->email}}" required >
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="contact" class="form-label">{{ __('Contact Number') }}</label>
                <div class="form-icon-user">
                    <input type="number" id="contact" class="form-control" placeholder="{{ __('Enter contact') }}" name="contact" required value="{{$jobProfile->contact}}">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="github" class="form-label">{{ __('Github') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="github" class="form-control" placeholder="{{ __('Enter github') }}" name="github" required value="{{$jobProfile->github}}">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label for="linkdin" class="form-label">{{ __('Linkdin') }}</label>
                <div class="form-icon-user">
                    <input type="text" id="linkdin" class="form-control" placeholder="{{ __('Enter linkdin') }}" name="linkdin" required value="{{$jobProfile->linkdin}}">
                </div>
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