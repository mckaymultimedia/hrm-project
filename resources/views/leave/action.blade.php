{{ Form::open(['url' => 'leave/changeaction', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <table class="table" id="pc-dt-simple">
                @if($leave->leave_type_id == 1 && $leave->tl_approve == 0 && \Auth::user()->type == 'hr')
                <p class="show_alert_msg">Need to approved by lead first. </p>
                @endif
                <tr role="row">
                    <th>{{ __('Employee') }}</th>
                    <td>{{ !empty($employee->name) ? $employee->name : '' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Leave Type ') }}</th>
                    <td>{{ !empty($leavetype->title) ? $leavetype->title : '' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Appplied On') }}</th>
                    <td>{{ \Auth::user()->dateFormat($leave->applied_on) }}</td>
                </tr>
                <tr>
                    <th>{{ __('Start Date') }}</th>
                    <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
                </tr>
                <tr>
                    <th>{{ __('End Date') }}</th>
                    <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>
                </tr>
                <tr>
                    <th>{{ __('Leave Reason') }}</th>
                    <td>{{ !empty($leave->leave_reason) ? $leave->leave_reason : '' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Status') }}</th>
                    <td>{{ !empty($leave->status) ? $leave->status : '' }}</td>
                </tr>
                <input type="hidden" value="{{ $leave->id }}" name="leave_id">
            </table>
            {{--  {{ dd($request['status']) }}  --}}
            <div class="mb-3">
                <label for="rejectreason" class="form-label"><b>Remarks</b></label>
                <textarea class="form-control" id="rejectreason" name="rejectreason" rows="3"></textarea>
            </div>
        </div>
    </div>
</div>
{{-- <div class="col-12">
    <input type="submit" class="btn-create badge-success" value="{{ __('Approval') }}" name="status">
    <input type="submit" class="btn-create bg-danger" value="{{ __('Reject') }}" name="status">
</div> --}}

@if ($leave->status == 'Pending')
    <div class="modal-footer">
        <input type="submit" value="{{ __('Approved') }}" class="btn btn-success rounded" name="status">
        <input type="submit" value="{{ __('Reject') }}" class="btn btn-danger rounded" name="status">
    </div>
@elseif ($leave->status !== 'Pending' && $leave->tl_approve == 1 && $leave->manager_approve == 0)
    <div class="modal-footer">
        <input type="submit" value="{{ __('Approved') }}" class="btn btn-success rounded" name="status">
        <input type="submit" value="{{ __('Reject') }}" class="btn btn-danger rounded" name="status">
    </div>
@endif

{{ Form::close() }}
