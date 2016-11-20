@extends('layouts.header')

@section('content')
<div class="container-full">
    <div class="row">

        <div id="sidemenu" class="col-sm-2">
          <p style="text-align: center">Choose A Program Schedule</p>
          <div class="program-schedule">
            <!-- make sure the size is variable -->
             <select name="programschedule" size="3">
                 <option value="1" onclick="myFunction(this.value)">Program Schedule 1</option>
                  <option value="2" onclick="myFunction(this.value)">Program Schedule 2</option>
                   <option value="3" onclick="myFunction(this.value)">Program Schedule 3</option>

             </select>

             <script>
            //  $('select option:even').css({'background-color': 'white', color: "#400000"});
            function myFunction(value){
              document.getElementById("schedule-content").innerHTML = value;
            }
             </script>
          </div>
        </div>

        <div id="schedule-content" class="col-sm-10">

        </div>

        </div>

    </div>
</div>
@endsection
