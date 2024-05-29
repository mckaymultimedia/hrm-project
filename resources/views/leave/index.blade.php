@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Leave') }}
@endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Leave ') }}</li>
@endsection

@section('action-button')
    <a href="{{ route('leave.export') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
        data-bs-original-title="{{ __('Export') }}">
        <i class="ti ti-file-export"></i>
    </a>

    @can('Create Leave')
        @if (\Auth::user()->type == 'employee')
            <a href="#" data-url="{{ route('leave.create') }}" data-ajax-popup="true" data-title="{{ __('Create Leave') }}"
                data-size="lg" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endif
    @endcan
    @if (\Auth::user()->type != 'employee')
        <a href="#" data-url="{{ route('CompanyLeaveCreate') }}" data-ajax-popup="true"
            data-title="{{ __('Add Leave') }}" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endif
@endsection
{{-- {{dd($totalTeam)}} --}}
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5> </h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Leave Type') }}</th>
                                <th>{{ __('Applied On') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Total Days') }}</th>
                                <th>{{ __('Leave Reason') }}</th>
                                {{-- <th>{{ __('Leave Reason') }}</th> --}}
                                <th>{{ __('status') }}</th>
                                <th>Approve By</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{print_r($totalTeam)}} --}}
                            {{-- @foreach ($empleave as $e)
                                @if ($e->designation->name == 'Project Manager' || $e->designation->name == 'Software Engineer')
                                        {{$teamlead_id[] = $e->id}}
                                @endif
                            @endforeach
                            @foreach ($teamlead_id as $tid)
                                @foreach ($empleave as $e)
                                {{$length = count($teamlead_id) }}
                                    @if ($e->teamlead_name == $tid)



                                    @endif
                                @endforeach

                            @endforeach
                            {{print_r($tid)}} --}}
                            @foreach ($leaves as $leave)
                                <tr>
                                    <td>{{ !empty(\Auth::user()->getEmployee($leave->employee_id)) ? \Auth::user()->getEmployee($leave->employee_id)->name : '' }}
                                    </td>
                                    {{--  <td>{{ $leave->employees->EmployeeLeaves->title}}</td>  --}}
                                    <td>{{ !empty(\Auth::user()->getLeaveType($leave->leave_type_id)) ? \Auth::user()->getLeaveType($leave->leave_type_id)->title : '' }}
                                    <td>{{ \Auth::user()->dateFormat($leave->applied_on) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>

                                    <td>{{ $leave->total_leave_days }}</td>
                                    <td>{{ $leave->leave_reason }}</td>
                                    {{-- <td>{{ $leave->employees->teamleads_email($leave->employees->teamlead_name) }}</td> --}}


                                    <td>

                                        @if ($leave->status == 'Pending')
                                            <div class="badge bg-warning p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @elseif($leave->status == 'Approved')
                                            <div class="badge bg-success p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @elseif($leave->status == 'Reject')
                                            <div class="badge bg-danger p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @elseif($leave->status == 'Delete')
                                            <div class="badge bg-primary p-2 px-3 rounded">{{ $leave->status }}</div>
                                            @elseif($leave->status != 'Approved'&& $leave->status != 'Reject' && $leave->status != 'Delete' && $leave->status != 'Pending')
                                            <div class="badge bg-primary p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($leave->tl_approve == 0 || $leave->status == 'Pending')
                                            <div class="alert alert-primary mb-0" role="alert">Pending By Lead!</div>
                                        @elseif ($leave->tl_approve == 1 || $leave->status == 'Approved')
                                            <div class="alert alert-success mb-0" role="alert">Approved By Lead!</div>
                                        @elseif($leave->tl_approve == 2 || $leave->status == 'Reject')
                                            <div class="alert alert-danger mb-0" role="alert">Reject By Lead!</div>
                                        @endif
                                    </td>

                                    <td class="Action">
                                        <span>
                                            @if (\Auth::user()->type == 'employee' || \Auth::user()->name == 'Shahid Iqbal')
                                                @if ($leave->status == 'Pending')
                                                    @can('Edit Leave')

                                                        @foreach ($empleave as $empl)
                                                            @if (Auth::user()->employee->id == 'Software Engineer')
                                                                {{-- {{dd('hello world')}} --}}
                                                                {{-- {{dd($empl->name)}} --}}
                                                                <div class="action-btn bg-success ms-2">
                                                                    <a href="#"
                                                                        class="mx-3 btn btn-sm  align-items-center"
                                                                        data-size="lg"
                                                                        data-url="{{ URL::to('leave/' . $leave->id . '/action') }}"
                                                                        data-ajax-popup="true" data-size="md"
                                                                        data-bs-toggle="tooltip" title=""
                                                                        data-title="{{ __('Leave Action') }}"
                                                                        data-bs-original-title="{{ __('Manage Leave') }}">
                                                                        <i class="ti ti-caret-right text-white"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endcan
                                                @endif
                                            @else
                                                @if ($leave->status !== 'Approved' && $leave->total_leave_days > 1)
                                                    <div class="action-btn bg-success ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                            data-size="lg"
                                                            data-url="{{ URL::to('leave/' . $leave->id . '/action') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Leave Action') }}"
                                                            data-bs-original-title="{{ __('Manage Leave') }}">
                                                            <i class="ti ti-caret-right text-white"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                {{--  @can('Edit Leave')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ URL::to('leave/' . $leave->id . '/edit') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Leave') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan  --}}
                                            @endif

                                            @if ($leave->status !== 'Approved' && $leave->status !== 'Delete' && $leave->status !== 'Reject' && $leave->status !== 'Pending')   
                                                @can('Delete Leave')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['leave.destroy', $leave->id],
                                                            'id' => 'delete-form-' . $leave->id,
                                                            'class' => 'mb-0',
                                                        ]) !!}
                                                        <a href="#"
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        </form>
                                                    </div>
                                                @endcan
                                            @endif
                                        </span>

                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

















    {{--  {{ dd($CurrentLeavesDays) }}  --}}



    <h4 class="m-b-10">Associate Employees</h4>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5> </h5> --}}
                <div class="table-responsive">
                    <table class="table" id="data_tables_teamlead">
                        <thead>
                            <tr>
                                <th>{{ __('Employee') }}</th>

                                <th>{{ __('Leave Type') }}</th>
                                <th>{{ __('Applied On') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Total Days') }}</th>
                                <th>{{ __('Leave Reason') }}</th>
                                {{-- <th>{{ __('Leave Reason') }}</th> --}}
                                <th>{{ __('status') }}</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{print_r($totalTeam)}} --}}
                            {{-- @foreach ($empleave as $e)
                                @if ($e->designation->name == 'Project Manager' || $e->designation->name == 'Software Engineer')
                                        {{$teamlead_id[] = $e->id}}
                                @endif
                            @endforeach
                            @foreach ($teamlead_id as $tid)
                                @foreach ($empleave as $e)
                                {{$length = count($teamlead_id) }}
                                    @if ($e->teamlead_name == $tid)



                                    @endif
                                @endforeach

                            @endforeach
                            {{print_r($tid)}} --}}
                            {{--  {{ dd($totalTeam) }}  --}}
                            {{--  @foreach ($totalTeam as $items)  --}}
                            @foreach ($TeamLeadEmpLeaves as $leave)
                                {{--  {{ print_r($leave->total_leave_days	) }}  --}}
                                <tr>


                                    <td>{{ !empty(\Auth::user()->getEmployee($leave->employee_id)) ? \Auth::user()->getEmployee($leave->employee_id)->name : '' }}
                                    </td>
                                    {{--  <td>{{ $leave->employees->EmployeeLeaves->title }}</td>  --}}
                                    <td>{{ !empty(\Auth::user()->getLeaveType($leave->leave_type_id)) ? \Auth::user()->getLeaveType($leave->leave_type_id)->title : '' }}
                                    <td>{{ \Auth::user()->dateFormat($leave->applied_on) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>

                                    <td>{{ $leave->total_leave_days }}</td>
                                    {{--  {{ dd($leave->total_leave_days) }}  --}}
                                    <td>{{ $leave->leave_reason }}</td>
                                    {{-- <td>{{ $leave->employees->teamleads_email($leave->employees->teamlead_name) }}</td> --}}
                                    <td>
                                        @if ($leave->status == 'Pending')
                                            <div class="badge bg-warning p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @elseif($leave->status == 'Approved')
                                            <div class="badge bg-success p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @elseif($leave->status == 'Reject')
                                            <div class="badge bg-danger p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @elseif($leave->status == 'Delete')
                                            <div class="badge bg-primary p-2 px-3 rounded">{{ $leave->status }}</div>
                                            @elseif($leave->status != 'Approved'&& $leave->status != 'Reject' && $leave->status != 'Delete' && $leave->status != 'Pending')
                                            <div class="badge bg-primary p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @endif
                                    </td>
                                    @if ($leave->status !== 'Approved' && $leave->status !== 'Delete')
                                        <td class="Action">
                                            <span style="display: flex;align-items:center;">
                                                @if (\Auth::user()->type == '')
                                                    @if ($leave->status == 'Pending')
                                                        {{--  @can('Edit Leave')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                                data-size="lg"
                                                                data-url="{{ URL::to('leave/' . $leave->id . '/edit') }}"
                                                                data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                                title="" data-title="{{ __('Edit Leave') }}"
                                                                data-bs-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>

                                                    @endcan  --}}
                                                    @endif
                                                @else
                                                    @if ($leave->status == 'Pending')
                                                        <div class="action-btn bg-success ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                                data-size="lg"
                                                                data-url="{{ URL::to('leave/' . $leave->id . '/action') }}"
                                                                data-ajax-popup="true" data-size="md"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-title="{{ __('Leave Action') }}"
                                                                data-bs-original-title="{{ __('Manage Leave') }}">
                                                                <i class="ti ti-caret-right text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    {{--  @can('Edit Leave')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ URL::to('leave/' . $leave->id . '/edit') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Leave') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan  --}}
                                                @endif

                                                @if ($leave->status !== 'Approved' && $leave->status !== 'Delete')
                                                    @can('Delete Leave')
                                                        <div class="action-btn bg-danger ms-2" style="padding-top: 17px;">
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['leave.destroy', $leave->id],
                                                                'id' => 'delete-form-' . $leave->id,
                                                            ]) !!}
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            </form>
                                                        </div>
                                                    @endcan
                                                @endif
                                            </span>

                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            {{--  @endforeach  --}}
                        </tbody>
                    </table>
                    {{--  @foreach ($totalTeam as $items)
                        {{ $items->links() }}
                    @endforeach  --}}
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .alert {
        padding: 5px 2px !important;
        text: center;
        font-size: 12px;
    }
</style>

@push('script-page')
    <script>
        $(document).on('change', '#employee_id', function() {
            var employee_id = $(this).val();

            $.ajax({
                url: '{{ route('leave.jsoncount') }}',
                type: 'POST',
                data: {
                    "employee_id": employee_id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {

                    $('#leave_type_id').empty();
                    $('#leave_type_id').append(
                        '<option value="">{{ __('Select Leave Type') }}</option>');

                    $.each(data, function(key, value) {

                        if (value.total_leave == value.days) {
                            $('#leave_type_id').append('<option value="' + value.id +
                                '" disabled>' + value.title + '&nbsp(' + value.total_leave +
                                '/' + value.days + ')</option>');
                        } else {
                            $('#leave_type_id').append('<option value="' + value.id + '">' +
                                value.title + '&nbsp(' + value.total_leave + '/' + value
                                .days + ')</option>');
                        }
                    });

                }
            });
        });
    </script>
@endpush
