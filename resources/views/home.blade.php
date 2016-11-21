@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    You have generated {var_number} schedules.<br>
                </div>

                <div class="panel-body">
                    Do you wish to continue?<br>
                    
                    <!-- EDIT REQUIRED DATA IN <form> 
                         This form is just for the NO button-->
                    <form role="form" action="" method="post" class="generated-form">
                        <button type="button" onclick="dispPref1()">Yes</button>

                        <!-- THIS INPUT SHOULD CONTAIN THE DATA PASSED IF WE CLICK ON NO -->
                        <input type="text" name="" value="" hidden="true">
                        <button type="submit" onclick="alert('saved')">No</button><br>
                    </form><br>

                    <!-- THIS FORM IS FOR THE NEXT SEMESTER 
                        NEED TO EDIT THE ACTION -->

                    <form role="form" action="" method="get" class="login-form">

                        <div id="generate-schedule" style="display:none">
                              
                            <ul class="tab">
                              <li><a href="javascript:void(0)" class="tablinks" onclick="dispPref(event, 'preferences')" id="defaultOpen">Basic Preferences</a></li>
                              <li><a href="javascript:void(0)" class="tablinks" onclick="dispPref(event, 'time-pref')">Time constraints</a></li>
                              <li><a href="javascript:void(0)" class="tablinks" onclick="dispPref(event, 'course-select')">Select Courses</a></li>
                            </ul>

                            <div id="course-select" class="tabcontent">

                            <!-- THIS IS THE COURSE TAB. WE NEED TO GET THE CORRECT COURSES -->

                            </div>

                            <div id="preferences" class="tabcontent">

                            <!-- NEED TO CHECK BY DEFAULT THE CORRECT NEXT SEMESTER BASED ON PREVIOUS GENERATED -->
                                Semester: <input type="radio" name="semester" value="fall" checked>Fall<input type="radio" name="semester" value="winter">Winter<br><br>
                                Credit load: <input type="number" name="credit" value="15"><br>
                                
                            </div>

                            <div id="time-pref" class="tabcontent">
                                Monday:Off<input type="checkbox" name="dayoff[]" value="Monday">Not Before:<input type="time" name="before[]">Not after:<input type="time" name="after[]"><br><br>
                                Tuesday:Off<input type="checkbox" name="dayoff[]" value="Tuesday">Not Before:<input type="time" name="before[]">Not after:<input type="time" name="after[]"><br><br>
                                Wednesday:Off<input type="checkbox" name="dayoff[]" value="Wednesday">Not Before:<input type="time" name="before[]">Not after:<input type="time" name="after[]"><br><br>
                                Thursday:Off<input type="checkbox" name="dayoff[]" value="Thursday">Not Before:<input type="time" name="before[]">Not after:<input type="time" name="after[]"><br><br>
                                Friday:Off<input type="checkbox" name="dayoff[]" value="Friday">Not Before:<input type="time" name="before[]">Not after:<input type="time" name="after[]"><br><br>
                                
                            </div>

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
@endsection
