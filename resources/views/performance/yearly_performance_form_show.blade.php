<form>
    @csrf

    @php
        $meta = json_decode($performance_form->meta, true);
        $signature = \App\Models\Utility::get_file("/");
    @endphp
    <div class="modal-body" id="pdf_download">
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
                            <select class="form-control  designation_id select2" name="employee_id" disabled
                                id="choices-multiple" onchange="getTeamLead(this.value)" placeholder="Select employee"
                                required>
                                <option value="">Select employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}"
                                        {{ $performance_form->employee_id == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="job_title" class="col-form-label">Official Job Title/Salary Grade:<span
                                    style="color:red">*</span></label>
                            <input type="" class="form-control" name="job_title" required readonly
                                value="{{ $meta['job_title'] }}">
                        </div>

                        <div class="col-md-6">
                            <label for="joining_date" class="col-form-label">Joining Date:<span
                                    style="color:red">*</span></label>
                            <input type="date" class="form-control" name="joining_date" required readonly
                                value="{{ $meta['joining_date'] }}">
                        </div>
                        <div class="col-md-6">
                            <label for="evaluation_duration" class="col-form-label">Duration of Evaluation:<span
                                    style="color:red">*</span></label>
                            <select class="form-control" name="evaluation_duration" required disabled>
                                <option value="3 months">year</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="col-form-label">Department:<span
                                    style="color:red">*</span></label>
                            <input type="" class="form-control" name="department" required readonly
                                value="{{ $meta['department'] }}">
                        </div>
                    <div>
                        <h4 class="text-center mb-3">
                            ACCOMPLISHMENTS OF POSITION DUTIES, TASKS, AND RESPONSIBILITIES
                        </h4>
                        <p class="text-center">LIST DUTIES AND RESPONSIBILITIES IN ORDER OF PRIORITY. DOCUMENT
                            EVALUATIONS
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
                                    <p class="sub_heading">This list should not be considered a complete description of
                                        all
                                        employee’s duties and
                                        responsibilities</p>
                                </th>
                                <th>
                                    <h6>
                                        LEVEL OF PERFORMANCE
                                    </h6>
                                    <p class="sub_heading">(To be completed by RMO)</p>
                                    <p class="sub_heading">Indicate one of these ratings for each duty and
                                        responsibility:
                                    </p>
                                    <h6>U LS FS E O</h6>
                                <th>
                                    <h6>COMMENTS ON PERFORMANCE </h6>
                                    <p class="sub_heading">(To be completed by RMO)</p>
                                    <p class="sub_heading">Should consist of a statement indicating results achieved;
                                        also,
                                        may
                                        consist of comments
                                        indicating the employee’s proficiency with job-related skills</p>
                                </th>
                            </tr>
                            <tr>
                                <td>•To develop applications in multi-platform environments</td>

                                <td>
                                    <select class="form-control" name="multi_platform_env" disabled>
                                        <option value="U"
                                            {{ $meta['multi_platform_env'] == 'U' ? 'selected' : '' }}>U
                                        </option>
                                        <option value="LS"
                                            {{ $meta['multi_platform_env'] == 'LS' ? 'selected' : '' }}>
                                            LS</option>
                                        <option value="FS"
                                            {{ $meta['multi_platform_env'] == 'FS' ? 'selected' : '' }}>
                                            FS</option>
                                        <option value="E"
                                            {{ $meta['multi_platform_env'] == 'E' ? 'selected' : '' }}>E
                                        </option>
                                        <option value="O"
                                            {{ $meta['multi_platform_env'] == 'O' ? 'selected' : '' }}>O
                                        </option>
                                </td>
                                <td>
                                    <textarea class="form-control" name="multi_platform_env_comment" placeholder="" id="floatingTextarea2" style="">{{ $meta['multi_platform_env_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To provide support to the existing systems</td>
                                <td>
                                    <select disabled class="form-control" name="existing_systems">

                                        <option value="U"
                                            {{ $meta['existing_systems'] == 'U' ? 'selected' : '' }}>U
                                        </option>
                                        <option value="LS"
                                            {{ $meta['existing_systems'] == 'LS' ? 'selected' : '' }}>LS
                                        </option>
                                        <option value="FS"
                                            {{ $meta['existing_systems'] == 'FS' ? 'selected' : '' }}>FS
                                        </option>
                                        <option value="E"
                                            {{ $meta['existing_systems'] == 'E' ? 'selected' : '' }}>E
                                        </option>
                                        <option value="O"
                                            {{ $meta['existing_systems'] == 'O' ? 'selected' : '' }}>O
                                        </option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="existing_systems_comment" placeholder="" id="floatingTextarea2" style="">{{ $meta['existing_systems_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To carry out modifications to the programs, in a professional environment</td>
                                <td>
                                    <select disabled class="form-control" name="professional_environment" required>
                                        <option value="U"
                                            {{ $meta['professional_environment'] == 'U' ? 'selected' : '' }}>U</option>
                                        <option value="LS"
                                            {{ $meta['professional_environment'] == 'LS' ? 'selected' : '' }}>LS
                                        </option>
                                        <option value="FS"
                                            {{ $meta['professional_environment'] == 'FS' ? 'selected' : '' }}>FS
                                        </option>
                                        <option value="E"
                                            {{ $meta['professional_environment'] == 'E' ? 'selected' : '' }}>E</option>
                                        <option value="O"
                                            {{ $meta['professional_environment'] == 'O' ? 'selected' : '' }}>O</option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="professional_environment_comment" placeholder="" id="floatingTextarea2">{{ $meta['professional_environment_comment'] }}</textarea>
                                </td>
                            </tr>

                            <tr class="">
                                <td>•To work on all tasks on time as given by the team lead or project lead</td>
                                <td>
                                    <select disabled class="form-control" name="project_lead" required>
                                        <option value="U" {{ $meta['project_lead'] == 'U' ? 'selected' : '' }}>U
                                        </option>
                                        <option value="LS" {{ $meta['project_lead'] == 'LS' ? 'selected' : '' }}>LS
                                        </option>
                                        <option value="FS" {{ $meta['project_lead'] == 'FS' ? 'selected' : '' }}>
                                            FS
                                        </option>
                                        <option value="E" {{ $meta['project_lead'] == 'E' ? 'selected' : '' }}>E
                                        </option>
                                        <option value="O" {{ $meta['project_lead'] == 'O' ? 'selected' : '' }}>O
                                        </option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="project_lead_comment" placeholder="" id="floatingTextarea2" style="">{{ $meta['project_lead_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To carry out the programming, tests, and installation of new systems</td>
                                <td>
                                    <select disabled class="form-control" name="new_systems" required>
                                        <option value="U" {{ $meta['new_systems'] == 'U' ? 'selected' : '' }}>U
                                        </option>
                                        <option value="LS" {{ $meta['new_systems'] == 'LS' ? 'selected' : '' }}>LS
                                        </option>
                                        <option value="FS" {{ $meta['new_systems'] == 'FS' ? 'selected' : '' }}>FS
                                        </option>
                                        <option value="E" {{ $meta['new_systems'] == 'E' ? 'selected' : '' }}>E
                                        </option>
                                        <option value="O" {{ $meta['new_systems'] == 'O' ? 'selected' : '' }}>O
                                        </option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="new_systems_comment" placeholder="" id="floatingTextarea2" style="">{{ $meta['new_systems_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To carry out several projects in parallel</td>
                                <td>
                                    <select disabled class="form-control" name="parallel_projects" required>
                                        <option value="U"
                                            {{ $meta['parallel_projects'] == 'U' ? 'selected' : '' }}>U
                                        </option>
                                        <option value="LS"
                                            {{ $meta['parallel_projects'] == 'LS' ? 'selected' : '' }}>
                                            LS</option>
                                        <option value="FS"
                                            {{ $meta['parallel_projects'] == 'FS' ? 'selected' : '' }}>
                                            FS</option>
                                        <option value="E"
                                            {{ $meta['parallel_projects'] == 'E' ? 'selected' : '' }}>E
                                        </option>
                                        <option value="O"
                                            {{ $meta['parallel_projects'] == 'O' ? 'selected' : '' }}>O
                                        </option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="parallel_projects_comment" placeholder="" id="floatingTextarea2"
                                        style="">{{ $meta['parallel_projects_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To take part in the design, development, implementation, and maintenance of new and
                                    existing products and services</td>
                                <td>
                                    <select disabled class="form-control" name="products_services" required>
                                        <option value="U"
                                            {{ $meta['products_services'] == 'U' ? 'selected' : '' }}>U
                                        </option>
                                        <option value="LS"
                                            {{ $meta['products_services'] == 'LS' ? 'selected' : '' }}>
                                            LS</option>
                                        <option value="FS"
                                            {{ $meta['products_services'] == 'FS' ? 'selected' : '' }}>
                                            FS</option>
                                        <option value="E"
                                            {{ $meta['products_services'] == 'E' ? 'selected' : '' }}>E
                                        </option>
                                        <option value="O"
                                            {{ $meta['products_services'] == 'O' ? 'selected' : '' }}>O
                                        </option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="products_services_comment" placeholder="" id="floatingTextarea2"
                                        style="">{{ $meta['products_services_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To write user's manual and technical documents (installation and use)</td>
                                <td>
                                    <select disabled class="form-control" name="technical_documents" required>
                                        <option value="U"
                                            {{ $meta['technical_documents'] == 'U' ? 'selected' : '' }}>U</option>
                                        <option value="LS"
                                            {{ $meta['technical_documents'] == 'LS' ? 'selected' : '' }}>LS</option>
                                        <option value="FS"
                                            {{ $meta['technical_documents'] == 'FS' ? 'selected' : '' }}>FS</option>
                                        <option value="E"
                                            {{ $meta['technical_documents'] == 'E' ? 'selected' : '' }}>E</option>
                                        <option value="O"
                                            {{ $meta['technical_documents'] == 'O' ? 'selected' : '' }}>O</option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="technical_documents_comment" placeholder="" id="floatingTextarea2"
                                        style="">{{ $meta['technical_documents_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To collaborate with the team on assigned tasks</td>
                                <td>
                                    <select disabled class="form-control" name="assigned_tasks" required>
                                        <option value="U" {{ $meta['assigned_tasks'] == 'U' ? 'selected' : '' }}>
                                            U
                                        </option>
                                        <option value="LS"
                                            {{ $meta['assigned_tasks'] == 'LS' ? 'selected' : '' }}>LS
                                        </option>
                                        <option value="FS"
                                            {{ $meta['assigned_tasks'] == 'FS' ? 'selected' : '' }}>FS
                                        </option>
                                        <option value="E" {{ $meta['assigned_tasks'] == 'E' ? 'selected' : '' }}>
                                            E
                                        </option>
                                        <option value="O" {{ $meta['assigned_tasks'] == 'O' ? 'selected' : '' }}>
                                            O
                                        </option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="assigned_tasks_comment" placeholder="" id="floatingTextarea2" style="">{{ $meta['assigned_tasks_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To complete all assigned tasks and will not hesitate to late sitting if required.
                                </td>
                                <td>
                                    <select disabled class="form-control" name="late_sitting" required>
                                        <option value="U" {{ $meta['late_sitting'] == 'U' ? 'selected' : '' }}>U
                                        </option>
                                        <option value="LS" {{ $meta['late_sitting'] == 'LS' ? 'selected' : '' }}>
                                            LS
                                        </option>
                                        <option value="FS" {{ $meta['late_sitting'] == 'FS' ? 'selected' : '' }}>
                                            FS
                                        </option>
                                        <option value="E" {{ $meta['late_sitting'] == 'E' ? 'selected' : '' }}>E
                                        </option>
                                        <option value="O" {{ $meta['late_sitting'] == 'O' ? 'selected' : '' }}>O
                                        </option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="late_sitting_comment" placeholder="" id="floatingTextarea2" style="">{{ $meta['late_sitting_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To manage a team under him and lead their work.</td>
                                <td>
                                    <select disabled class="form-control" name="team_lead_their_work" required>
                                        <option value="U"
                                            {{ $meta['team_lead_their_work'] == 'U' ? 'selected' : '' }}>U</option>
                                        <option value="LS"
                                            {{ $meta['team_lead_their_work'] == 'LS' ? 'selected' : '' }}>LS</option>
                                        <option value="FS"
                                            {{ $meta['team_lead_their_work'] == 'FS' ? 'selected' : '' }}>FS</option>
                                        <option value="E"
                                            {{ $meta['team_lead_their_work'] == 'E' ? 'selected' : '' }}>E</option>
                                        <option value="O"
                                            {{ $meta['team_lead_their_work'] == 'O' ? 'selected' : '' }}>O</option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="team_lead_their_work_comment" placeholder="" id="floatingTextarea2"
                                        style="">{{ $meta['team_lead_their_work_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To ensure timely delivery.</td>
                                <td>
                                    <select disabled class="form-control" name="timely_delivery" required>
                                        <option value="U"
                                            {{ $meta['timely_delivery'] == 'U' ? 'selected' : '' }}>U
                                        </option>
                                        <option value="LS"
                                            {{ $meta['timely_delivery'] == 'LS' ? 'selected' : '' }}>LS
                                        </option>
                                        <option value="FS"
                                            {{ $meta['timely_delivery'] == 'FS' ? 'selected' : '' }}>FS
                                        </option>
                                        <option value="E"
                                            {{ $meta['timely_delivery'] == 'E' ? 'selected' : '' }}>E
                                        </option>
                                        <option value="O"
                                            {{ $meta['timely_delivery'] == 'O' ? 'selected' : '' }}>O
                                        </option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="timely_delivery_comment" placeholder="" id="floatingTextarea2" style="">{{ $meta['timely_delivery_comment'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>•To cater to clients’ needs and adopt a proactive approach in managing different
                                    projects.
                                </td>
                                <td>
                                    <select disabled class="form-control" name="different_projects" required>
                                        <option value="U"
                                            {{ $meta['different_projects'] == 'U' ? 'selected' : '' }}>
                                            U</option>
                                        <option value="LS"
                                            {{ $meta['different_projects'] == 'LS' ? 'selected' : '' }}>LS</option>
                                        <option value="FS"
                                            {{ $meta['different_projects'] == 'FS' ? 'selected' : '' }}>FS</option>
                                        <option value="E"
                                            {{ $meta['different_projects'] == 'E' ? 'selected' : '' }}>
                                            E</option>
                                        <option value="O"
                                            {{ $meta['different_projects'] == 'O' ? 'selected' : '' }}>
                                            O</option>
                                </td>
                                <td>
                                    <textarea readonly class="form-control" name="different_projects_comment" placeholder="" id="floatingTextarea2"
                                        style="">{{ $meta['different_projects_comment'] }}</textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    </div>

                    <div id="tab2" class="tab" style="display: none;">
                        <h6 class="mt-3 mb-3 text-center">Some of the following factors may not apply to all positions.
                            When that is the case, check N/A. If
                            N/A is not provided, the factor MUST be evaluated. For each defined element of job
                            performance,
                            place a mark within the appropriate appraisal rating box. The appraisal of each element of
                            job
                            performance should be followed by comments explaining the rating and recommending specific
                            areas
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
                                                <input readonly type="radio" name="{{ $indicator->title }}"
                                                    value="Unsatisfactory"
                                                    style="width:100%;display:{{ $indicator->unsatisfactory == 1 ? 'block' : 'none' }}"
                                                    {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Unsatisfactory' ? 'checked' : 'disabled' }}>
                                                <p style="font-size: 12px;">
                                                    {{ $indicator->unsatisfactory_description }}
                                                </p>
                                            </div>

                                            <div style="border: 1px solid gray;">
                                                <h6>Less than Satisfactory</h6>
                                                <input readonly type="radio" name="{{ $indicator->title }}"
                                                    value="Less Satisfactory"
                                                    style="width:100%;display:{{ $indicator->less_than_satisfactory == 1 ? 'block' : 'none' }}"
                                                    {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Less Satisfactory' ? 'checked' : 'disabled' }}>
                                                <p style="font-size: 12px;">
                                                    {{ $indicator->less_than_satisfactory_description }}</p>
                                            </div>
                                            <div style="border: 1px solid gray;">
                                                <h6>Fully Satisfactory</h6>
                                                <input readonly type="radio" name="{{ $indicator->title }}"
                                                    value="Fully Satisfactory"
                                                    style="width:100%;display:{{ $indicator->full_satisfactory == 1 ? 'block' : 'none' }}"
                                                    {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Fully Satisfactory' ? 'checked' : 'disabled' }}>
                                                <p style="font-size: 12px;">
                                                    {{ $indicator->full_satisfactory_description }}</p>
                                            </div>
                                            <div style="border: 1px solid gray;">
                                                <h6>Excellent</h6>
                                                <input readonly type="radio" name="{{ $indicator->title }}"
                                                    value="Excellent"
                                                    style="width:100%;display:{{ isset($indicator->excellent) && $indicator->excellent == 1 ? 'block' : 'none' }}"
                                                    {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Excellent' ? 'checked' : 'disabled' }}>
                                                <p style="font-size: 12px;">{{ $indicator->excellent_description }}
                                                </p>
                                            </div>
                                            <div style="border: 1px solid gray;">
                                                <h6>Outstanding</h6>
                                                <input readonly type="radio" name="{{ $indicator->title }}"
                                                    value="Outstanding"
                                                    style="width:100%;display:{{ $indicator->outstanding == 1 ? 'block' : 'none' }}"
                                                    {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Outstanding' ? 'checked' : 'disabled' }}>
                                                <p style="font-size: 12px;">{{ $indicator->outstanding_description }}
                                                </p>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        @endforeach
                    </div>


                    <div id="tab3" class="tab" style="display: none;">

























                        <div id="second-tab" style="">
                            <div class="form-group mt-3">
                                <label for="floatingTextarea2">Areas that require development & suggestions to
                                    accomplish:</label>
                                <textarea class="form-control" name="suggestions" placeholder="" id="floatingTextarea2" style="height: 100px" disabled>{{ isset($meta['suggestions']) ? $meta['suggestions'] : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="floatingTextarea2">Comment:</label>
                                <textarea class="form-control" name="comment" placeholder="" id="floatingTextarea2" style="height: 100px" disabled>{{ isset($meta['comment']) ? $meta['comment'] : '' }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6" for="team_lead_signature_input">
                                    <img id="team_lead_signature_preview"
                                    src="{{ $performance_form->team_lead_signature ? $signature . '/' . $performance_form->team_lead_signature : '' }}"
                                    alt="Team Lead Signature Preview" style="max-width: 120px; height: 70px; margin-bottom: -52px; margin-left: 30px; margin-top: 10px;display: {{ $performance_form->team_lead_signature ? 'block' : 'none' }};">
                                    <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%; "
                                        id="team_lead_signature_line" for="team_lead_signature_input">Team Lead
                                        Signature:</label>
                                    <input type="file" class="form-control" id="team_lead_signature_input" 
                                        name="team_lead_signature" accept="image/*" style="display: none;" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="date" class="col-form-label">Date:<span
                                            style="color:red">*</span></label>
                                    <input type="date" class="form-control" name="lead_date" disabled value="{{ isset($meta['lead_date']) ? $meta['lead_date'] : '' }}">
                                </div>
                            
                                <div class="col-md-6">
                                    <img id="employee_signature_preview" src="{{ $performance_form->employee_signature ? $signature . '/' . $performance_form->employee_signature : '' }}"
                                        alt="Employee Signature Preview"
                                        style=" max-width: 120px;height:70px; height:90px; margin-bottom:-52px; margin-left:30px; margin-top:10px; display: {{ $performance_form->employee_signature ? 'block' : 'none' }};">
                                    <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%;"
                                        id="employee_signature_line" for="employee_signature_input">Employee
                                        Signature:</label>
                                    <input type="file" class="form-control" id="employee_signature_input"
                                        name="employee_signature" accept="image/*" style="display: none;"  disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="date" class="col-form-label">Date:<span
                                            style="color:red">*</span></label>
                                    <input type="date" class="form-control" name="employe_date" disabled value="{{ isset($meta['employe_date']) ? $meta['employe_date'] : '' }}">
                                </div>
                                <div class="col-md-6">
                                    <img id="hr_signature_preview" src="{{ $performance_form->hr_signature ? $signature . '/' . $performance_form->hr_signature : ''}}"
                                     alt="Employee Signature Preview"
                                        style=" max-width: 120px;height:70px; height:90px; margin-bottom:-52px; margin-left:30px; margin-top:10px ; display: {{ $performance_form->hr_signature ? 'block' : 'none' }};">
                                    <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%;"
                                        id="hr_signature_line" for="hr_signature_input">HR
                                        Signature:</label>
                                    <input type="file" class="form-control" id="hr_signature_input"
                                        name="hr_signature" accept="image/*" style="display: none;"  disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="date" class="col-form-label">Date:<span
                                            style="color:red">*</span></label>
                                    <input type="date" class="form-control" name="hr_date" disabled value="{{ isset($meta['hr_date']) ? $meta['hr_date'] : '' }}">
                                </div>
                                <div class="col-md-6">
                                    <img id="ceo_signature_input_preview" src="{{$performance_form->ceo_signature ? $signature . '/' . $performance_form->ceo_signature : ''}}"
                                     alt="Employee Signature Preview"
                                        style=" max-width: 120px;height:70px; height:90px; margin-bottom:-52px; margin-left:30px; margin-top:10px; display: {{ $performance_form->ceo_signature ? 'block' : 'none' }};">
                                    <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%;"
                                        id="employee_signature_line" for="ceo_signature_input">
                                        CEO Signature:</label>
                                    <input type="file" class="form-control" id="ceo_signature_input"
                                        name="ceo_signature" accept="image/*" style="display: none;"  disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="date" class="col-form-label">Date:<span
                                            style="color:red">*</span></label>
                                    <input type="date" class="form-control" name="ceo_date" disabled value="{{ isset($meta['ceo_date']) ? $meta['ceo_date'] : '' }}">
                                </div>
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

        <button type="button" class="btn btn-primary probation_download">download</button>
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
     #pdf_download_1 {
        page-break-before: always;
    }
</style>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
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

    // handleFileInputChange('team_lead_signature_input', 'team_lead_signature_line', 'team_lead_signature_preview');
    // handleFileInputChange('employee_signature_input', 'employee_signature_line', 'employee_signature_preview');
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
    document.querySelector('.probation_download').addEventListener('click', function() {
        generatePDF();
    });

    function generatePDF() {
    console.log('here');
    // Select the HTML elements you want to convert to PDF from each tab page
    const elements = document.querySelectorAll('.tab');

    // Create a new div element to hold the combined content
    const combinedElement = document.createElement('div');

    // Loop through each tab page and append its content to the combinedElement
    elements.forEach(element => {
        combinedElement.innerHTML += element.innerHTML;
    });

    // Options for PDF generation (optional)
    const options = {
        margin: 0.3,
        filename: 'performance_evaluation.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 4 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };

    // Call html2pdf library to generate PDF from combined content
    html2pdf().from(combinedElement).set(options).save();
}

</script>
