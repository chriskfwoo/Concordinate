@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>

                <div class="panel-body">
                    <form role="form" action="{{ url('/scheduler/generate') }}" method="get" class="login-form">
                        <div class="row">
                            @foreach ($courses as $course)
                                <input type="checkbox" name="courses[]" class="vis-hidden"
                                    id = "{{$course->id}}" 
                                    value = "{{$course->id}}">
                                <label class="course-label"  for="{{$course->id}}">{{$course->id}}</label>
                            @endforeach
                        </div>
                        <button type="submit" class="btn completed-btn">Generate Schedule</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
