@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <!-- You have generated {var_number} schedules.<br> -->
                </div>

                <div class="panel-body">
                    You saved a schedule, do you wish to continue your Program Sequence Plan?<br>

                    <!-- EDIT REQUIRED DATA IN <form> 
                         This form is just for the NO button-->
                    <form role="form" action="{{ url('/schedule') }}"" method="get" class="generated-form">
                        <button type="button" onclick="dispPref1()">Yes</button>

                        <!-- THIS INPUT SHOULD CONTAIN THE DATA PASSED IF WE CLICK ON NO -->
                        <input type="text" name="" value="" hidden="true">
                        <button type="submit">No</button><br>
                    </form><br>

                    <!-- THIS FORM IS FOR THE NEXT SEMESTER
                        NEED TO EDIT THE ACTION -->

                    <form role="form" action="{{ url('/scheduler/generate') }}" method="get" class="login-form" onsubmit="return checkCourse(this)">

                        <div id="generate-schedule" style="display:none">

                        <input type="hidden" name="continue" value="1">

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

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function  dispPref1(){
        $('#generate-schedule').show();
    }
</script>
<script type="text/javascript">
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
<script type="text/javascript">

  function checkCourse(form)
  {
    if($('[name="courses[]"]:checked').length == 0){
        alert('You must select at least one course!');
        return false;
    }
    return true;
}

</script>

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
