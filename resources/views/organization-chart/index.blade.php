@extends('layouts.admin')

@section('page-title')
    {{ __('Organization Chart') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Organization Chart') }}</li>
@endsection
{{-- {{dd($employees)}}
 @foreach ($employees as $items)
                            {{dd($items->name)}}
                            @endforeach --}}

@section('content')
    <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">


                <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

                <link href="{{ asset('chart/reset-html5.css') }}" rel="stylesheet" media="screen" />
                <link href="{{ asset('chart/micro-clearfix.css') }}" rel="stylesheet" media="screen" />
                <link href="{{ asset('chart/stiff-chart.css') }}" rel="stylesheet" media="screen" />
                <link href="{{ asset('chart/custom.css') }}" rel="stylesheet" media="screen" />
                <style>
                    body {
                        background-color: #fafafa;
                        font-family: 'Roboto';
                    }

                    .the-chart img {
                        height: 120px;
                        width: 120px;
                        object-fit: contain;
                    }
                </style>
                </head>

                <body>

                    <!--[if lt IE 8]>
                                      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
                                      <![endif]-->

                    <div id="your-chart-name">
                        <div class="stiff-chart-inner">

                            <!-- ceo -->
                            @foreach ($employees as $employee)
                                @if ($employee->designation->name == 'CEO')
                                    <div class="stiff-chart-level" data-level="01" id="hide">
                                        <div class="stiff-main-parent">
                                            <ul>
                                                <li data-parent="ceo">
                                                    <div class="the-chart">
                                                        @php
                                                            $logo = '';
                                                            if (!empty($employee->user->avatar)) {
                                                                $logo = asset(url('storage/uploads/avatar')) . '/' . $employee->user->avatar;
                                                            }
                                                        @endphp
                                                        <img src="{{ $logo }}" style="  border-radius: 73px; "
                                                            alt="">
                                                        <h4>{{ $employee->name }}</h4>
                                                        <p>{{ $employee->designation->name }}</p>
                                                        {{-- {{$ceoid = $employee->id}} --}}
                                                        @php
                                                            $ceoid = $employee->id;
                                                        @endphp
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <!-- ceo end -->
                            @php
                                $pmoid = [];
                                $org_row = 0;
                            @endphp


                            <div class="stiff-chart-level" data-level="02">
                                <div class="stiff-child" data-child-from="ceo">
                                    <ul>
                                        @foreach ($employees as $employee)
                                            @if ($employee->team_lead == $ceoid)
                                                <li data-parent="b<?php echo $org_row; ?>">
                                                    <div class="the-chart">
                                                        @php
                                                            $logo = '';
                                                            if (!empty($employee->user->avatar)) {
                                                                $logo = asset(url('storage/uploads/avatar')) . '/' . $employee->user->avatar;
                                                            }
                                                        @endphp
                                                        <img src="{{ $logo }}" alt=""
                                                            style="  border-radius: 73px; ">
                                                        <h4>{{ $employee->name }}</h4>
                                                        <p>{{ $employee->designation->name }}</p>

                                                        @php
                                                            $pmoid[] = $employee->id;
                                                        @endphp
                                                    </div>
                                                </li>
                                                @php
                                                    $org_row++;
                                                @endphp
                                            @endif
                                        @endforeach

                                    </ul>


                                </div>
                            </div>

                            @php
                                $p = 0;
                                $org_row = 0;
                                $org_colum = 0;
                                $tlid = [];
                            @endphp


                            @if (!empty($pmoid))
                                @foreach ($pmoid as $pid)
                                    <div class="stiff-chart-level" data-level="02">
                                        <div class="stiff-child" data-child-from="b<?php echo $org_row; ?>">
                                            <ul>

                                                @foreach ($employees as $employee)
                                                    @php
                                                        $pmoidlenght = count($pmoid);
                                                        if ($p >= $pmoidlenght) {
                                                            break;
                                                        }
                                                    @endphp
                                                    {{-- {{$org_row}} --}}
                                                    {{-- @if ($employee->designation->name == 'Frontend Developer' || $employee->designation->name == 'Software Engineer' || $employee->designation->name == 'HR' || $employee->designation->name == 'Business Developer Manager') --}}
                                                    @if ($employee->team_lead == $pid)
                                                        {{-- @endif --}}

                                                        <li data-parent="b0<?php echo $org_colum; ?>">
                                                            {{-- <p>{{print_r($org_row)}}</p> --}}
                                                            {{-- <p>{{print_r($org_colum)}}</p> --}}
                                                            <div class="the-chart">
                                                                @php
                                                                    $logo = '';
                                                                    if (!empty($employee->user->avatar)) {
                                                                        $logo = asset(url('storage/uploads/avatar')) . '/' . $employee->user->avatar;
                                                                    }
                                                                @endphp
                                                                <img src="{{ $logo }}"
                                                                    style="  border-radius: 73px;" alt="">
                                                                <h4>{{ $employee->name }}</h4>
                                                                <p>{{ $employee->designation->name }}</p>
                                                                @php
                                                                    $tlid[] = $employee->id;

                                                                @endphp


                                                            </div>
                                                        </li>

                                                        @php
                                                            $org_colum++;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                            </ul>

                                        </div>
                                    </div>
                                    @php
                                        $p++;
                                        $org_row++;
                                    @endphp
                                @endforeach
                            @endif


                            @php
                                $f = 0;
                                $c_row = 0;

                                $c_colum = 0;
                            @endphp
                            @if (!empty($tlid))
                                @foreach ($tlid as $tid)
                                    {{-- {{$tid}} --}}

                                    {{-- {{$c_colum}} --}}
                                    <div class="stiff-chart-level" data-level="03">
                                        <div class="stiff-child" data-child-from="b0<?php echo $c_colum; ?>">
                                            <ul>

                                                @foreach ($employees as $employee)
                                                    @php
                                                        $tlidlenght = count($tlid);
                                                        if ($f >= $tlidlenght) {
                                                            break;
                                                        }
                                                    @endphp
                                                    {{-- {{print_r($tid)}} --}}

                                                    @if ($employee->team_lead == $tid)
                                                        {{-- <p>{{print_r($c_colum)}}</p> --}}
                                                        <li data-parent="b01<?php echo $c_colum; ?>">


                                                            <div class="the-chart">
                                                                @php
                                                                    $logo = '';
                                                                    if (!empty($employee->user->avatar)) {
                                                                        $logo = asset(url('storage/uploads/avatar')) . '/' . $employee->user->avatar;
                                                                    }
                                                                @endphp
                                                                <img src="{{ $logo }}"
                                                                    style="  border-radius: 73px;" alt="">
                                                                {{-- <img src="resources/orgchart/img/z.png" style="  border-radius: 73px;" alt=""> --}}
                                                                <p>{{ $employee->name }}</p>
                                                                <h3>{{ $employee->designation->name }}</h3>

                                                                {{-- {{print_r( storage_path().'/uploads/avatar/'.$employee->user->avatar )}} --}}
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>
                                    @php
                                        $f++;
                                        $c_colum++;
                                        //    $c_row++;
                                    @endphp
                                @endforeach
                            @endif





                            <!-- shahid sir -->

                            <div class="stiff-chart-level" data-level="05">
                                <div class="stiff-child" data-child-from="c">

                                </div>
                            </div>


                        </div>
                    </div>

            </div>
        </div>
    </div>



@endsection
