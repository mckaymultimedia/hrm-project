@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Employee Leaves') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ url('employee') }}">{{ __('Employee') }}</a></li>
    <li class="breadcrumb-item">{{ __('Manage Leaves') }}</li>
@endsection

@section('content')
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>

    <form class="form-horizontal" action="{{ route('employee.leaves.update', $employee->id) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12 ">
                <div class="card ">
                    <div class="card-header">
                        <h5>{{ __('Employee Detail') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Employee ID') }}</label>
                                    <input type="text" class="form-control" name="employee_id"
                                        value="{{ $employeesId }}" disabled>
                                </div>
                            </div>
                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $employee->name }}"
                                        disabled>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Earn Leaves') }}</label>
                                    <input type="text" class="form-control" name="earn_leaves" id="earn_leaves"
                                           value="{{ old('earn_leaves', optional($manage_leaves)->earn_type) }}" required>
                                    <div id="earnLeavesError" class="text-danger"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Sick Leaves') }}</label>
                                    <input type="text" class="form-control" name="sick_leaves" id="sick_leaves"
                                        value="{{ old('sick_leaves', optional($manage_leaves)->sick_type)  }}" required>
                                    <div id="sickLeavesError" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Remarks') }}</label>
                                    <textarea class="form-control" name="remarks">{{ $manage_leaves->title  ?? ''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (\Auth::user()->type != 'employee')
            <div class="float-end">
                <button type="submit" class="btn  btn-primary">{{ 'Update' }}</button>
            </div>
        @endif
    </form>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var earnLeavesInput = document.getElementById('earn_leaves');
        var sickLeavesInput = document.getElementById('sick_leaves');
        var earnLeavesError = document.getElementById('earnLeavesError');
        var sickLeavesError = document.getElementById('sickLeavesError');

        earnLeavesInput.addEventListener('input', function() {
            var inputValue = earnLeavesInput.value.trim();
            var isValid = /^\d+(\.\d{1,2})?$/.test(inputValue);

            if (!isValid) {
                earnLeavesError.textContent = 'Please enter a valid number';
            } else {
                earnLeavesError.textContent = '';
            }
        });
        sickLeavesInput.addEventListener('input', function() {
            var inputValue = sickLeavesInput.value.trim();
            var isValid = /^\d+(\.\d{1,2})?$/.test(inputValue);

            if (!isValid) {
                sickLeavesError.textContent = 'Please enter a valid number';
            } else {
                sickLeavesError.textContent = '';
            }
        });
    });
</script>
