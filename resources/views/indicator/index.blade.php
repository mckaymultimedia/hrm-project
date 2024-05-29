@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Indicator') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Indicator') }}</li>
@endsection

@section('action-button')
    @can('Create Indicator')
        <a href="#" data-url="{{ route('indicator.create') }}" data-ajax-popup="true" data-size="lg"
            data-title="{{ __('Create New Indicator') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('probation') }}">
            <i class="ti ti-plus"></i> Probation
        </a>
    @endcan
    @can('Create Indicator')
    <a href="#" data-url="{{ route('indicator.year') }}" data-ajax-popup="true" data-size="lg"
        data-title="{{ __('Create New Indicator') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Year indicator') }}">
        <i class="ti ti-plus"></i> Yearly
    </a>
@endcan
    @can('Create Indicator')
    <a href="#" data-url="{{ route('indicator.month') }}" data-ajax-popup="true" data-size="lg"
        data-title="{{ __('Create New Indicator') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Monthly indicator') }}">
        <i class="ti ti-plus"></i> Monthly
    </a>
@endcan

@endsection


@section('content')
    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-primary" id="three_month_btn">
                    <input type="radio" name="options"  autocomplete="off" checked onclick="showIndicators('three_month');"> Three Month
                </label>
                <label class="btn btn-primary" id="month_btn">
                    <input type="radio" name="options"  autocomplete="off"  onclick="showIndicators('month');">Monthly
                </label>
                <label class="btn btn-primary" id="year_btn">
                    <input type="radio" name="options"  autocomplete="off" onclick="showIndicators('year');">
                     Year
                </label>
              
            </div>
        </div>
    </div>

    <div class="col-xl-12 " id="year" style="display: none;">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5> </h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Title33') }}</th>
                                <th>{{ __('Unsatisfactory') }}</th>
                                <th>{{ __('Less than Satisfactory') }}</th>
                                <th>{{ __('Fully Satisfactory') }}</th>
                                <th>{{ __('Excellent') }}</th>
                                <th>{{ __('Outstanding') }}</th>
                                @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($yearIndicators as $indicator)
                             
                                <tr>
                                    <td><strong>{{ !empty($indicator->title) ? str_replace('_', ' ', $indicator->title) : '' }}</strong></td>

                                    <td>
                                        @if($indicator->unsatisfactory == 1)
                                            <span class="">{{ __('Unsatisfactory') }}</span>
                                            @else
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($indicator->less_than_satisfactory == 1)
                                            <span class="">{{ __('Less than Satisfactory') }}</span>
                                            @else
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif
                                    </td>
                                    </td>
                                    <td>
                                        @if($indicator->full_satisfactory == 1)
                                            <span class="">{{ __('Fully Satisfactory') }}</span>
                                            @else
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($indicator->excellent == 1)
                                            <span class="">{{ __('Excellent') }}</span>
                                            @else
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($indicator->outstanding == 1)
                                            <span class="">{{ __('Outstanding') }}</span>
                                            @else
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif
                                        
                                    </td>
                                  
                                    <td class="Action">
                                        @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                            <span>
                                                @can('Edit Indicator')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('indicator.year.edit', ['id' => $indicator->id]) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Indicator') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Indicator')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['indicator.destroy', $indicator->id], 'id' => 'delete-form-' . $indicator->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                            aria-label="Delete"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        </form>
                                                    </div>
                                                @endcan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12" id="month" style="display: none;">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5> </h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Very Dissatisfactory') }}</th>
                                <th>{{ __('Dissatisfactory') }}</th>
                                <th>{{ __('Neutral') }}</th>
                                <th>{{ __('Satisfactory') }}</th>
                                <th>{{ __('Very Satisfactory') }}</th>
                                @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($monthIndicators))
                                @foreach ($monthIndicators as $indicator)
                                
                                    <tr>
                                        <td><strong>{{ !empty($indicator->title) ? str_replace('_', ' ', $indicator->title) : '' }}</strong></td>

                                        <td>
                                            @if($indicator->six_month == 1)
                                                <span class="">{{ __('Monthly') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($indicator->very_dissatisfactory == 1)
                                                <span class="">{{ __('Very Dissatisfactory') }}</span>
                                                @else 
                                                <span class="">{{ __('N/A') }}</span>
                                            @endif
                                        </td>
                                        </td>
                                        <td>
                                            @if($indicator->dissatisfactory == 1)
                                                <span class="">{{ __('Dissatisfactory') }}</span>
                                                @else
                                                <span class="">{{ __('N/A') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($indicator->neutral == 1)
                                                <span class="">{{ __('Neutral') }}</span>
                                                @else
                                                <span class="">{{ __('N/A') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($indicator->satisfactory == 1)
                                                <span class="">{{ __('Satisfactory') }}</span>
                                                @else
                                                <span class="">{{ __('N/A') }}</span>
                                            @endif
                                            
                                        </td>
                                        <td> @if($indicator->very_satisfactory == 1)
                                            <span class="">{{ __('Unsatisfactory') }}</span>
                                            @else
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif</td>
                                        <td class="Action">
                                            @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                                <span>
                                                    @can('Edit Indicator')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                                data-url="{{ route('indicator.month.edit',['id' => $indicator->id]) }}"
                                                                data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                                title="" data-title="{{ __('Edit Indicator') }}"
                                                                data-bs-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('Delete Indicator')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['indicator.destroy', $indicator->id], 'id' => 'delete-form-' . $indicator->id]) !!}
                                                            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                                aria-label="Delete"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            </form>
                                                        </div>
                                                    @endcan
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @else 
                                <tr>
                                    <td colspan="7" class="text-center">No Data Found</td>
                                </tr>
                            @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12" id="three_month">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5> </h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Average') }}</th>
                                <th>{{ __('Above Average') }}</th>
                                <th>{{ __('Not Observed') }}</th>
                                <th>{{ __('Not Applicable') }}</th>
                                <th>{{ __('Unsatisfactory') }}</th>
                                @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($indicators))
                            @foreach ($indicators as $indicator)
                             
                                <tr>
                                    <td><strong>{{ !empty($indicator->title) ? str_replace('_', ' ', $indicator->title) : '' }}</strong></td>

                                    <td>
                                        @if($indicator->first_month == 1)
                                        <span class="">{{ __('First Month') }}</span>,
                                    @endif
                                    @if($indicator->six_month == 1)
                                        <span class="">{{ __('Six Month') }}</span>,
                                    @endif
                                    @if($indicator->year == 1)
                                        <span class="">{{ __('Year') }}</span>
                                    @endif
                                    </td>
                                    <td>
                                        @if($indicator->average == 1)
                                            <span class="">{{ __('Average') }}</span>
                                            @else 
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif
                                    </td>
                                    </td>
                                    <td>
                                        @if($indicator->above_average == 1)
                                            <span class="">{{ __('Above Average') }}</span>
                                            @else
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($indicator->not_observed == 1)
                                            <span class="">{{ __('Not Observed') }}</span>
                                            @else
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($indicator->not_applicable == 1)
                                            <span class="">{{ __('Not Applicable') }}</span>
                                            @else
                                            <span class="">{{ __('N/A') }}</span>
                                        @endif
                                        
                                    </td>
                                    <td> @if($indicator->unsatisfactory == 1)
                                        <span class="">{{ __('Unsatisfactory') }}</span>
                                        @else
                                        <span class="">{{ __('N/A') }}</span>
                                    @endif</td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                            <span>
                                                @can('Edit Indicator')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('indicator.edit',['id' => $indicator->id]) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Indicator') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Indicator')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['indicator.destroy', $indicator->id], 'id' => 'delete-form-' . $indicator->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                            aria-label="Delete"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        </form>
                                                    </div>
                                                @endcan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-center">No Data Found</td>
                            </tr>
                        @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script src="{{ asset('js/bootstrap-toggle.js') }}"></script>

    <script>
        
        function showIndicators(id) {
            if (id == 'three_month') {
               var three_month = document.getElementById('three_month');
               three_month.style.display = 'block';
               var year = document.getElementById('year');
                year.style.display = 'none';
                var month = document.getElementById('month');
                month.style.display = 'none';
                 
            } else if(id == 'month'){

                var year = document.getElementById('month');
                year.style.display = 'block';
                var three_month = document.getElementById('three_month');
                three_month.style.display = 'none';
                var three_month = document.getElementById('year');
                three_month.style.display = 'none';

            }
            else if(id == 'year'){

                var year = document.getElementById('year');
                year.style.display = 'block';
                var three_month = document.getElementById('three_month');
                three_month.style.display = 'none';
                var month = document.getElementById('month');
                month.style.display = 'none';
            }
            else{
                var year = document.getElementById('year');
                year.style.display = 'none';
                var three_month = document.getElementById('three_month');
                three_month.style.display = 'none';
                var month = document.getElementById('month');
                month.style.display = 'none';
            }
        }



        $('document').ready(function() {
            $('.toggleswitch').bootstrapToggle();
            $("fieldset[id^='demo'] .stars").click(function() {
                alert($(this).val());
                $(this).attr("checked");
            });
        });

        $(document).ready(function() {
            var b_id = $('.branch_id').val();
            getDesignation(b_id);
        });

        $(document).on('change', 'select[name=branch]', function() {
            var branch_id = $(this).val();
            getdepartment(branch_id);
        });

        function getdepartment(bid) {
            $.ajax({
                url: '{{ route('employee.getdepartment') }}',
                type: 'POST',
                data: {
                    "branch_id": bid,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {

                    $('.department_id').empty();
                    var emp_selct = ` <select class="form-control department_id" name="department" id="choices-multiple"
                                            placeholder="Select Department">
                                            </select>`;
                    $('.department_div').html(emp_selct);

                    $('.department_id').append('<option value=""> {{ __('Select Department') }} </option>');
                    $.each(data, function(key, value) {
                        $('.department_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });

                }
            });
        }

        $(document).ready(function() {
            var d_id = $('.department_id').val();
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department]', function() {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        function getDesignation(did) {
            $.ajax({
                url: '{{ route('employee.json') }}',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {

                    $('.designation_id').empty();
                    var emp_selct = ` <select class="form-control  designation_id" name="designation" id="choices-multiple"
                                            placeholder="Select Designation" >
                                            </select>`;
                    $('.designation_div').html(emp_selct);

                    $('.designation_id').append('<option value=""> {{ __('Select Designation') }} </option>');
                    $.each(data, function(key, value) {
                        $('.designation_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });

                }
            });
        }
    </script>
@endpush
