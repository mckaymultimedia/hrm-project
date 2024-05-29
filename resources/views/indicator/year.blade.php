{{ Form::open(['route' => 'indicator.year.store', 'method' => 'post', 'id' => 'indicator_form']) }}

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <p style="font-weight: 700">Indicator Title<span class="text-danger">*</span>
                </span>
            </p>
            <div class="form-group">
                {{ Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <div class="col-md-12 mb-4">
                <p style="font-weight: 700">Options:</p>
                <div class="d-flex gap-12 flex-wrap">
                    <div class="form-check form-check-inline" onclick="showDescription('unsatisfactory')">
                        <input class="form-check-input" type="checkbox" id="unsatisfactory" name="unsatisfactory" value="1">
                        <label class="form-check-label font-medium cursor-pointer"
                        for="unsatisfactory" >Unsatisfactory</label>
                    </div>
                    <div class="form-check form-check-inline" onclick="showDescription('less_than_satisfactory')">
                        <input class="form-check-input" type="checkbox" id="less_than_satisfactory" name="less_than_satisfactory" value="1">
                        <label class="form-check-label font-medium cursor-pointer" for="less_than_satisfactory">Less than satisfactory</label>
                    </div>
                    <div class="form-check form-check-inline" onclick="showDescription('full_satisfactory')">
                        <input class="form-check-input" type="checkbox" id="full_satisfactory" name="full_satisfactory" value="1">
                        <label class="form-check-label font-medium cursor-pointer" for="full_satisfactory">Full satisfactory</label>
                    </div>
                    <div class="form-check form-check-inline" onclick="showDescription('excellent')">
                        <input class="form-check-input" type="checkbox" id="excellent" name="excellent" value="1">
                        <label class="form-check-label font-medium cursor-pointer" for="excellent">Excellent</label>
                    </div>
    
                    <div class="form-check form-check-inline" onclick="showDescription('outstanding')">
                        <input class="form-check-input" type="checkbox" id="outstanding" name="outstanding" value="1">
                        <label class="form-check-label font-medium cursor-pointer" for="outstanding">Outstanding</label>
                    </div>
                    <div class="form-group col-md-6 p-2 unsatisfactory_description" style="display: none;">
                       <label for="unsatisfactory_description">
                        Unsatisfactory Description
                       </label>
                          <textarea name="unsatisfactory_description" id="" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group col-md-6 p-2 less_than_satisfactory_description" style="display: none;">
                        <label for="less_than_satisfactory_description">Less than satisfactory </label>
                        <textarea name="less_than_satisfactory_description"  class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group col-md-6 p-2 full_satisfactory_description" style="display: none;">
                        <label for="full_satisfactory_description">Full satisfactory </label>
                        <textarea name="full_satisfactory_description"  class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group col-md-6 p-2 excellent_description" style="display: none;">
                        <label for="excellent_description">Excellent </label>
                        <textarea name="excellent_description" id="" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group col-md-6 p-2 outstanding_description" style="display: none;">
                        <label for="outstanding_description">Outstanding </label>
                        <textarea name="outstanding_description" id="" class="form-control" placeholder="Description"></textarea>
                    </div>

            </div>
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }} <span class="text-danger">*</span>
                {{ Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
    
</div>

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
    
</div>

{{ Form::close() }}
{{-- </div> --}}
<script>
    function showDescription(id) {
        var checkbox = $('#' + id);
        var description = $('.' + id + '_description');
        console.log(description);
        
        if (checkbox.is(':checked')) {
            description.show();
        } else {
            description.hide();
        }
    }

    $(document).ready(function() {
        $('.form-check-input').click(function() {
            var id = $(this).attr('id');
            showDescription(id);
        });
    });
</script>