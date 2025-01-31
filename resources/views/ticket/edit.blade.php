@php
    $chatgpt = Utility::getValByName('enable_chatgpt');
   
@endphp

{{ Form::model($ticket, ['route' => ['ticket.update', $ticket->id], 'method' => 'PUT']) }}
<div class="modal-body">

    @if ($chatgpt == 'on')
    <div class="text-end">
        <a href="#" class="btn btn-sm btn-primary" data-size="medium" data-ajax-popup-over="true" data-url="{{ route('generate', ['ticket']) }}"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}"
            data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i>{{ __(' Generate With AI') }}
        </a>
    </div>
    @endif

    <div class="row">
        <div class="form-group">
            {{ Form::label('title', __('Subject'), ['class' => 'col-form-label']) }}
            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Ticket Subject')]) }}
        </div>
        <div class="form-group">
            {{ Form::label('type', __('Type'), ['class' => 'col-form-label']) }}
            <select name="type"  class="form-control  select2" id="type">
                <option value="maintenance" @if ($ticket->type == 'maintenance') selected @endif>{{ __('Equipment Maintenance') }}</option>
                <option value="new_equipment" @if ($ticket->type == 'new_equipment') selected @endif>{{ __('New Equipment Request') }}</option>
                <option value="overtime"@if ($ticket->type == 'overtime') selected @endif>{{ __('Overtime Request') }}</option>
                <option value="work_from_home"@if ($ticket->type == 'work_from_home') selected @endif>{{ __('WFH Request') }}</option>
                <option value="other"@if ($ticket->type == 'other') selected @endif>{{ __('other') }}</option>
            </select>
        </div>
        @if (\Auth::user()->type != 'employee')
            <div class="form-group">
                {{ Form::label('employee_id', __('Ticket for Employee'), ['class' => 'col-form-label']) }}
                {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select2']) }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                <div class="form-group">
                    {{ Form::label('priority', __('Priority'), ['class' => 'col-form-label']) }}
                    <select name="priority" class="form-control select2" id="choices-multiple">
                        <option value="low" @if ($ticket->priority == 'low') selected @endif>{{ __('Low') }}
                        </option>
                        <option value="medium" @if ($ticket->priority == 'medium') selected @endif>{{ __('Medium') }}
                        </option>
                        <option value="high" @if ($ticket->priority == 'high') selected @endif>{{ __('High') }}
                        </option>
                        <option value="critical" @if ($ticket->priority == 'critical') selected @endif>
                            {{ __('critical') }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                <div class="form-group">
                    {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}
                    {{ Form::text('end_date', null, ['class' => 'form-control d_week','autocomplete'=>'off']) }}
                </div>
            </div>
        </div>


        <div class="form-group">
            {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Ticket Description'),'rows'=>'3']) }}
        </div>
        @if (\Auth::user()->type != 'employee')
        <div class="form-group">
            {{ Form::label('status', __('Status'), ['class' => 'col-form-label']) }}
            <select name="status"  class="form-control  select2" id="status">
                <option value="close" @if ($ticket->status == 'close') selected @endif>{{ __('Close') }}</option>
                <option value="open" @if ($ticket->status == 'open') selected @endif>{{ __('Open') }}</option>
                <option value="onhold" @if ($ticket->status == 'onhold') selected @endif>{{ __('On Hold') }}</option>
            </select>
        </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">

</div>
{{ Form::close() }}
