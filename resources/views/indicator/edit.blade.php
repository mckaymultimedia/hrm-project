
{{ Form::model($indicator, ['route' => ['indicator.update', ['id' => $indicator->id]], 'method' => 'post', 'id' => 'indicator_form']) }}

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">    
            <div class="form-group">
                @php 
                    $title = str_replace('_', ' ', $indicator->title);
                @endphp
                {{ Form::label('title', __('Indicator Title'), ['class' => 'col-form-label' ]) }}
                {{ Form::text('title', $title, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-12 mt-4 mb-4 d-none">
            <p style="font-weight: 600">Choose duration:</p>
           
                <div class="d-flex" style="gap: 25px">
                    <div class="d-flex gap-2 ">
                        <input class="form-check-input" type="checkbox" id="first_month" name="first_month" value="1" {{ optional($indicator)->first_month == 1 ? 'checked' : '' }} checked>
                        <label class="form-check-label font-medium cursor-pointer"
                         for="first_month">First Month</label>
                    </div>
                    <div class="d-flex gap-2">
                        <input class="form-check-input" type="checkbox" id="six_month" name="six_month" value="1" {{ optional($indicator)->six_month == 1 ? 'checked' : '' }}>
                        <label class="form-check-label font-medium  cursor-pointer" for="six_month">Six Month</label>
                    </div>
                    <div class="d-flex gap-2">
                        <input class="form-check-input" type="checkbox" id="year" name="year" value="1" {{ optional($indicator)->year == 1 ? 'checked' : '' }}>
                        <label class="form-check-label font-medium cursor-pointer" for="year">Year</label>
                    </div>
                </div>
                <p id="duration_error" class="text-danger mt-2">
                </p>
        </div>
        <div class="col-md-12 mb-4">
            <p style="font-weight: 700">Options:</p>
            <div class="d-flex gap-12 flex-wrap">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="unsatisfactory" name="unsatisfactory" value="1" {{ optional($indicator)->unsatisfactory == 1 ? 'checked' : '' }}>
                    <label class="form-check-label font-medium cursor-pointer"
                    for="unsatisfactory">UNSATISFACTORY</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="average" name="average" value="1" {{ optional($indicator)->average == 1 ? 'checked' : '' }}>
                    <label class="form-check-label font-medium cursor-pointer" for="average">AVERAGE</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="above_average" name="above_average" value="1" {{ optional($indicator)->above_average == 1 ? 'checked' : '' }}>
                    <label class="form-check-label font-medium cursor-pointer" for="above_average">ABOVE AVERAGE</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="not_applicable" name="not_applicable" value="1" {{ optional($indicator)->not_applicable == 1 ? 'checked' : '' }}>
                    <label class="form-check-label font-medium cursor-pointer" for="not_applicable">NOT APPLICABLE</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="not_observed" name="not_observed" value="1" {{ optional($indicator)->not_observed == 1 ? 'checked' : '' }}>
                    <label class="form-check-label font-medium cursor-pointer" for="not_observed">NOT OBSERVED</label>
                </div>
            </div>
        </div>
</div>

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
    {{ Form::close() }}

<script type="text/javascript">

</script>

