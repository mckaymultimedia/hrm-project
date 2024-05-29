@extends('layouts.admin')


@section('page-title')
    {{ __('Job Graphical Data') }}
@endsection
@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Job graphical data') }}</li>
@endsection


@section('content')
   
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row m-2">
                                <div class=" col-md-6 col-sm-6">
                                    <div class="form-group ">
                                        <label for="Filter" class="mb-2">
                                            {{ __('Filter by name') }}
                                        </label>
                                        @php 
                                        $user = Auth::user();
                                        $employee = $user ? \App\Models\Employee::where('user_id', $user->id)->first() : null;
                                        $type = $employee ? $user->type : null;
                                    @endphp
                                    
                                    <select class="form-control  designation_id select2" name="profile" id="choices-multiple" placeholder="Select profile" required>
                                        <option value="">Select profile</option>
                                        @if($type === 'employee')
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @else
                                            @foreach ($jobProfiles as $jobProfile)
                                                <option value="{{ $jobProfile->id }}">{{ $jobProfile->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    
                                    </div>
                                </div>
                                <div class=" col-md-6 col-sm-6 d-flex align-items-center gap-2">
                                    <div class="form-group ">
                                        {{ Form::label('month', __('Month'), ['class' => 'form-label']) }}
                                        <select class="form-control" style="min-width: 200px;" name="month"
                                            id="choices-month" placeholder="Select month" required>
                                            <option value="">{{ __('Select month') }}</option>
                                            <option value="1">{{ __('January') }}</option>
                                            <option value="2">{{ __('February') }}</option>
                                            <option value="3">{{ __('March') }}</option>
                                            <option value="4">{{ __('April') }}</option>
                                            <option value="5">{{ __('May') }}</option>
                                            <option value="6">{{ __('June') }}</option>
                                            <option value="7">{{ __('July') }}</option>
                                            <option value="8">{{ __('August') }}</option>
                                            <option value="9">{{ __('September') }}</option>
                                            <option value="10">{{ __('October') }}</option>
                                            <option value="11">{{ __('November') }}</option>
                                            <option value="12">{{ __('December') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                                        <select class="form-control" style="min-width: 200px;" name="status"
                                            id="choices-status" placeholder="Select status" required>
                                            <option value="">{{ __('Select status') }}</option>
                                            <option value="1">{{ __('Pending') }}</option>
                                            <option value="2">{{ __('Accepted') }}</option>
                                            <option value="3">{{ __('Rejected') }}</option>
                                        </select>
                                        
                                    </div>
                                    <button class="btn btn-primary mt-1" id="filter">{{ __('Filter') }}</button>
                                </div>

                            </div>
                            <div class="col-md-12 text-center">
                                <span class="text-danger  text-center justify-content-center text-lg"
                                    style="display: none;"
                                 id="error">
                                    No data found.
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="container">

                        <div class="row my-2">
                            <div class="col-md-12 py-1">
                                <div class="card">
                                    <div class="card-body">
                                        <canvas id="chBar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th> {{ __('applied by') }}</th>
                                <th> {{ __('profile') }}</th>
                                <th>{{ __('location') }}</th>
                                <th> {{ __('rating') }}</th>
                                <th> {{ __('platform') }}</th>
                                <th> {{ __('link') }}</th>
                                <th> {{ __('stack') }}</th>
                                <th> {{ __('applied_at') }}</th>
                                <th> {{ __('client_type') }}</th>
                                <th> {{ __('status') }}</th>
                                <th> {{ __('payment_type') }}</th>
                            </tr>
                        </thead>
                        <tbody id="jobDetailsBody">
                            @foreach ($jobDetails as $jobDetail)
                                <tr class="loop_data">
                                
                                    <td>{{ $jobDetail->user->name }}</td>
                                    <td>
                                        {{ $jobDetail->jobProfile->profile_name }}
                                    </td>
                                    <td>{{ $jobDetail->location }}</td>
                                    <td>{{ $jobDetail->rate }}</td>
                                    <td>{{ $jobDetail->platform }}</td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><a style="color: black;" href="{{ $jobDetail->link }}" target="_blank">{{ $jobDetail->link }}</a></td>

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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  
    @endsection
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var colors = ["#28a745", "#007bff", "#333333", "#c3e6cb", "#dc3545"];
            var graphData = @json($graphData);
            var chBar = document.getElementById("chBar");
            var chartInstance; // Chart instance variable
            
            function createOrUpdateChart(data) {
                if (chartInstance) {
                    chartInstance.data.datasets = Object.entries(data).map(([user, weeks], index) => ({
                        label: user,
                        data: weeks.map((value, weekIndex) => value),
                        backgroundColor: colors[index % colors.length] 
                    }));
                    chartInstance.update(); // Update existing chart
                } else {
                    chartInstance = new Chart(chBar, {
                        type: "bar",
                        data: {
                            labels: ["1st week", "2nd week", "3rd week", "4th week"], 
                            datasets: Object.entries(data).map(([user, weeks], index) => ({
                                label: user,
                                data: weeks.map((value, weekIndex) => value),
                                backgroundColor: colors[index % colors.length] 
                            }))
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }],
                                xAxes: [{
                                    barPercentage: 0.2
                                }]
                            }
                        }
                    });
                }
            }
    
            createOrUpdateChart(graphData);
    
            $('#filter').click(function() {
                var profileId = $('#choices-multiple').val();
                var month = $('#choices-month').val();
                var status = $('#choices-status').val();
                if(profileId == '' && month != '') {
                    alert('Please select a profile');
                    return;
                } else {
                    $.ajax({
                        type: 'GET',
                        url: '/bd-job-details',
                        data: {
                            profile_id: profileId,
                            month: month,
                            status: status
                        },
                        success: function(response) {
                            console.log(response);
                            var newData = response.graphData;
                            var jobDetails = response.jobDetails;
                            
                            if(Object.keys(newData).length == 0) {
                                $('#error').show();
                            } else {
                                $('#error').hide();
                            }

                            $('#jobDetailsBody').empty();

                            response.jobDetails.forEach(function(jobDetail) {
                                if(jobDetail.status == 1) {
                                    status = 'Pending';
                                } else if(jobDetail.status == 2) {
                                   status = 'Accepted';
                                } else if(jobDetail.status == 3) {
                                  status = 'Rejected';
                                }
                                var html = '<tr>' +
                                    '<td>' + jobDetail.user.name + '</td>' +
                                    '<td>' + jobDetail.job_profile.profile_name + '</td>' +
                                    '<td>' + jobDetail.location + '</td>' +
                                    '<td>' + jobDetail.rate + '</td>' +
                                    '<td>' + jobDetail.platform + '</td>' +
                                    '<td style="max-width: 200px;color:black; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><a style="color: black;" href="' + jobDetail.link + '" target="_blank">' + jobDetail.link + '</a></td>' +
                                    '<td>' + jobDetail.stack + '</td>' +
                                    '<td>' + jobDetail.applied_at + '</td>' +
                                    '<td>' + jobDetail.client + '</td>' +
                                    '<td>' + status + '</td>' +
                                    '<td>' + jobDetail.payment_type + '</td>' +
                                    '</tr>';

                                $('#jobDetailsBody').append(html);
                            });
                            createOrUpdateChart(newData); 
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>




