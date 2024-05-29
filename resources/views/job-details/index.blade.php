@extends('layouts.admin')

@section('page-title')
  {{ __('Manage Job Details') }}
@endsection
@php
$profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Job Details') }}</li>
@endsection

@section('action-button')
        <a href="#" data-url="{{ route('job-details.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create Job Details') }}" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
@endsection


@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5></h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th> {{ __('applied by') }}</th>
                                <th> {{ __('profile') }}</th>
                                <th>{{ __('location') }}</th>
                                <th> {{ __('rate') }}</th>
                                <th> {{ __('platform') }}</th>
                                <th> {{ __('link') }}</th>
                                <th> {{ __('stack') }}</th>
                                <th> {{ __('applied_at') }}</th>
                                <th> {{ __('client_type') }}</th>
                                <th> {{ __('status') }}</th>
                                <th> {{ __('payment_type') }}</th>
                                @if (Gate::check('Edit Assets') || Gate::check('Delete Assets'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobDetails as $jobDetail)
                                <tr>
                                      @php 
                                        $profile_name = \App\Models\JobProfile::where('id', $jobDetail->profile)->first();
                                        $applied_name = \App\Models\Employee::where('id', $jobDetail->user_id)->first();
                                        
                                      @endphp
                                    <td>{{ $applied_name->name }}</td>
                                    <td>
                                        {{ $profile_name->profile_name }}
                                    </td>
                                    <td>{{ $jobDetail->location }}</td>
                                    <td>{{ $jobDetail->rate }}</td>
                                    <td>{{ $jobDetail->platform }}</td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $jobDetail->link }}</td>

                                    <td>{{ $jobDetail->stack }}</td>
                                    <td>{{ $jobDetail->applied_at }}</td>
                                    <td>{{ $jobDetail->client }}</td>
                                    <td>
                                        @if ($jobDetail->status == '1')
                                            <span >{{ __('Pending') }}</span>
                                        @elseif($jobDetail->status == '2')
                                            <span >{{ __('Accepted') }}</span>
                                        @elseif($jobDetail->status == '3')
                                            <span >{{ __('Rejected') }}</span>
                                        @endif
                                        
                                    </td>
                                    <td>{{ $jobDetail->payment_type }}</td>


                                  
                                    <td class="Action">
                                        <span>
                                            @can('Edit Assets')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" data-size="lg" class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="{{ route('job-details.edit', $jobDetail->id) }}"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                        data-title="{{ __('Edit Job Details') }}"
                                                        data-bs-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('Delete Assets')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['job-details.destroy', $jobDetail->id], 'class' => 'delete inline']) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete"><i class="ti ti-trash text-white "></i></a>
                                                    </form>
                                                </div>
                                            @endcan
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
@endsection
