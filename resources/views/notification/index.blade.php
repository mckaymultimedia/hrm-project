@extends('layouts.admin')

@section('page-title')
  {{ __('Notification') }}
@endsection
@php
$profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Notification') }}</li>
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
                                <th> {{ __('Name') }}</th>
                                <th> {{ __('Email') }}</th>
                                <th>{{__('type')}}</th>
                                <th>{{__('period')}}</th>
                                <th> {{ __('Joining Date') }}</th>
                                <th width="200px">{{ __('Action') }}</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-column">
                                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->type }}</td>
                                    <td>{{ $user->period }}</td>
                                    <td>{{ date('d M Y', strtotime($user->created_at)) }}</td>
                                    <td>
                                        @if($user->period == '3 months')
                                        <a href="#" data-url="{{ route('performance.create') }}" data-ajax-popup="true" data-size="lg"
                                            data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                            {{ __('Probation Form') }}
                                        </a>
                                        @elseif($user->period == '6 months')
                                        <a href="#" data-url="{{ route('performance.create') }}" data-ajax-popup="true" data-size="lg"
                                        data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                        data-bs-original-title="{{ __('Create') }}">
                                        <i class="ti ti-plus"></i>
                                        {{ __('Probation Form') }}
                                    </a>
                                        @elseif($user->period == '1 year')
                                        <a href="#" data-url="{{ route('performance.oneyearCreate') }}" data-ajax-popup="true" data-size="lg"
                                            data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                            {{ __('Yearly Form') }}
                                        </a>
                                        @elseif($user->period == '2 years')
                                        <a href="#" data-url="{{ route('performance.oneyearCreate') }}" data-ajax-popup="true" data-size="lg"
                                            data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                            {{ __('Yearly Form') }}
                                        </a>
                                        @elseif($user->period == '3 years')
                                        <a href="#" data-url="{{ route('performance.oneyearCreate') }}" data-ajax-popup="true" data-size="lg"
                                            data-title="{{ __('Performance Form') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                            {{ __('Yearly Form') }}
                                        </a>
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
