<form method="post" action="{{ route('performance.Bdupdate' , $performance_form->id) }}" >
    @csrf
    @php
    $meta = json_decode($performance_form->meta, true);
    

$categories = [
    'Revenue Growth' => [
        'Poor' => 'Less than 5% increase in revenue.',
        'Fair' => '5% to 10% increase in revenue.',
        'Good' => '10% to 20% increase in revenue',
        'Excellent' => 'More than 20% increase in revenue',
    ],
    'New Business Acquisition' => [
        'Poor' => ' No clients acquired.',
        'Good' => ' 3 to 4 clients acquired.',
        'Fair' => '1 to 2 Clients Acquired.',
        'Excellent' => 'More than 4 clients acquired.'
    ],
    'Conversion Rate' => [
        'Very Low' => 'Less than 10% of leads converted.',
        'Low' => '10% to 20% of leads converted.',
        'Moderate' => '21% to 30% of leads converted.',
        'High' => '31% to 40% of leads converted.',
        'Excellent' => 'More than 40% of leads converted.'
    ],
    'Client Retention Rate' => [
        'Poor' => '50% or less than of it.',
        'Fair' => '60% to 70% of clients retained.',
        'Good' => '70% to 80% of clients retained.',
        'Excellent' => 'More than 80% of clients retained.'
        
    ],
    'Lead Generation' => [
        'Poor' => 'Less than 5 leads.',
        'Fair' => '5 to 8 fair quality leads.',
        'Good' => '9 to 15 good-quality leads.',
        'Excellent' => ' More than 15 high-quality leads.'
    ],
    'Average Deal Size' => [
        'Smal' => 'Less than $14/hour.',
        'Average' => 'Deals worth $18 to $25/hour.',
        'Above Average' => ' Deals worth above $25/hour.'
    ],
    'Time to Close' => [
        'Poor' => 'Above than 10 days.',
        'Fair' => 'Within 8 days.',
        'Good' => 'Within 5 days.',
        'Excellent' => ' Within 3 days.'
    ],
    'Responsiveness and Availability' => [
        'Poor' => ' Responds within 24 hours, limited availability.',
        'Fair' => ' Responds within 8 hours, during extended business hours.',
        'Good' => 'Responds within 4 hours, available during extended business hours.',
        'Excellent' => ' Responds within 2 hours, 24/7 availability.'
    ],
    'Response Time' => [
        'Poor' => 'More than 3 hours.',
        'Fair' => 'More than 1 hour and less than 3 Hours.',
        'Good' => 'Within 1 hour.',
        'Excellent' => 'Within 30 minutes.'
    ],
    'Meeting Targets' => [
        'Poor' => ' Achieves 50% or less.',
        'Fair' => ' Achieves 60% to 90% of targets.',
        'Excellent' => 'Achieves 100% of targets or above.'
    ],
    'Creating and Maintaining Relevant Documents' => [
        'Poor' => ' Many documents are outdated and inaccurate.',
        'Fair' => 'Some documents are outdated or moderately inaccurate.',
        'Good' => '  Documents are mostly up-to-date with minor inaccuracies.',
        'Excellent' => 'Documents are always up-to-date, accurate, and easily accessible.'
    ],
];



@endphp
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <h6>BD Team KPI Parameters
                </h6>
                <div class="form-group row">
                    <div class=" col-md-6 designation_div">
                        <label for="month" class="col-form-label">Employee<span style="color:red">*</span></label>
                        <select class="form-control  designation_id select2" name="employee_id" id="choices-multiple" onchange="getTeamLead(this.value)"
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
                        <input type="text" class="form-control" id="team_lead" name="team_lead" required  value="{{isset($meta['team_lead']) ? $meta['team_lead'] : ''}}">
                    </div>
                    <div class="col-md-6">
                        <label for="evaluation_duration" class="col-form-label">Duration of Evaluation:<span
                                style="color:red">*</span></label>
                        <select class="form-control" name="evaluation_duration" required>
                            <option value="3 months">3 months</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="department" class="col-form-label">Department:<span style="color:red">*</span></label>
                        <input type="" class="form-control" name="department" required value="{{ isset($meta['department']) ? $meta['department'] : '' }}" id="department">
                    </div>
                    @foreach($categories as $category => $subcategories)
                    @php
                    @endphp
                    <div class="main_class">
                        <h6>{{ $category }}</h6>
                        <div class="d-flex">
                            @foreach($subcategories as $subcategory => $description)
                                @php
                                    $cleaned_category = str_replace(' ', '_', $category);
                                    
                                @endphp
                                <div class="revenue_growth">
                                    <input type="radio" name="{{ $cleaned_category }}" value="{{ $subcategory }}" {{ isset($meta[$cleaned_category]) && $meta[$cleaned_category] == $subcategory ? 'checked' : '' }} />
                                    <strong>{{ $subcategory }}</strong>
                                    <p>{{ $description }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                    
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
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
