@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>

                <div class="panel-body">
                    <form role="form" action="{{ url('/scheduler/generate') }}" method="get" class="login-form">

                    <ul class="tab">
                      <li><a href="javascript:void(0)" class="tablinks" onclick="dispPref(event, 'preferences')" id="defaultOpen">Basic Preferences</a></li>
                      <li><a href="javascript:void(0)" class="tablinks" onclick="dispPref(event, 'time-pref')">Time constraints</a></li>
                      <li><a href="javascript:void(0)" class="tablinks" onclick="dispPref(event, 'course-select')">Select Courses</a></li>
                    </ul>

                    <div id="course-select" class="tabcontent">
                      @foreach ($courses as $course)
                            <input type="checkbox" id="{{$course->id}}" name="courses[]" value = "{{$course->id}}" class="vis-hidden"><label class="scheduler-course-label" for="{{$course->id}}">{{$course->id}}</label>
                      @endforeach
                    </div>

                    <div id="preferences" class="tabcontent">
                        Semester: <input type="radio" name="semester" value="fall" checked>Fall&nbsp;&nbsp;<input type="radio" name="semester" value="winter">Winter<br><br>
                        Credit load: <input type="number" name="credit" value="15"><br>
                        
                    </div>

                    <div id="time-pref" class="tabcontent">
                        Monday:&nbsp;Off<input type="checkbox" name="dayoff[]" value="Monday">&nbsp;Not Before:<input type="time" name="before[]">&nbsp;Not after:<input type="time" name="after[]"><br><br>
                        Tuesday:&nbsp;Off<input type="checkbox" name="dayoff[]" value="Tuesday">&nbsp;Not Before:<input type="time" name="before[]">&nbsp;Not after:<input type="time" name="after[]"><br><br>
                        Wednesday:&nbsp;Off<input type="checkbox" name="dayoff[]" value="Wednesday">&nbsp;Not Before:<input type="time" name="before[]">&nbsp;Not after:<input type="time" name="after[]"><br><br>
                        Thursday:&nbsp;Off<input type="checkbox" name="dayoff[]" value="Thursday">&nbsp;Not Before:<input type="time" name="before[]">&nbsp;Not after:<input type="time" name="after[]"><br><br>
                        Friday:&nbsp;Off<input type="checkbox" name="dayoff[]" value="Friday">&nbsp;Not Before:<input type="time" name="before[]">&nbsp;Not after:<input type="time" name="after[]"><br><br>
                        
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
@endsection
