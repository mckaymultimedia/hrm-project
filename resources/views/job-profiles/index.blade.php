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
        <a href="#" data-url="{{ route('job-profile.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create Profile') }}" data-size="lg" data-bs-toggle="tooltip" title=""
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
                                <th> {{ __('profile') }}</th>
                                <th>{{ __('stack') }}</th>
                                <th> {{ __('platform') }}</th>
                                <th> {{ __('email') }}</th>
                                <th> {{ __('contact') }}</th>
                                <th> {{ __('linkdin') }}</th>
                                <th> {{ __('github') }}</th>
                                @if (Gate::check('Edit Assets') || Gate::check('Delete Assets'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobProfiles as $jobDetail)
                                <tr>
                                    <td>{{ $jobDetail->profile_name }}</td>
                                    <td>{{ $jobDetail->stack }}</td>    
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $jobDetail->platform }}</td>
                                    <td>{{ $jobDetail->email }}</td>
                                    <td>{{ $jobDetail->contact }}</td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><a style="color: black" href="{{ $jobDetail->linkdin }}" target="_blank">{{ $jobDetail->linkdin }}</a></td>  
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" ><a style="color: black" href="{{ $jobDetail->github }}" target="_blank">{{ $jobDetail->github }}</a></td>
                                                                
                                    <td class="Action">
                                        <span>
                                            @can('Edit Assets')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" data-size="lg" class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="{{ route('job-profile.edit', $jobDetail->id) }}"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                        data-title="{{ __('Edit Profile') }}"
                                                        data-bs-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('Delete Assets')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['job-profile.destroy', $jobDetail->id], 'id' => 'delete-form-' . $jobDetail->id]) !!}
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
