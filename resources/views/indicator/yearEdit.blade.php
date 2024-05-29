{{ Form::open(['route' => ['indicator.year.update', ['id' => $indicator->id]], 'method' => 'post', 'id' => 'indicator_forms']) }}

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <p style="font-weight: 700">Indicator Title<span class="text-danger">*</span>
                </span>
            </p>
            <div class="form-group">
                @php 
                    $title = str_replace('_', ' ', $indicator->title);
                @endphp
                
                <input type="text" name="title" value="{{$title}}" class="form-control" required>
            </div>
            <div class="col-md-12 mb-4">
                <p style="font-weight: 700">Options:</p>
                <div class="d-flex gap-12 flex-wrap">
                    <div class="form-check form-check-inline" onclick="showDescription('unsatisfactory')">
                        <input class="form-check-input" type="checkbox" id="unsatisfactory" name="unsatisfactory" value="1" {{ optional($indicator)->unsatisfactory == 1 ? 'checked' : '' }}>
                        <label class="form-check-label font-medium cursor-pointer"
                        for="unsatisfactory">Unsatisfactory</label>
                    </div>
                    <div class="form-check form-check-inline" onclick="showDescription('less_than_satisfactory')">
                        <input class="form-check-input" type="checkbox" id="less_than_satisfactory" name="less_than_satisfactory" value="1" {{ optional($indicator)->less_than_satisfactory == 1 ? 'checked' : '' }}>
                        <label class="form-check-label font-medium cursor-pointer" for="less_than_satisfactory">Less than satisfactory</label>
                    </div>
                    <div class="form-check form-check-inline" onclick="showDescription('full_satisfactory')">
                        <input class="form-check-input" type="checkbox" id="full_satisfactory" name="full_satisfactory" value="1" {{ optional($indicator)->full_satisfactory == 1 ? 'checked' : '' }}>
                        <label class="form-check-label font-medium cursor-pointer" for="full_satisfactory">Full satisfactory</label>
                    </div>
                    <div class="form-check form-check-inline" onclick="showDescription('excellent')">
                        <input class="form-check-input" type="checkbox" id="excellent" name="excellent" value="1" {{ optional($indicator)->excellent == 1 ? 'checked' : '' }}>
                        <label class="form-check-label font-medium cursor-pointer" for="excellent">Excellent</label>
                    </div>
    
                    <div class="form-check form-check-inline"   onclick="showDescription('outstanding')">
                        <input class="form-check-input" type="checkbox" id="outstanding" name="outstanding" value="1" {{ optional($indicator)->outstanding == 1 ? 'checked' : '' }}>
                        <label class="form-check-label font-medium cursor-pointer" for="outstanding">Outstanding</label>
                    </div>
                    <div class="form-group col-md-6 p-2 unsatisfactory_description" style="display: {{ optional($indicator)->unsatisfactory_description !="" ? 'block' : 'none'}} ">
                        <label for="unsatisfactory_description">
                         Unsatisfactory Description
                        </label>
                           <textarea name="unsatisfactory_description" id="" class="form-control" placeholder="Description">{{ $indicator->unsatisfactory_description }}</textarea>
                     </div>
                     <div class="form-group col-md-6 p-2 less_than_satisfactory_description" style="display: {{ optional($indicator)->less_than_satisfactory !="" ? 'block' : 'none'}} ">
                         <label for="less_than_satisfactory_description">Less than satisfactory </label>
                         <textarea name="less_than_satisfactory_description"  class="form-control" placeholder="Description">{{$indicator->less_than_satisfactory_description}}</textarea>
                     </div>
                     <div class="form-group col-md-6 p-2 full_satisfactory_description" style="display: {{ optional($indicator)->full_satisfactory !="" ? 'block' : 'none'}} ">
                         <label for="full_satisfactory_description">Full satisfactory </label>
                         <textarea name="full_satisfactory_description"  class="form-control" placeholder="Description">{{$indicator->full_satisfactory_description}}</textarea>
                     </div>
                     <div class="form-group col-md-6 p-2 excellent_description" style="display: {{ optional($indicator)->excellent !="" ? 'block' : 'none'}} ">
                         <label for="excellent_description">Excellent </label>
                         <textarea name="excellent_description" id="" class="form-control" placeholder="Description"> {{$indicator->excellent_description}}</textarea>
                     </div>
                     <div class="form-group col-md-6 p-2 outstanding_description" style="display: {{ optional($indicator)->outstanding !="" ? 'block' : 'none'}} ">
                         <label for="outstanding_description">Outstanding </label>
                         <textarea name="outstanding_description" id="" class="form-control" placeholder="Description">{{$indicator->outstanding_description}}</textarea>
                     </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-form-label">Description</label> <span class="text-danger">*</span>
                <textarea name="description" class="form-control  " style="min-height: 130px;" required>{{ $indicator->description }}</textarea>
            </div>
        </div>
    
</div>

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
    
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
