{{ Form::open(['route' => 'indicator.store', 'method' => 'post' , 'id' => 'indicator_form']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <p style="font-weight: 700">Indicator Title:</p>
            <div class="form-group">
                {{ Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>

            
            {{-- <div class="form-group">
                {{ Form::label('branch', __('Branch'), ['class' => 'col-form-label']) }}
                {{ Form::select('branch', $brances, null, ['class' => 'form-control select2 branch_id', 'required' => 'required']) }}
            </div> --}}
        </div>
        <div class="col-md-12 mt-2 mb-2 d-none">
            <p style="font-weight: 700">Choose duration:</p>
           
                <div class="d-flex   gap-12 ">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="first_month" name="first_month" value="1" checked>
                        <label class="form-check-label font-medium cursor-pointer"
                         for="first_month">First Month</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="six_month" name="six_month" value="1">
                        <label class="form-check-label font-medium  cursor-pointer" for="six_month">Six Month</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="year" name="year" value="1">
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
                    <input class="form-check-input" type="checkbox" id="unsatisfactory" name="unsatisfactory" value="1">
                    <label class="form-check-label font-medium cursor-pointer"
                    for="unsatisfactory">UNSATISFACTORY</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="average" name="average" value="1">
                    <label class="form-check-label font-medium cursor-pointer" for="average">AVERAGE</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="above_average" name="above_average" value="1">
                    <label class="form-check-label font-medium cursor-pointer" for="above_average">ABOVE AVERAGE</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="not_applicable" name="not_applicable" value="1">
                    <label class="form-check-label font-medium cursor-pointer" for="not_applicable">NOT APPLICABLE</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="not_observed" name="not_observed" value="1">
                    <label class="form-check-label font-medium cursor-pointer" for="not_observed">NOT OBSERVED</label>
                </div>
            </div>
        </div>
    {{-- <div class="row">
        @foreach ($performance_types as $performance_type)
        
            <div class="col-md-12 mt-3">
                <h6>{{ $performance_type->name }}</h6>
                <hr class="mt-0">
            </div>

            @foreach ($performance_type->types as $types)
                <div class="col-6">
                    {{ $types->name }}
                </div>
                <div class="col-6">
                    <fieldset id='demo1' class="rate">
                        <input class="stars" type="radio" id="technical-5-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="5" />
                        <label class="full" for="technical-5-{{ $types->id }}"
                            title="Awesome - 5 stars"></label>
                        <input class="stars" type="radio" id="technical-4-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="4" />
                        <label class="full" for="technical-4-{{ $types->id }}"
                            title="Pretty good - 4 stars"></label>
                        <input class="stars" type="radio" id="technical-3-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="3" />
                        <label class="full" for="technical-3-{{ $types->id }}"
                            title="Meh - 3 stars"></label>
                        <input class="stars" type="radio" id="technical-2-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="2" />
                        <label class="full" for="technical-2-{{ $types->id }}"
                            title="Kinda bad - 2 stars"></label>
                        <input class="stars" type="radio" id="technical-1-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="1" />
                        <label class="full" for="technical-1-{{ $types->id }}"
                            title="Sucks big time - 1 star"></label>
                    </fieldset>
                </div>
            @endforeach
        @endforeach
    </div> --}}
</div>

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input onclick="updateDurationInputValue();" value="{{ __('Create') }}" class="btn btn-primary">
</div>

{{ Form::close() }}
{{-- </div> --}}
<script>
    function updateDurationInputValue(){
        var first_month = document.getElementById('first_month').checked;
        var six_month = document.getElementById('six_month').checked;
        var year = document.getElementById('year').checked;
    
        if(!first_month && !six_month && !year){
            document.getElementById('duration_error').innerText = 'Please select at least one.';
            return;
        }
        var form = document.getElementById('indicator_form');
        form.submit();
    }
</script>
