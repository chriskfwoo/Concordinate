@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                    <p style="text-align:center; padding-top:20px"><strong>Welcome to the scheduler where you create schedules for your Program Sequence Plan!</strong></p>
                <div class="panel-heading"></div>
                  <p style="text-align:center; padding-top:20px"><i>Instruction: Please set your preferences and course selections.</i></p>

                  <p style="text-align:center";>
                    <i>The color of the course box represents which semester the course is available.</i>
                    <div class="color-container">
                        <div class="input-color">
                            <input type="text" value="Fall" />
                            <div class="color-box" style="background-color: #FF851B;"></div>
                        </div>
                        <div class="input-color">
                            <input type="text" value="Winter" />
                            <div class="color-box" style="background-color: #0074D9;"></div>
                        </div>
                        <div class="input-color">
                            <input type="text" value="Both" />
                            <div class="color-box" style="background-color: #d9534f;"></div>
                        </div>
                    </div>
                  </p>
                <div class="panel-body">
                    <form role="form" action="{{ url('/scheduler/generate') }}" method="get" class="login-form" onsubmit="return checkCourse(this)">

                    <ul class="tab">
                      <li><a href="javascript:void(0)" class="tablinks" onclick="dispPref(event, 'course-select')" id="defaultOpen">Select Courses</a></li>
                      <li><a href="javascript:void(0)" class="tablinks" onclick="dispPref(event, 'time-pref')">Time constraints</a></li>
                    <!--   <li><a href="javascript:void(0)" class="tablinks" onclick="dispPref(event, 'preferences')">Basic Preferences</a></li> -->
                    </ul>

                    <div id="course-select" class="tabcontent">
                    Semester: <input type="radio" name="semester" value="fall" onclick="dispCourse(this.value);"> Fall    &nbsp;  &nbsp;
                            <input type="radio" name="semester" value="winter" onclick="dispCourse(this.value);"> Winter<br>

                        <p style="text-align:center; padding-top:20px"><i>Classes below are the <strong>only</strong> classes you are allow to take based off your Completed Courses History and/or previous saved schedules in the current Program Sequence Plan.</i></p>

                      @foreach ($courses as $course)
                            @if ($course->fall_semester == 1 && $course->winter_semester == 0)
                                <input type="checkbox" id="{{$course->id}}" name="courses[]" value = "{{$course->id}}" class="vis-hidden"><label class="scheduler-course-label-fall" for="{{$course->id}}">{{$course->id}}</label>
                            @elseif ($course->fall_semester == 0 && $course->winter_semester == 1)
                                <input type="checkbox" id="{{$course->id}}" name="courses[]" value = "{{$course->id}}" class="vis-hidden"><label class="scheduler-course-label-winter" for="{{$course->id}}">{{$course->id}}</label>
                            @else
                                <input type="checkbox" id="{{$course->id}}" name="courses[]" value = "{{$course->id}}" class="vis-hidden"><label class="scheduler-course-label" for="{{$course->id}}">{{$course->id}}</label>
                            @endif
                      @endforeach
                    </div>

                    <!-- <div id="preferences" class="tabcontent">
                        Semester: <input type="radio" name="semester" value="fall" checked> Fall    &nbsp;  &nbsp;

                        <input type="radio" name="semester" value="winter"> Winter<br><br>
                        Course load: <input type="number" name="courseLoad" value="4"><br>

                    </div> -->

                    <div id="time-pref" class="tabcontent">
                        Monday:Off<input type="checkbox" name="dayoff[]" value="Monday">    &nbsp;Not Before:<input type="time" name="before[]">    &nbsp;Not after:<input type="time" name="after[]"><br><br>
                        Tuesday:Off<input type="checkbox" name="dayoff[]" value="Tuesday">  &nbsp;Not Before:<input type="time" name="before[]">    &nbsp;Not after:<input type="time" name="after[]"><br><br>
                        Wednesday:Off<input type="checkbox" name="dayoff[]" value="Wednesday">  &nbsp;Not Before:<input type="time" name="before[]">    &nbsp;Not after:<input type="time" name="after[]"><br><br>
                        Thursday:Off<input type="checkbox" name="dayoff[]" value="Thursday">    &nbsp;Not Before:<input type="time" name="before[]">    &nbsp;Not after:<input type="time" name="after[]"><br><br>
                        Friday:Off<input type="checkbox" name="dayoff[]" value="Friday">    &nbsp;Not Before:<input type="time" name="before[]">    &nbsp;Not after:<input type="time" name="after[]"><br><br>

                    </div>

                    <script>
                    document.getElementById("defaultOpen").click();

                    function dispPref(evt, category) {
                        var i, tabcontent, tablinks;
                        tabcontent = document.getElementsByClassName("tabcontent");
                        for (i = 0; i < tabcontent.length; i++) {
                            tabcontent[i].style.display = "none";
                        }
                        tablinks = document.getElementsByClassName("tablinks");
                        for (i = 0; i < tablinks.length; i++) {
                            tablinks[i].className = tablinks[i].className.replace(" active", "");
                        }
                        document.getElementById(category).style.display = "block";
                        evt.currentTarget.className += " active";
                    }
                    </script>

                        <button type="submit" class="btn completed-btn">Generate Schedule</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- NEED TO SELECT AT LEAST ONE COURSE -->
<script type="text/javascript">

  function checkCourse(form)
    {
    if($('[name="courses[]"]:checked').length == 0){
        alert('You must select at least one course!');
        return false;
    }
    return true;
    }

  function dispCourse(value){
    var x = document.getElementsByClassName("scheduler-course-label-winter");
    var y = document.getElementsByClassName("scheduler-course-label-fall");
    var i;
    if(value == "winter"){
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "inline-block";
    }
    for (i = 0; i < y.length; i++) {
        y[i].style.display = "none";
    }
    }else{
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    for (i = 0; i < y.length; i++) {
        y[i].style.display = "inline-block";
    }
    }
  }

</script>
@endsection