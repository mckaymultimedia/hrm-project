{{ Form::open(['route' => 'indicator.month.store', 'method' => 'post', 'id' => 'indicator_form']) }}

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
                    <div class="form-check form-check-inline" onclick="showDescription('very_dissatisfactory')">
                        <input class="form-check-input" type="checkbox" id="very_dissatisfactory" name="very_dissatisfactory" value="1">
                        <label class="form-check-label font-medium cursor-pointer"
                        for="very_dissatisfactory" >Very Dissatisfactory</label>
                    </div>
                    <div class="form-check form-check-inline" onclick="showDescription('dissatisfactory')">
                        <input class="form-check-input" type="checkbox" id="dissatisfactory" name="dissatisfactory" value="1">
                        <label class="form-check-label font-medium cursor-pointer" for="dissatisfactory">Dissatisfactory</label>
                    </div>
                    <div class="form-check form-check-inline" onclick="showDescription('neutral')">
                        <input class="form-check-input" type="checkbox" id="neutral" name="neutral" value="1">
                        <label class="form-check-label font-medium cursor-pointer" for="neutral">Neutral</label>
                    </div>
                    <div class="form-check form-check-inline" onclick="showDescription('satisfactory')">
                        <input class="form-check-input" type="checkbox" id="satisfactory" name="satisfactory" value="1">
                        <label class="form-check-label font-medium cursor-pointer" for="satisfactory">Satisfactory</label>
                    </div>
    
                    <div class="form-check form-check-inline" onclick="showDescription('very_satisfactory')">
                        <input class="form-check-input" type="checkbox" id="very_satisfactory" name="very_satisfactory" value="1">
                        <label class="form-check-label font-medium cursor-pointer" for="very_satisfactory">Very Satisfactory</label>
                    </div>
                    <div class="form-group col-md-6 p-2 very_dissatisfactory_description" style="display: none;">
                       <label for="very_dissatisfactory_description">
                        Very dissatisfactory Description
                       </label>
                          <textarea name="very_dissatisfactory_description" id="" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group col-md-6 p-2 dissatisfactory_description" style="display: none;">
                        <label for="dissatisfactory_description">Dissatisfactory </label>
                        <textarea name="dissatisfactory_description"  class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group col-md-6 p-2 neutral_description" style="display: none;">
                        <label for="neutral_description">Neutral </label>
                        <textarea name="neutral_description"  class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group col-md-6 p-2 satisfactory_description" style="display: none;">
                        <label for="satisfactory_description">Satisfactory </label>
                        <textarea name="satisfactory_description" id="" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group col-md-6 p-2 very_satisfactory_description" style="display: none;">
                        <label for="very_satisfactory_description">Very Satisfactory </label>
                        <textarea name="very_satisfactory_description" id="" class="form-control" placeholder="Description"></textarea>
                    </div>

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