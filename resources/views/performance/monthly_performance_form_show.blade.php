<form method="post" action="{{ route('performance.monthly.update',$performance_form->id) }}" enctype="multipart/form-data">

    @csrf
    @php
    $meta = json_decode($performance_form->meta, true);
    
@endphp

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <h6>Monthly Performance Evaluation Form
                </h6>
                <div class="form-group row">
                    <div class=" col-md-6 designation_div">
                        <label for="month" class="col-form-label">Employee<span style="color:red">*</span></label>
                        <select class="form-control  designation_id select2" name="employee_id" id="choices-multiple" onchange="getTeamLead(this.value)" disabled
                              placeholder="Select employee" required>
                              <option value="" >Select employee</option>
                              @foreach ($employees as $employee)
                              <option value="{{ $employee->id }}" {{ $performance_form->employee_id == $employee->id ? 'selected' : '' }}>
                                  {{ $employee->name }}
                              </option>
                          @endforeach
                          </select>
                    </div>


                    <div class="col-md-6">
                        <label for="team_lead" class="col-form-label">Team Lead:<span style="color:red">*</span></label>
                        <input type="text" class="form-control" id="team_lead" name="team_lead" required value="{{ $meta['team_lead'] }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="evaluation_duration" class="col-form-label">Duration of Evaluation:<span
                                style="color:red">*</span></label>
                        <select class="form-control" name="evaluation_duration" required disabled>
                            <option value="monthly">monthly</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="department" class="col-form-label">Department:<span
                                style="color:red">*</span></label>
                        <input type="" class="form-control" name="department" required value="{{ $meta['department'] }}" readonly id="department">
                    </div>
                    @foreach($indicators as $category )
                        <div class="main_class">
                            <h6>{{str_replace('_', ' ', $category->title)}}</h6>
                            
                            <div class="d-flex">
                                    <div class="revenue_growth">
                                        @if($category->very_dissatisfactory == 1)
                                            <input type="radio" name="{{$category->title}}" value="very_dissatisfactory" {{$meta[$category->title] == 'very_dissatisfactory' ? 'checked' : 'disabled'}} >
                                            <strong>Very Dissatisfactory</strong>
                                            <p class="description_font">{{$category->very_dissatisfactory_description}}</p>
                                        @endif
                                    </div>
                                    <div class="revenue_growth">
                                        @if($category->dissatisfactory == 1)
                                            <input type="radio" name="{{$category->title}}" value="dissatisfactory" {{$meta[$category->title] == 'dissatisfactory' ? 'checked' : 'disabled'}} >
                                            <strong>Dissatisfactory</strong>
                                            <p class="description_font">{{$category->dissatisfactory_description}}</p>
                                        @endif
                                    </div>
                                    <div class="revenue_growth">
                                        @if($category->neutral == 1)
                                            <input type="radio" name="{{$category->title}}" value="neutral" {{$meta[$category->title] == 'neutral' ? 'checked' : 'disabled'}} >
                                            <strong>Neutral</strong>
                                            <p class="description_font">{{$category->neutral_description}}</p>
                                        @endif
                                    </div>
                                    <div class="revenue_growth">
                                        @if($category->satisfactory == 1)
                                            <input type="radio" name="{{$category->title}}" value="satisfactory" {{$meta[$category->title] == 'satisfactory' ? 'checked' : 'disabled'}} >
                                            <strong>Satisfactory</strong>
                                            <p class="description_font">{{$category->satisfactory_description}}</p>
                                        @endif
                                    </div>
                                    <div class="revenue_growth">
                                        @if($category->very_satisfactory == 1)
                                            <input type="radio" name="{{$category->title}}" value="very_satisfactory" {{$meta[$category->title] == 'very_satisfactory' ? 'checked' : 'disabled'}} >
                                            <strong>Very Satisfactory</strong>
                                            <p class="description_font">{{$category->very_satisfactory_description}}</p>
                                        @endif
                                    </div>
                            </div>
                        </div>
                @endforeach
                
                    
                </div>
            </div>
        </div>
      
    </div>

    <div class="modal-footer">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    </div>
</form>
<style>
    .revenue_growth{
        border: 1px solid black;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding-top: 10px;
    }
    .description_font{
        font-size: 10px;
    }
    .main_class{
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-top: 10px;
        align-items: center;
        text-align: center;
        border: 1px solid black;
    
    }
</style>



<script>
     function getTeamLead(selectedEmployeeId) {
    const teamLeadInput = document.getElementById('team_lead');
    const department = document.getElementById('department');
    fetch(`/get-team-lead/${selectedEmployeeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.team_lead) {
                teamLeadInput.value = data.team_lead;
                department.value = data.department;
            } else {
                teamLeadInput.value = '';
            }
        })
        .catch(error => {
            console.error('Error fetching team lead:', error);
            teamLeadInput.value = 'Error fetching team lead';
        });
  }



    function handleFileInputChange(inputId, lineId, previewId) {
        var inputField = document.getElementById(inputId);
        var line = document.getElementById(lineId);
        var preview = document.getElementById(previewId);

        inputField.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var file = this.files[0];
                var fileType = file.type;

                if (fileType.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block'; // Ensure the preview is displayed
                        console.log("Image preview:", e.target.result);
                    };
                    reader.readAsDataURL(file);
                    line.style.display = 'block';
                } else {
                    line.style.display = 'none';
                    inputField.value = '';
                    preview.src = ''; // Clear the preview if the file is not an image
                    preview.style.display = 'none'; // Hide the preview
                    alert('Please select an image file.');
                }
            }
        });
    }

    handleFileInputChange('team_lead_signature_input', 'team_lead_signature_line', 'team_lead_signature_preview');
    handleFileInputChange('employee_signature_input', 'employee_signature_line', 'employee_signature_preview');
</script>
