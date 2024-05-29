<form method="post" action="{{ route('performance.yearDataStore') }}" enctype="multipart/form-data">
    @csrf

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <h6>Check the appropriate box for each criterion listed. A negative report
                    requires written documentation.
                </h6>
                <div class="form-group row">
                    <div id="tab1" class="tab row">
                        <div class=" col-md-6 designation_div">
                            <label for="month" class="col-form-label">Employee<span
                                    style="color:red">*</span></label>
                            <select class="form-control  designation_id select2" name="employee_id"
                                id="choices-multiple" onchange="getTeamLead(this.value)" placeholder="Select employee"
                                required>
                                <option value="">Select employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="form_name" value="1">
                        </div>
                        <div class="col-md-6">
                            <label for="job_title" class="col-form-label">Official Job Title/Salary Grade:<span
                                    style="color:red">*</span></label>
                            <input type="" class="form-control" name="job_title" required>
                        </div>

                        <div class="col-md-6">
                            <label for="joining_date" class="col-form-label">Joining Date:<span
                                    style="color:red">*</span></label>
                            <input type="date" class="form-control" name="joining_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="evaluation_duration" class="col-form-label">Duration of Evaluation:<span
                                    style="color:red">*</span></label>
                            <select class="form-control" name="evaluation_duration" required>
                                <option value="3 months">year</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="col-form-label">Department:<span
                                    style="color:red">*</span></label>
                            <input type="" class="form-control" name="department" required id="department">
                        </div>
                   
                    <h4 class="text-center mb-3">
                        ACCOMPLISHMENTS OF POSITION DUTIES, TASKS, AND RESPONSIBILITIES
                    </h4>
                    <p class="text-center">LIST DUTIES AND RESPONSIBILITIES IN ORDER OF PRIORITY. DOCUMENT EVALUATIONS
                        BY
                        PROVIDING COMMENTS ON PERFORMANCE THAT BRIEFLY DESCRIBE THE ACCOMPLISHMENTS AND JUSTIFY THE
                        LEVEL OF
                        EVALUATION.</p>
                    <table style="width:100%" class="year_form">
                        <tr>
                            <th>
                                <h6>
                                    MAJOR DUTIES AND RESPONSIBILITIES
                                </h6>
                                <p class="sub_heading">(To be completed by employee)</p>
                                <p class="sub_heading">This list should not be considered a complete description of all
                                    employee’s duties and
                                    responsibilities</p>
                            </th>
                            <th>
                                <h6>
                                    LEVEL OF PERFORMANCE
                                </h6>
                                <p class="sub_heading">(To be completed by RMO)</p>
                                <p class="sub_heading">Indicate one of these ratings for each duty and responsibility:
                                </p>
                                <h6>U LS FS E O</h6>
                            <th>
                                <h6>COMMENTS ON PERFORMANCE </h6>
                                <p class="sub_heading">(To be completed by RMO)</p>
                                <p class="sub_heading">Should consist of a statement indicating results achieved; also,
                                    may
                                    consist of comments
                                    indicating the employee’s proficiency with job-related skills</p>
                            </th>
                        </tr>
                        <tr>
                            <td>•To develop applications in multi-platform environments</td>
                            <td>
                                <select class="form-control" name="multi_platform_env">
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="multi_platform_env_comment" placeholder="" id="floatingTextarea2" style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To provide support to the existing systems</td>
                            <td>
                                <select class="form-control" name="existing_systems">
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="existing_systems_comment" placeholder="" id="floatingTextarea2" style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To carry out modifications to the programs, in a professional environment</td>
                            <td>
                                <select class="form-control" name="professional_environment" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="professional_environment_comment" placeholder="" id="floatingTextarea2"
                                    style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To work on all tasks on time as given by the team lead or project lead</td>
                            <td>
                                <select class="form-control" name="project_lead" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="project_lead_comment" placeholder="" id="floatingTextarea2" style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To carry out the programming, tests, and installation of new systems</td>
                            <td>
                                <select class="form-control" name="new_systems" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="new_systems_comment" placeholder="" id="floatingTextarea2" style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To carry out several projects in parallel</td>
                            <td>
                                <select class="form-control" name="parallel_projects" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="parallel_projects_comment" placeholder="" id="floatingTextarea2"
                                    style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To take part in the design, development, implementation, and maintenance of new and
                                existing products and services</td>
                            <td>
                                <select class="form-control" name="products_services" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="products_services_comment" placeholder="" id="floatingTextarea2"
                                    style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To write user's manual and technical documents (installation and use)</td>
                            <td>
                                <select class="form-control" name="technical_documents" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="technical_documents_comment" placeholder="" id="floatingTextarea2"
                                    style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To collaborate with the team on assigned tasks</td>
                            <td>
                                <select class="form-control" name="assigned_tasks" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="assigned_tasks_comment" placeholder="" id="floatingTextarea2" style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To complete all assigned tasks and will not hesitate to late sitting if required.</td>
                            <td>
                                <select class="form-control" name="late_sitting" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="late_sitting_comment" placeholder="" id="floatingTextarea2" style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To manage a team under him and lead their work.</td>
                            <td>
                                <select class="form-control" name="team_lead_their_work" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="team_lead_their_work_comment" placeholder="" id="floatingTextarea2"
                                    style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To ensure timely delivery.</td>
                            <td>
                                <select class="form-control" name="timely_delivery" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="timely_delivery_comment" placeholder="" id="floatingTextarea2" style=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>•To cater to clients’ needs and adopt a proactive approach in managing different
                                projects.
                            </td>
                            <td>
                                <select class="form-control" name="different_projects" required>
                                    <option value="U">U</option>
                                    <option value="LS">LS</option>
                                    <option value="FS">FS</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                            </td>
                            <td>
                                <textarea class="form-control" name="different_projects_comment" placeholder="" id="floatingTextarea2"
                                    style=""></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="tab2" class="tab" style="display: none;">



                    <h6 class="mt-3 mb-3 text-center">Some of the following factors may not apply to all positions.
                        When that is the case, check N/A. If
                        N/A is not provided, the factor MUST be evaluated. For each defined element of job performance,
                        place a mark within the appropriate appraisal rating box. The appraisal of each element of job
                        performance should be followed by comments explaining the rating and recommending specific areas
                        of
                        improvement or development if necessary. </h6>
                    @foreach ($indicators as $indicator)
                        <table style="width:100%" class="year_form">
                            <tr>
                                <th style="text-align: left;">
                                    <h6>{{ $indicator->title }}:</h6><span
                                        style="font-size: 14px;color:gray;">{{ $indicator->description }}</span>
                                </th>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex ">
                                        <div style="border: 1px solid gray;">
                                            <h6>Unsatisfactory</h6>
                                            <input type="radio" name="{{ $indicator->title }}"
                                                value="Unsatisfactory"
                                                style="width:100%;display:{{ $indicator->unsatisfactory == 1 ? 'block' : 'none' }}">
                                            <p style="font-size: 12px;">{{ $indicator->unsatisfactory_description }}
                                            </p>
                                        </div>
                                        <div style="border: 1px solid gray;">
                                            <h6>Less than Satisfactory</h6>
                                            <input type="radio" name="{{ $indicator->title }}"
                                                value="Less Satisfactory"
                                                style="width:100%;display:{{ $indicator->less_than_satisfactory == 1 ? 'block' : 'none' }}">
                                            <p style="font-size: 12px;">
                                                {{ $indicator->less_than_satisfactory_description }}</p>
                                        </div>
                                        <div style="border: 1px solid gray;">
                                            <h6>Fully Satisfactory</h6>
                                            <input type="radio" name="{{ $indicator->title }}"
                                                value="Fully Satisfactory"
                                                style="width:100%;display:{{ $indicator->full_satisfactory == 1 ? 'block' : 'none' }}">
                                            <p style="font-size: 12px;">
                                                {{ $indicator->full_satisfactory_description }}</p>
                                        </div>
                                        <div style="border: 1px solid gray;">
                                            <h6>Excellent</h6>
                                            <input type="radio" name="{{ $indicator->title }}" value="Excellent"
                                                style="width:100%;display:{{ $indicator->excellent == 1 ? 'block' : 'none' }}">
                                            <p style="font-size: 12px;">{{ $indicator->excellent_description }}</p>
                                        </div>
                                        <div style="border: 1px solid gray;">
                                            <h6>Outstanding</h6>
                                            <input type="radio" name="{{ $indicator->title }}" value="Outstanding"
                                                style="width:100%;display:{{ $indicator->outstanding == 1 ? 'block' : 'none' }}">
                                            <p style="font-size: 12px;">{{ $indicator->outstanding_description }}</p>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </table>
                    @endforeach
                </div>

























                <div id="tab3" class="tab" style="display: none;">
                    <div class="form-group mt-3">
                        <label for="floatingTextarea2">Areas that require development & suggestions to
                            accomplish:</label>
                        <textarea class="form-control" name="suggestions" placeholder="" id="floatingTextarea2" style="height: 100px"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="floatingTextarea2">Comment:</label>
                        <textarea class="form-control" name="comment" placeholder="" id="floatingTextarea2" style="height: 100px"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6" for="team_lead_signature_input">
                            <img id="team_lead_signature_preview" src="" alt="Team Lead Signature Preview"
                                style="display: none; max-width: 120px;height:70px; margin-bottom:-52px; margin-left:30px; margin-top:10px;">
                            <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%; "
                                id="team_lead_signature_line" for="team_lead_signature_input">Team Lead
                                Signature:</label>
                            <input type="file" class="form-control" id="team_lead_signature_input"
                                name="team_lead_signature" accept="image/*" style="display: none;">
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="col-form-label">Date:<span
                                    style="color:red">*</span></label>
                            <input type="date" class="form-control" name="lead_date">
                        </div>
                        <div class="col-md-6">
                            <img id="employee_signature_preview" src="" alt="Employee Signature Preview"
                                style="display: none; max-width: 120px;height:70px; height:90px; margin-bottom:-52px; margin-left:30px; margin-top:10px;">
                            <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%;"
                                id="employee_signature_line" for="employee_signature_input">Employee
                                Signature:</label>
                            <input type="file" class="form-control" id="employee_signature_input"
                                name="employee_signature" accept="image/*" style="display: none;">
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="col-form-label">Date:<span
                                    style="color:red">*</span></label>
                            <input type="date" class="form-control" name="employe_date">
                        </div>
                        <div class="col-md-6">
                            <img id="hr_signature_preview" src="" alt="Employee Signature Preview"
                                style="display: none; max-width: 120px;height:70px; height:90px; margin-bottom:-52px; margin-left:30px; margin-top:10px;">
                            <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%;"
                                id="hr_signature_line" for="hr_signature_input">HR
                                Signature:</label>
                            <input type="file" class="form-control" id="hr_signature_input"
                                name="hr_signature" accept="image/*" style="display: none;">
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="col-form-label">Date:<span
                                    style="color:red">*</span></label>
                            <input type="date" class="form-control" name="hr_date">
                        </div>
                        <div class="col-md-6">
                            <img id="ceo_signature_input_preview" src="" alt="Employee Signature Preview"
                                style="display: none; max-width: 120px;height:70px; height:90px; margin-bottom:-52px; margin-left:30px; margin-top:10px;">
                            <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%;"
                                id="ceo_signature_line" for="ceo_signature_input">
                                CEO Signature:</label>
                            <input type="file" class="form-control" id="ceo_signature_input"
                                name="ceo_signature" accept="image/*" style="display: none;">
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="col-form-label">Date:<span
                                    style="color:red">*</span></label>
                            <input type="date" class="form-control" name="ceo_date">
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <button type="button" class="btn btn-primary prev">Previous</button>
        <button type="button" class="btn btn-primary next">Next</button>
        <input type="submit" value="{{ __('Create') }}" class="btn btn-primary" style="display: none;">
    </div>
</form>

<style>
    table.year_form,
    table.year_form th,
    table.year_form td {
        text-align: center;
        border: 1px solid black;
        padding: 8px;
    }

    .sub_heading {
        font-size: 14px;
        color: gray;
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
    handleFileInputChange('hr_signature_input', 'hr_signature_line', 'hr_signature_preview');
    handleFileInputChange('ceo_signature_input', 'ceo_signature_line', 'ceo_signature_input_preview');
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     $(document).ready(function() {
        var currentTab = 1;
        showTab(currentTab);

        function showTab(tabNumber) {
            $(".tab").hide();
            $("#tab" + tabNumber).show();
            
            // Hide or show navigation buttons based on current tab
            if (tabNumber === 1) {
                $(".prev").hide();
            } else {
                $(".prev").show();
            }
            
            if (tabNumber === 3) {
                $(".next").hide();
                $("input[type='submit']").show();
            } else {
                $(".next").show();
                $("input[type='submit']").hide();
            }
        }

        $(".next").click(function() {
            currentTab++;
            showTab(currentTab);
        });

        $(".prev").click(function() {
            currentTab--;
            showTab(currentTab);
        });
    });
</script>
