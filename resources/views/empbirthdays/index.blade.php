@extends('layouts.admin')

@section('content')
        {{--  <div class="col-3">
            @include('layouts.hrm_setup')
        </div>  --}}
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h2>Upcoming Birthdays</h2>
                    <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Id') }}</th>
                                <th>{{ __('Employee Name') }}</th>
                                <th>{{ __('Birthday Date') }}</th>
                                {{--  <th width="200px">{{ __('Action') }}</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{--  $sr_no = 1;  --}}
                            @foreach ($emp as $e)
                                <tr>
                                    <td>{{ $e->user_id }}</td>
                                    <td>{{ $e->name }}</td>
                                    <td>{{ date('d-M', strtotime($e->dob));}}</td>
                                    {{--  <td class="Action">
                                        <span>
                                            @can('Edit Leave Type')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="{{ URL::to('leavetype/' . $leavetype->id . '/edit') }}"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                        data-title="{{ __('Edit Leave Type') }}"
                                                        data-bs-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('Delete Leave Type')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['leavetype.destroy', $leavetype->id], 'id' => 'delete-form-' . $leavetype->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete"><i
                                                            class="ti ti-trash text-white "></i></a>
                                                    </form>
                                                </div>
                                            @endcan
                                        </span>
                                    </td>  --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
