@extends('superadmin::layouts.master')

@section('css')
    <style>
        .total-card {
            box-shadow: 0px 9px 20px rgba(46, 35, 94, 0.07);
            border-radius: 16px;
            background-color: white;
            padding: 10px;
        }

        .total-count {
            width: 35px;
            height: 35px;
            border: 2px dashed #49BEFF;
            text-align: center;
            border-radius: 9px;
            padding: 5px;
        }

        .total-img {
            width: 40px;
            height: 40px;
            border: 2px dashed #9c27b0;
            text-align: center;
            border-radius: 8px;
            padding: 5px;
        }

        .click-icon {
            text-align: center;
        }

        .click-icon-img {
            width: 78px;
            height: 78px;
            text-align: center;
            border-radius: 50%;
            margin: auto;
        }

        .click-icon-img img {
            display: inline-block !important;
            width: 70% !important;
            height: auto !important;
        }

        .owl-carousel {
            direction: ltr !important;
        }

        .click-icon-img-r {
            width: 78px;
            height: 78px;
            border: 2px dashed var(--main-color);
            text-align: center;
            border-radius: 50%;
            animation: lds-dual-ring 10.2s linear infinite;
        }

        .links-container {
            box-shadow: 0px 9px 20px rgba(46, 35, 94, 0.07);
        }

        .logo-container {
            width: 150px;
            top: -50px;
            background-color: white;
            border-top-left-radius: 50%;
            border-top-right-radius: 50%;
            text-align: center;
        }

        .item {
            width: 150px;
        }



        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
@endsection

@section('content')
    <div class="row pb-5 pt-4">

        @foreach ($totals as $total)
        @if ($total['show'])
            <div class="col-lg-3 col-md-4 col-sm-4 p-1">
                <a href="{{ $total['href'] ?? '#' }}" class="text-dark">
                <div class="d-flex align-items-center total-card w3-animate-zoom">
                    <div class="flex-shrink-0 total-img">
                        <img class="w3-animate-zoom" src="{{ $total['img'] }}" width="100%" alt="...">
                    </div>
                    <div class="flex-grow-1 ml-3 w3-padding">
                        <b>{{ $total['label'] }}</b>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="total-count">
                            <b>{{ $total['count'] }}</b>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        @endif
        @endforeach

    </div>
    <br>
    {{-- <div class="row">
        <div class="col-md-4">
            <div class="card bg-primry">
                <div class="card-header p-2 bg-primary">
                    <h5>{{ __('lang.top_student_in_last_exam') }}</h5>
                </div>
                <div class="card-body p-2">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('lang.student') }}</th>
                                <th>{{ __('lang.exam') }}</th>
                                <th>{{ __('lang.grade') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topStudentInLastExam as $student)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <<td>{{ optional($student->user)->first_name ." " . optional($student->user)->last_name }}</td>
                                    <td>{{ optional($student->exam)->title }}</td>
                                    <td>  {{ $student->grade }} / {{ $student->student_grade }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primry">
                <div class="card-header p-2 bg-primary">
                    <h5>{{ __('lang.the_least_five_students_in_the_current_exam') }}</h5>
                </div>
                <div class="card-body p-2">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('lang.student') }}</th>
                                <th>{{ __('lang.exam') }}</th>
                                <th>{{ __('lang.grade') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lastStudentInLastExam as $student)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                   <td>{{ optional($student->user)->first_name ." ". optional($student->user)->last_name}}</td>
                                    <td>{{ optional($student->exam)->title }}</td>
                                   <td>  {{ $student->grade }} / {{ $student->student_grade ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header p-3 bg-primary">
                    <b>{{ __('lang.rate_of_success') }}</b>

                </div>
                <div class="card-body d-flex gap-3 p-3 justify-content-between">
                    <div class=" d-flex flex-column gap-4">
                        <div class="">
                            <b for="">{{ __('lang.count') . ' ' .__('lang.students') }} : {{ $data['totalStudents'] }}</b>

                        </div>
                        <div class="">
                            <b for="">{{ __('lang.count') . ' ' .__('lang.students') .' ' .__('lang.passed') }} : {{ $data['totalStudentExam'] }}</b>

                        </div>
                        <div class="">
                            <b for="">{{ __('lang.count') . ' ' .__('lang.students') .' ' .__('lang.faild') }} : {{ $data['totalFiledStudentExam'] }}</b>

                        </div>
                        <div class="">
                            <b for="">{{ __('lang.examAvgGrade')}} : {{ $data['examAvgGrade'] }}</b>

                        </div>
                    </div>
                    <div>
                        <input type="text" readonly data-bgColor="#9c69f830" style="margin-{{ isRtl() ? 'right':'left' }}: -115px;"  data-width="150"  data-fgColor="#446cbd"value="{{ round($data['successPercentage'] ,1) }}" class="dial">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
<script type="text/javascript">
    $(function() {
        $(".dial").knob();
    });
</script>
@endsection
