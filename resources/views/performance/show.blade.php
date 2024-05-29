<form  action="">
    <div class="modal-body">
        <div  id="pdf_download">
            <div class="row">
                <div class="col-md-12">
                    <h6>Check the appropriate box for each criterion listed. A negative report
                        requires written documentation.
                    </h6>
                    @php
                        $meta = json_decode($performance_form->meta, true);
                        
                    @endphp
                    <div class="form-group row">
                        <div class=" col-md-6 designation_div">
                            <label for="month" class="col-form-label">Employee<span style="color:red">*</span></label>
                            <select class="form-control" name="employee_id"
                                placeholder="Select employee" required disabled>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $performance_form->employee_id == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="job_title" class="col-form-label">Official Job Title/Salary Grade:<span style="color:red">*</span></label>
                            <input type="" class="form-control" name="job_title" required value="{{ $meta['job_title'] }}" readonly>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="team_lead" class="col-form-label">Team Lead:<span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="team_lead" name="team_lead" required  value="{{ $meta['team_lead'] }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="evaluation_duration" class="col-form-label">Duration of Evaluation:<span style="color:red">*</span></label>
                            <select class="form-control" name="evaluation_duration" required disabled>
                                <option value="3 months" selected>3 months</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="col-form-label">Department:<span style="color:red">*</span></label>
                            <input type="" class="form-control" name="department" required value="{{ $meta['department'] }}"  readonly>
                        </div>
                        
                        <div class="col-md-6 ">
                            <div class="">
                            <label class="col-form-label">Select one:<span style="color:red">*</span></label>
                            <div class="d-flex flex-column gap-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="incrementOption" value="increment" @if($meta['status'] == 'increment') checked @endif disabled>
                                    <label class="form-check-label" for="incrementOption">
                                        Increment
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="probationOption" value="probation" @if($meta['status'] == 'probation') checked @endif disabled>
                                    <label class="form-check-label" for="probationOption">
                                        Probation
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="probation_increment" value="probation_increment" @if($meta['status'] == 'probation_increment') checked @endif disabled>
                                    <label class="form-check-label" for="probation_increment">
                                        Probation & Increment
                                    </label>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                        
                        
                    </div>
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
                                            
                                            <input type="radio" name="{{ $indicator->title }}" value="Unsatisfactory" {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Unsatisfactory' ? 'checked' : 'disabled' }}>
                                            @endif
                                    <td> @if ($indicator->average == 1)
                                        <input type="radio" name="{{ $indicator->title }}" value="Average" {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Average' ? 'checked' : 'disabled' }}>
                                        @endif</td>
                                    <td> @if ($indicator->above_average == 1)
                                        <input type="radio" name="{{ $indicator->title }}" value="Above Average" {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Above Average' ? 'checked' : 'disabled' }}>
                                        @endif</td>
                                    <td> @if ($indicator->not_applicable == 1)
                                        <input type="radio" name="{{ $indicator->title }}" value="Not Applicable" {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Not Applicable' ? 'checked' : 'disabled' }}>
                                        @endif</td>
                                    <td> @if ($indicator->not_observed == 1)
                                        <input type="radio" name="{{ $indicator->title }}" value="Not Observed" {{ isset($meta[$indicator->title]) && $meta[$indicator->title] == 'Not Observed' ? 'checked' : 'disabled' }}>
                                        @endif
                                    </td>
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
                                <td><input type="radio" name="overall_evaluation" value="Unsatisfactory"
                                        {{ isset($meta['overall_evaluation']) && $meta['overall_evaluation'] == 'Unsatisfactory' ? 'checked' : 'disabled' }}
                                        >
                                    </td>
                                <td><input type="radio" name="overall_evaluation" value="satisfactory"
                                        {{ isset($meta['overall_evaluation']) && $meta['overall_evaluation'] == 'satisfactory' ? 'checked' : 'disabled' }}
                                        >
                                    </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
            <div id="pdf_download_1">
                


                    <div class="form-group">
                        <label for="floatingTextarea2">Areas that require development & suggestions to accomplish:</label>
                        <textarea class="form-control" name="suggestions" id="floatingTextarea2" style="height: 100px" disabled>{{isset($meta['suggestions']) ? $meta['suggestions'] : ''}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="floatingTextarea2">Comment:</label>
                        <textarea class="form-control" name="comment" id="floatingTextarea2" style="height: 100px" disabled>{{isset($meta['comment']) ? $meta['comment'] : ''}}</textarea>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-6"  for="team_lead_signature_input">
                        @php                        
                                $signature = asset(url('storage'))."/" . $performance_form->team_lead_signature; 
                                $employeeSign = asset(url('storage'))."/" . $performance_form->employee_signature; 
                                
                                $profile = \App\Models\Utility::get_file("/");
                                
                        @endphp
                        <img id="team_lead_signature_preview"
                            src="{{ $performance_form->team_lead_signature ? $signature  : "" }}"
                            alt="Team Lead Signature Preview" style="max-width: 120px; height: 70px; margin-bottom: -52px; margin-left: 30px; margin-top: 10px;display: {{ $performance_form->team_lead_signature ? 'block' : 'none' }};">
                        <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%; " id="team_lead_signature_line" for="team_lead_signature_input">Team Lead Signature:</label>
                        <input type="file" class="form-control" id="team_lead_signature_input" name="team_lead_signature" accept="image/*" style="display: none;" disabled>
                        </div>
                        <div class="col-md-6">
                        <label for="date" class="col-form-label">Date:<span style="color:red">*</span></label>
                        <input type="date" class="form-control" name="lead_date"  value="{{ $meta['lead_date'] }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <img id="employee_signature_preview" src="{{ $performance_form->employee_signature ? $profile . '/' . $performance_form->employee_signature : '' }}"
                            alt="Employee Signature Preview" style=" max-width: 120px;height:70px; height:90px; margin-bottom:-52px; margin-left:30px; margin-top:10px; display: {{ $performance_form->employee_signature ? 'block' : 'none' }};">
                            <label style="margin-top: 60px; border-top: 1px solid #000; width: 85%;" id="employee_signature_line" for="employee_signature_input">Employee Signature:</label>
                        <input type="file" class="form-control" id="employee_signature_input" name="employee_signature" accept="image/*" style="display: none;" disabled>
                        </div>
                        <div class="col-md-6">
                        <label for="date" class="col-form-label">Date:<span style="color:red" >*</span></label>
                        <input type="date" class="form-control" name="employe_date"  value="{{ $meta['employe_date'] }}"  readonly>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    
        <button type="button" class="btn btn-primary probation_download">download</button>
    </div>

</form>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<style>
    /* Ensure that the content of pdf_download_1 starts on a new page */
    #pdf_download_1 {
        page-break-before: always;
    }
</style>

<!-- Your HTML content remains the same -->

<script>
    document.querySelector('.probation_download').addEventListener('click', function() {
        generatePDF();
    });

    function generatePDF() {
        console.log('here');
        // Select the HTML elements you want to convert to PDF
        const element1 = document.getElementById('pdf_download');
        const element2 = document.getElementById('pdf_download_1');

        // Combine the HTML content of both elements
        const combinedHTML = element1.innerHTML + element2.innerHTML;

        // Create a new div element to hold the combined content
        const combinedElement = document.createElement('div');
        combinedElement.innerHTML = combinedHTML;

        // Options for PDF generation (optional)
        const options = {
            margin: 0.7,
            filename: 'performance_evaluation.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        // Call html2pdf library to generate PDF from combined content
        html2pdf().from(combinedElement).set(options).save();
    }
</script>



