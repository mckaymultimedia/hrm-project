<form method="post" action="{{ route('performance.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <h6>Check the appropriate box for each criterion listed. A negative report
                     requires written documentation.
                </h6>
                <div class="form-group row">
                  <div class=" col-md-6 designation_div">
                      <label for="month" class="col-form-label">Employee<span style="color:red">*</span></label>
                        <select class="form-control  designation_id select2" name="employee_id" id="choices-multiple" onchange="getTeamLead(this.value)"
                            placeholder="Select employee" required>
                            <option value="" >Select employee</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="job_title" class="col-form-label">Official Job Title/Salary Grade:<span style="color:red">*</span></label>
                        <input type="" class="form-control" name="job_title" required>
                    </div>
                   
                    <div class="col-md-6">
                      <label for="team_lead" class="col-form-label">Team Lead:<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="team_lead" name="team_lead" required >
                  </div>
                    <div class="col-md-6">
                        <label for="evaluation_duration" class="col-form-label">Duration of Evaluation:<span style="color:red">*</span></label>
                        <select class="form-control" name="evaluation_duration" required>
                            <option value="3 months">3 months</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="department" class="col-form-label">Department:<span style="color:red">*</span></label>
                        <input type="" class="form-control" name="department" required id="department">
                    </div>
                   
                    <div class="col-md-6 ">
                      <div class="">
                        <label class="col-form-label">Select one:<span style="color:red">*</span></label>
                        <div class="d-flex flex-column gap-1">
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="status" id="incrementOption" value="increment">
                              <label class="form-check-label" for="incrementOption">
                                  Increment
                              </label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="status" id="probationOption" value="probation">
                              <label class="form-check-label" for="probationOption">
                                  Probation
                              </label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="status" id="probation_increment" value="probation_increment">
                              <label class="form-check-label" for="probation_increment">
                                  Probation & Increment
                              </label>
                          </div>
                          </div>
                      </div>
                    </div>
                    
                  </div>
                  
                   
                </div>
                <div>
                  <h4 class="text-center mb-3">
                    THIS EVALUATION IS TO BE COMPLETED BY THE EMPLOYEE’S IMMEDIATE TEAM LEAD AND RETURNED TO HUMAN RESOURCES NO LATER THAN</h4>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col"></th>
                            <th scope="col">Unsatisfactory</th>
                            <th scope="col">Average</th>
                            <th scope="col">Above Average</th>
                            <th scope="col">Not Applicable</th>
                            <th scope="col">Not Observed</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($indicators as $indicator)
                            <tr>
                                  <th scope="row">{{ !empty($indicator->title) ? str_replace('_', ' ', $indicator->title) : '' }}</th>
                                  <td>
                                    @if ($indicator->unsatisfactory == 1)
                                    <input type="radio" name="{{ $indicator->title }}" value="Unsatisfactory">
                                    @endif</td>
                                  <td> @if ($indicator->average == 1)
                                    <input type="radio" name="{{ $indicator->title }}" value="Average">
                                    @endif</td>
                                  <td> @if ($indicator->above_average == 1)
                                    <input type="radio" name="{{ $indicator->title }}" value="Above Average">
                                    @endif</td>
                                  <td> @if ($indicator->not_applicable == 1)
                                    <input type="radio" name="{{ $indicator->title }}" value="Not Applicable">
                                    @endif</td>
                                  <td> @if ($indicator->not_observed == 1)
                                    <input type="radio" name="{{ $indicator->title }}" value="Not Observed">
                                    @endif</td>
                            </tr>
                          @endforeach
                        </tbody>
                        <thead>
                            <tr>
                              <th scope="col"></th>
                              <th scope="col">Unsatisfactory</th>
                              <th scope="col">Satisfactory</th>

                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <th scope="row">Overall Evaluation</th>
                                <td><input type="radio" name="overall_evaluation" value="Unsatisfactory"></td>
                                <td><input type="radio" name="overall_evaluation" value="satisfactory"></td>
                              </tr>
                          </tbody>
                      </table>
                      <div class="form-group">
                        <label for="floatingTextarea2">Areas that require development & suggestions to accomplish:</label>
                        <textarea class="form-control" name="suggestions" placeholder="" id="floatingTextarea2" style="height: 100px"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="floatingTextarea2">Comment:</label>
                        <textarea class="form-control" name="comment" placeholder="" id="floatingTextarea2" style="height: 100px"></textarea>
                      </div>

                      <div class="row">
                        <div class="col-md-6"  for="team_lead_signature_input">
                          <img id="team_lead_signature_preview" src="" alt="Team Lead Signature Preview" style="display: none; max-width: 120px;height:70px; margin-bottom:-52px; margin-left:30px; margin-top:10px;">
                          <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%; " id="team_lead_signature_line" for="team_lead_signature_input">Team Lead Signature:</label>
                          <input type="file" class="form-control" id="team_lead_signature_input" name="team_lead_signature" accept="image/*" style="display: none;">
                        </div>
                        <div class="col-md-6">
                          <label for="date" class="col-form-label">Date:<span style="color:red">*</span></label>
                          <input type="date" class="form-control" name="lead_date" >
                        </div>
                        <div class="col-md-6">
                          <img id="employee_signature_preview" src="" alt="Employee Signature Preview" style="display: none; max-width: 120px;height:70px; height:90px; margin-bottom:-52px; margin-left:30px; margin-top:10px;">
                          <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%;" id="employee_signature_line" for="employee_signature_input">Employee Signature:</label>
                          <input type="file" class="form-control" id="employee_signature_input" name="employee_signature" accept="image/*" style="display: none;">
                        </div>
                        <div class="col-md-6">
                          <label for="date" class="col-form-label">Date:<span style="color:red">*</span></label>
                          <input type="date" class="form-control" name="employe_date" >
                        </div>
                      </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
    </div>
</form>



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