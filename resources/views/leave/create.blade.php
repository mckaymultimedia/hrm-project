{{ Form::open(['url' => 'leave', 'method' => 'post']) }}
<div class="modal-body">
    <div id="alertContainer"></div>
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
                <label class="form-label"><b>Select Time Off Type</b><span class="span">*</span></label>
                <select name="leave_type_id" id="leave_type_id" class="form-control select" required>
                    @foreach ($leavetypes as $leave)
                        @if ($leave->earn_type > 0)
                            <option value="earn_type-{{ $leave->earn_type }}" selected>Earn {{ $leave->earn_type }}
                            </option>
                        @endif
                        @if ($leave->sick_type > 0)
                            <option value="sick_type-{{ $leave->sick_type }}">Sick {{ $leave->sick_type }}</option>
                        @endif
                        @if ($leave->earn_type == 0 && $leave->sick_type == 0)
                            <option value="">{{ __('No Leaves') }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-md-10" style="padding-right: 0;">
                    <div style="display: unset !important;" class="input-group">
                        <label class="form-label"><b>Select Time Off Period
                            </b><span class="span">*</span></label>
                        <div class="merge-icon">

                            <input type="text" name="daterange" class="datePick" />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2" style="padding-left: 10;">
                    <p style="margin-top: 30px;" class="mb-0">Total-
                        <b><span id="totalDays"></span><span id="dayText"></span></b>
                    </p>
                    <input type="hidden" id="totalDay" name="days">
                </div>
                <div id="leaveTypeErrorMessage" class="text-danger"></div>
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('Plan') }}<span class="span">*</span></label>
                <select name="leave" id="leave" class="form-control select" >
                    <option value="full">Full</option>
                    <option value="1st_half">1st Half</option>
                    <option value="2nd_half">2nd Half</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="leave_reason" class="col-form-label">{{ __('Leave Reason') }}<span
                        class="span">*</span></label>
                {{ Form::textarea('leave_reason', null, ['class' => 'form-control', 'placeholder' => __('Leave Reason'), 'rows' => '3', 'required' => 'required']) }}
            </div>
        </div>
    </div>
    <div class="row d-none">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('remark', __('Remark'), ['class' => 'col-form-label']) }}

                {{ Form::textarea('remark', null, ['class' => 'form-control grammer_textarea', 'placeholder' => __('Leave Remark'), 'rows' => '3']) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button id="createBTN" class="btn  btn-primary" onclick="applyleavevalidation()">{{ __('Create') }}</button>
</div>
{{ Form::close() }}

<style>
    .datePick {
        display: block;
        width: 90%;
        padding: 10px 14px;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1.5;
        color: #293240;
        background-color: #ffffff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        appearance: none;
        /* border-radius: 6px; */
        border-top-left-radius: 4px !important;
        border-bottom-left-radius: 4px !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .input-group-text {
        height: 43px;
        border-radius: 0 6px 6px 0;

    }

    .span {
        color: red
    }

    .merge-icon {
        display: flex;
        align-items: center;
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function getNumberFromString(str) {
        let num = '';
        for (let i = 0; i < str.length; i++) {
            if (!isNaN(parseInt(str[i]))) {
                num += str[i];
            }
        }
        return num;
    }

    function checkLeaveBalance(totalDays, leaveType) {
        if (leaveType == '') {
            return true;
        }

        if (totalDays > leaveType) {
            return false;
        }

        return true;
    }

    $(function() {
        var leaveTypeSelect = $('#leave_type_id');
        var leaveSelect = $('#leave');

        datepicker = $('input[name="daterange"]').daterangepicker({
            opens: 'right',
            startDate: new Date(),
            locale: {
                format: 'DD MMM ddd, YYYY',
            },
            minDate: moment().startOf('day') // today
        }, function(start, end, label) {

            var totalDays = end.diff(start, 'days') + 1;
            $('#totalDay').val(totalDays);
            $('#totalDays').text(totalDays);

            if (totalDays == 1 || totalDays == 0.5) {
                $('#dayText').text(' Day');
            } else {
                $('#dayText').text(' Days');
            }

            if (totalDays > 1) {
                leaveSelect.prop('disabled', true);
                $('#leave').val('full');
            } else {
                leaveSelect.prop('disabled', false);
            }
            validateLeaveBalance(totalDays);
        });

        leaveSelect.on('change', function() {
            var selectedPlan = $(this).val();
            if (selectedPlan == '1st_half' || selectedPlan === '2nd_half') {
                // console.log('half');
                $('#totalDays').text('0.5');
                $('#totalDay').val(0.5);
            } else if (selectedPlan == 'full') {
                // console.log('full');
                $('#totalDays').text('1');
                $('#totalDay').val(1);
            }
        });

        leaveTypeSelect.on('change', function() {
            if (datepicker) {
                datepicker.data('daterangepicker').setStartDate(new Date());
                datepicker.data('daterangepicker').setEndDate(new Date());

                $('#totalDays').text('1');
                $('#totalDay').val(1);
                $('#dayText').text(' Day');
                $('#leaveTypeErrorMessage').text('');
            }
        });

        function validateLeaveBalance(totalDays) {
            var selectedLeaveType = leaveTypeSelect.val();
            var getNum = getNumberFromString(selectedLeaveType);
            var isSufficient = checkLeaveBalance(totalDays, getNum);

            if (!isSufficient) {
                $('#leaveTypeErrorMessage').text('Leave balance is insufficient!');
            } else {
                $('#leaveTypeErrorMessage').text('');
                $('#alertContainer').html('');
            }
        }



        var startDate = datepicker.data('daterangepicker').startDate;
        var endDate = datepicker.data('daterangepicker').endDate;
        var label = datepicker.data('daterangepicker').chosenLabel;
        datepicker.data('daterangepicker').callback(startDate, endDate, label);
    });


    function applyleavevalidation() {
        event.preventDefault();
        //check if the user aply the leave more than the earn leave error return kre other wise submit kr da
        var leaveTypeSelect = $('#leave_type_id');
        var leaveSelect = $('#leave');
        console.log(leaveSelect.val());
        var totalDays = $('#totalDay').val();
        console.log(totalDays);
        var selectedLeaveType = leaveTypeSelect.val();
        var getNum = getNumberFromString(selectedLeaveType);
        var isSufficient = checkLeaveBalance(totalDays, getNum);
        var selectedPlan = leaveSelect.val();

        if (!isSufficient) {
            $('#leaveTypeErrorMessage').text('Leave balance is insufficient!');
            var alertHtml = '<div class="alert alert-danger" role="alert">Leave balance is insufficient!</div>';
            $('#alertContainer').html(alertHtml);
        } else if (totalDays > 1 && selectedPlan != 'full') {
            var alertHtml =
                '<div class="alert alert-danger" role="alert">You can only select full day for more than 1 day leave!</div>';
            $('#alertContainer').html(alertHtml);
        } else {
            $('#leaveTypeErrorMessage').text('');
            $('#alertContainer').html('');
            $('form').submit();
        }
    }
</script>
