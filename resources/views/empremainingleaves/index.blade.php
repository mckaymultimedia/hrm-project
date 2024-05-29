@extends('layouts.admin')

@section('content')
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">

                    <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Sick') }}</th>
                                <th>{{ __('Earned') }}</th>
                                <th>Total Leaves</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ( $manageLeaves  as $leaves )

                            <tr>
                                @php
                                    $employee = App\Models\Employee::where('id', $leaves->employee_id)->first();
                                @endphp
                                <td>{{ $employee->name }}</td>
                                <td>{{$leaves->total_sick_leave}}/{{ $leaves->sick_type }}</td>
                                <td>{{$leaves->total_earn_leave}}/{{ $leaves->earn_type }}</td>
                                <td>{{ $leaves->total_leaves }}</td>
                            </tr>

                          @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
