@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Performance') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Performance Form') }}</li>
@endsection

@section('action-button')
@can('Create Indicator')
<a href="#" data-url="{{ route('performance.oneyearCreate') }}" data-ajax-popup="true" data-size="lg"
    data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
    data-bs-original-title="{{ __('Create') }}">
    <i class="ti ti-plus"></i>
    {{ __('Yearly Form') }}
</a>
@endcan
@can('Create Indicator')
<a href="#" data-url="{{ route('performance.monthly') }}" data-ajax-popup="true" data-size="lg"
    data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
    data-bs-original-title="{{ __('Create') }}">
    <i class="ti ti-plus"></i>
    {{ __('Monthly Form') }}
</a>
@endcan
    @can('Create Indicator')
    <a href="#" data-url="{{ route('performance.create') }}" data-ajax-popup="true" data-size="lg"
        data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Create') }}">
        <i class="ti ti-plus"></i>
        {{ __('Probation Form') }}
    </a>
    @endcan
    @can('Create Indicator')
    <a href="#" data-url="{{ route('performance.bd') }}" data-ajax-popup="true" data-size="lg"
        data-title="{{ __('BD evaluation Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Create') }}">
        <i class="ti ti-plus"></i>
        {{ __('Bd Form') }}
    </a>
    @endcan
@endsection





@section('content')


@php 
    $user_id = \Auth::user()->id;
    $team_lead = \App\Models\Employee::where('team_lead', $user_id)->first();
@endphp

@if($team_lead)
    <div style="display: flex;justify-content: flex-end;align-items: center;margin-bottom:20px; gap:5px;" class="col-12">
        <a href="#" data-url="{{ route('performance.oneyearCreate') }}" data-ajax-popup="true" data-size="lg"
        data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Create') }}">
        <i class="ti ti-plus"></i>
        {{ __('Yearly Form') }}
    </a>


    <a href="#" data-url="{{ route('performance.create') }}" data-ajax-popup="true" data-size="lg"
        data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Create') }}">
        <i class="ti ti-plus"></i>
        {{ __('Probation Form') }}
    </a>
    <a href="#" data-url="{{ route('performance.monthly') }}" data-ajax-popup="true" data-size="lg"
        data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Create') }}">
        <i class="ti ti-plus"></i>
        {{ __('Monthly Form') }}
    </a>
    <a href="#" data-url="{{ route('performance.bd') }}" data-ajax-popup="true" data-size="lg"
        data-title="{{ __('BD evaluation Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Create') }}">
        <i class="ti ti-plus"></i>
        {{ __('Bd Form') }}
    </a>
    </div>
       
@endif

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="table-responsive">
                   @if (\Auth::user()->can('Manage Indicator'))
                    <div style="padding: 6px 34px 0px 26px;" class="col-4 mt-2">
                        <select class="form-control" name="branch" id="branch">
                            <option value="">{{ __('All Employee') }}</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                   @endif

                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Month') }}</th>
                                <th>{{ __('Form Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                
                                <th>{{ __('Created At') }}</th>
                                @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($performance_forms as $performance)
                                <tr>
                                    <td>{{ $performance->id }}</td>
                                    @php
                                        $employeeName = \App\Models\Employee::where('id', $performance->employee_id)->pluck('name')->first();
                                        
                                        $get_team_lead = \App\Models\Employee::where('id', $performance->employee_id)->first();
                                        
                                    @endphp
                                    <td>{{ $employeeName}}</td>
                                    <td>{{ $performance->department }}</td>
                                    <td>{{ $performance->designation }}</td>

                                    {{-- <td>{{ isset($performance->overall_evaluation) ? $performance->overall_evaluation : '' }}</td> --}}


                                    <td>{{ \Carbon\Carbon::parse($performance->created_at)->format('F') }}</td>
                                    <td>
                                        @if ($performance->form_name == 'first_month')
                                            {{ __('Probation Form') }}
                                        @elseif($performance->form_name == 'year')
                                            {{ __('Yearly Form') }}
                                        @elseif($performance->form_name == 'bd_performance')
                                            {{ __('BD evaluation Form') }}
                                        @elseif($performance->form_name == 'six_month')
                                            {{ __('Monthly Form') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($performance->status == 'team lead')
                                            <span class="bd-primary" style="background: #4949cd;border-radius:6px;padding:5px;color:white">
                                                Filled by lead</span>
                                        @elseif ($performance->status == 'hr')
                                            <span class="bd-orange" style="background: #f0ad4e;border-radius:6px;padding:5px;color:white">
                                                Approved by HR</span>
                                        @elseif ($performance->status == 'admin')
                                            <span class="bd-success" style="background: #5cb85c;border-radius:6px;padding:5px;color:white">
                                                Approved by Admin</span>
                                        @endif
                                    </td>

                                    <td>{{ \Carbon\Carbon::parse($performance->created_at)->format('d M Y') }}</td>

                                    <td class="Action">
                                        @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                            <span>
                                                @can('Show Indicator')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                            data-size="lg"
                                                            @if($performance->form_name == 'first_month'){
                                                            data-url="{{ route('performance.show', $performance->id) }}"
                                                            }
                                                            @elseif($performance->form_name == 'year'){
                                                            data-url="{{ route('performance.Yearshow', $performance->id) }}"
                                                            }
                                                            @elseif($performance->form_name == 'bd_performance'){
                                                            data-url="{{ route('performance.Bdshow', $performance->id) }}"
                                                            }
                                                            @elseif($performance->form_name == 'six_month'){
                                                            data-url="{{ route('performance.monthly.show', $performance->id) }}"
                                                            }

                                                            @endif
                                                            data-url="{{ route('performance.show',$performance->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Performance Detail ') }}"
                                                            data-bs-original-title="{{ __('View') }}">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                    
                                                @endcan
                                                @can('Edit Indicator')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                            data-size="lg"
                                                            @if($performance->form_name == 'first_month'){
                                                            data-url="{{ route('performance.edit', $performance->id) }}"
                                                            }
                                                            @elseif($performance->form_name == 'year'){
                                                            data-url="{{ route('performance.Yearedit', $performance->id) }}"
                                                            }
                                                            @elseif($performance->form_name == 'bd_performance'){
                                                            data-url="{{ route('performance.Bdedit', $performance->id) }}"
                                                            }
                                                            @elseif($performance->form_name == 'six_month'){
                                                            data-url="{{ route('performance.monthly.edit', $performance->id) }}"
                                                            }
                                                            @endif
                                                            
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Performance') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                    
                                                @endcan

                                                @can('Delete Indicator')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['performance.destroy', $performance->id],
                                                            'id' => 'delete-form-' . $performance->id,
                                                        ]) !!}
                                                        <a href="#"
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        </form>
                                                    </div>
                                                @endcan

                                                @else
                                                @if($performance->status == 'admin' && $get_team_lead->team_lead !== $user_id)
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-size="lg"
                                                        @if($performance->form_name == 'first_month'){
                                                        data-url="{{ route('performance.show', $performance->id) }}"
                                                        }
                                                        @elseif($performance->form_name == 'year'){
                                                        data-url="{{ route('performance.Yearshow', $performance->id) }}"
                                                        }

                                                        @elseif($performance->form_name == 'bd_performance'){
                                                        data-url="{{ route('performance.Bdshow', $performance->id) }}"
                                                        }
                                                        @elseif($performance->form_name == 'six_month'){
                                                        data-url="{{ route('performance.monthly.show', $performance->id) }}"
                                                        }

                                                        @endif
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                        title="" data-title="{{ __('Performance Detail ') }}"
                                                        data-bs-original-title="{{ __('View') }}">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                                @endif

                                        






                                                @if($get_team_lead->team_lead == $user_id)
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-size="lg"
                                                        @if($performance->form_name == 'first_month'){
                                                        data-url="{{ route('performance.show', $performance->id) }}"
                                                        }
                                                        @elseif($performance->form_name == 'year'){
                                                        data-url="{{ route('performance.Yearshow', $performance->id) }}"
                                                        }

                                                        @elseif($performance->form_name == 'bd_performance'){
                                                        data-url="{{ route('performance.Bdshow', $performance->id) }}"
                                                        }
                                                        @elseif($performance->form_name == 'six_month'){
                                                        data-url="{{ route('performance.monthly.show', $performance->id) }}"
                                                        }

                                                        @endif
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                        title="" data-title="{{ __('Performance Detail ') }}"
                                                        data-bs-original-title="{{ __('View') }}">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                                @endif

                                                
                                                @if($get_team_lead->team_lead == $user_id)
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-size="lg"
                                                        @if($performance->form_name == 'first_month'){
                                                        data-url="{{ route('performance.edit', $performance->id) }}"
                                                        }
                                                        @elseif($performance->form_name == 'year'){
                                                        data-url="{{ route('performance.Yearedit', $performance->id) }}"
                                                        }
                                                        @elseif($performance->form_name == 'bd_performance'){
                                                        data-url="{{ route('performance.Bdedit', $performance->id) }}"
                                                        }
                                                        @elseif($performance->form_name == 'six_month'){
                                                        data-url="{{ route('performance.monthly.edit', $performance->id) }}"
                                                        }
                                                        @endif
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                        title="" data-title="{{ __('Edit Performance') }}"
                                                        data-bs-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                                @endif
                                                
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
@endsection

@push('script-page')
    <script src="{{ asset('js/bootstrap-toggle.js') }}"></script>

    <script>
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
    </script>
@endpush
