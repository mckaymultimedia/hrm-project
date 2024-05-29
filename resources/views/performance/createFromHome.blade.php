<form method="post" action="{{ route('performance.store') }}">
    @csrf

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <h6>Check the appropriate box for each criterion listed. A negative report
                     requires written documentation.
                </h6>
                <div class="form-group">
                    <label for="month" class="col-form-label">Employee<span style="color:red">*</span></label>
                    <div class=" col-md-6 designation_div">
                        <select class="form-control  designation_id select2" name="employee_id" id="choices-multiple"
                            placeholder="Select employee" required>

                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $ID == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
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
                          <tr>
                            <th scope="row">Quality of Work</th>
                            <td><input type="radio" name="quality_of_work" value="Unsatisfactory"></td>
                            <td><input type="radio" name="quality_of_work" value="Average"></td>
                            <td><input type="radio" name="quality_of_work" value="Above Average"></td>
                            <td><input type="radio" name="quality_of_work" value="Not Applicable"></td>
                            <td><input type="radio" name="quality_of_work" value="Not Observed"></td>
                          </tr>
                          <tr>
                            <th scope="row">Quantity of Work</th>
                            <td><input type="radio" name="quantity_of_work" value="Unsatisfactory"></td>
                            <td><input type="radio" name="quantity_of_work" value="Average"></td>
                            <td><input type="radio" name="quantity_of_work" value="Above Average"></td>
                            <td><input type="radio" name="quantity_of_work" value="Not Applicable"></td>
                            <td><input type="radio" name="quantity_of_work" value="Not Observed"></td>
                          </tr>
                          <tr>
                            <th scope="row">Ability to be Trained</th>
                            <td><input type="radio" name="ability_to_be_trained" value="Unsatisfactory"></td>
                            <td><input type="radio" name="ability_to_be_trained" value="Average"></td>
                            <td><input type="radio" name="ability_to_be_trained" value="Above Average"></td>
                            <td><input type="radio" name="ability_to_be_trained" value="Not Applicable"></td>
                            <td><input type="radio" name="ability_to_be_trained" value="Not Observed"></td>
                          </tr>
                          <tr>
                            <th scope="row">Attitude Toward Job</th>
                            <td><input type="radio" name="attitude_toward_job" value="Unsatisfactory"></td>
                            <td><input type="radio" name="attitude_toward_job" value="Average"></td>
                            <td><input type="radio" name="attitude_toward_job" value="Above Average"></td>
                            <td><input type="radio" name="attitude_toward_job" value="Not Applicable"></td>
                            <td><input type="radio" name="attitude_toward_job" value="Not Observed"></td>
                          </tr>
                          <tr>
                            <th scope="row">Appearance</th>
                            <td><input type="radio" name="appearance" value="Unsatisfactory"></td>
                            <td><input type="radio" name="appearance" value="Average"></td>
                            <td><input type="radio" name="appearance" value="Above Average"></td>
                            <td><input type="radio" name="appearance" value="Not Applicable"></td>
                            <td><input type="radio" name="appearance" value="Not Observed"></td>
                          </tr>
                          <tr>
                            <th scope="row">Attendance</th>
                            <td><input type="radio" name="attendance" value="Unsatisfactory"></td>
                            <td><input type="radio" name="attendance" value="Average"></td>
                            <td><input type="radio" name="attendance" value="Above Average"></td>
                            <td><input type="radio" name="attendance" value="Not Applicable"></td>
                            <td><input type="radio" name="attendance" value="Not Observed"></td>
                          </tr>
                          <tr>
                            <th scope="row">Punctuality</th>
                            <td><input type="radio" name="punctuality" value="Unsatisfactory"></td>
                            <td><input type="radio" name="punctuality" value="Average"></td>
                            <td><input type="radio" name="punctuality" value="Above Average"></td>
                            <td><input type="radio" name="punctuality" value="Not Applicable"></td>
                            <td><input type="radio" name="punctuality" value="Not Observed"></td>
                          </tr>
                          <tr>
                            <th scope="row">Relations With Other</th>
                            <td><input type="radio" name="relations_with_other" value="Unsatisfactory"></td>
                            <td><input type="radio" name="relations_with_other" value="Average"></td>
                            <td><input type="radio" name="relations_with_other" value="Above Average"></td>
                            <td><input type="radio" name="relations_with_other" value="Not Applicable"></td>
                            <td><input type="radio" name="relations_with_other" value="Not Observed"></td>
                          </tr>

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

                </div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
    </div>
</form>
