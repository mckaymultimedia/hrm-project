{{ Form::model($leave, ['route' => ['leave.update', $leave->id], 'method' => 'PUT']) }}<div class="modal-body">

    @if (\Auth::user()->type != 'employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label']) }}
                    {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => __('Select Employee')]) }}
                </div>
            </div>
        </div>
    @else
        {{-- @foreach ($employees as $employee) --}}
        {!! Form::hidden('employee_id', !empty($employees) ? $employees->id : 0, ['id' => 'employee_id']) !!}
        {{-- @endforeach --}}
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('leave_type_id', __('Leave Type'), ['class' => 'col-form-label']) }}
                <select name="leave_type_id" id="leave_type_id" class="form-control select" required>
                    <option value="">{{ __('Select Leave Type') }}</option>
                    @foreach ($leavetypes as $leave)
                        @if ($leave->earn_type - $earntypes_days > 0)
                            <option value="earn_type">Earn {{ $leave->earn_type - $earntypes_days }}</option>
                        @endif
                        @if ($leave->sick_type - $sicktypes_days > 0)
                            <option value="sick_type">Sick {{ $leave->sick_type - $sicktypes_days }}</option>
                        @endif
                        @if ($leave->earn_type - $earntypes_days == 0 && $leave->sick_type - $sicktypes_days == 0)
                            <option value="">{{ __('No Leaves') }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}


                {{ Form::text('start_date', null, ['class' => 'form-control d_week current_date datepicker', 'autocomplete' => 'off', 'placeholder' => 'Select start date']) }}
                <span id="dateError" class="text-danger"></span>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('end_date', null, ['class' => 'form-control d_week current_date datepicker', 'autocomplete' => 'off', 'placeholder' => 'Select end date']) }}
                <span id="dateError" class="text-danger"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">{{ __('Plan') }}</label>
                <select name="leave" id="leave" class="form-control select">
                    <option value="">{{ __('Select Leave') }}</option>
                    <option value="full">Full</option>
                    <option value="1st_half">1st Half</option>
                    <option value="2nd_half">2nd Half</option>
                </select>
            </div>
            <div class="form-group">
                {{ Form::label('leave_reason', __('Leave Reason'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('leave_reason', null, ['class' => 'form-control', 'placeholder' => __('Leave Reason'), 'rows' => '3', 'required' => 'required']) }}
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('remark', __('Remark'), ['class' => 'col-form-label']) }}

                {{ Form::textarea('remark', null, ['class' => 'form-control grammer_textarea', 'placeholder' => __('Leave Remark'), 'rows' => '3']) }}
            </div>
        </div>
    </div>
    @role('Company')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('status', __('Status'), ['class' => 'col-form-label']) }}
                    <select name="status" id="" class="form-control select2">
                        <option value="">{{ __('Select Status') }}</option>
                        <option value="pending" @if ($leave->status == 'Pending') selected="" @endif>{{ __('Pending') }}
                        </option>
                        <option value="approval" @if ($leave->status == 'Approval') selected="" @endif>{{ __('Approval') }}
                        </option>
                        <option value="reject" @if ($leave->status == 'Reject') selected="" @endif>{{ __('Reject') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    @endrole
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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

<script>
    $(document).ready(function() {
        $('#leave, #start_date, #end_date').on('change', function() {
            validateSameDates();
        });

        function validateSameDates() {
            var selectedLeave = $('#leave').val();
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var dateError = $('#dateError');

            if (selectedLeave === '1st_half' || selectedLeave === '2nd_half') {
                if (startDate !== endDate) {
                    dateError.text('Start date and end date must be the same for 1st Half or 2nd Half.');
                } else {
                    dateError.text('');
                }
            } else {
                dateError.text('');
            }
        }
    });
</script>

<script>
    // $(document).ready(function() {
    //     setTimeout(() => {
    //         var employee_id = $('#employee_id').val();
    //         if (employee_id) {
    //             $('#employee_id').trigger('change');
    //         }
    //     }, 100);
    // });
</script>
