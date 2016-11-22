@extends('layouts.header')

@section('content')
<div class="container-full">
    <div class="row">
        <div id="sidemenu" class="col-sm-2">
          <p style="text-align: center">Choose A Program Schedule</p>
          <div class="program-schedule">
            <!-- make sure the size is variable -->
            <?php $size = sizeof($schedules); 
            $indexPS = 0;?>
            <select id="programschedule" size="<?= $size ?>">
                <?php foreach ($schedules as $key => $schedule): ?>
                <option value="{{ $key + 1}}">Program Sch. {{ $key + 1}}</option>
                <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div id="schedule-content" class="col-sm-10">
            <?php foreach ($schedules as $key => $schedule): ?>
                <?php $indexPS++; ?>
                <div id="schedule{{ $key + 1 }}" class="schedulelist"><h2>Schedule {{ $key + 1 }}</h2>
                
                    <?php foreach ($schedule as $key => $semester): ?>
                    <div id="calendar{{ $indexPS }}{{ $key + 1 }}" class="viewcalendar2">
                                   <script>
                                    $('#calendar{{ $indexPS }}{{ $key + 1 }}').fullCalendar({

                                          allDaySlot: false,
                                          hiddenDays: [ 0, 6 ],
                                          columnFormat: 'ddd',
                                          defaultView:'agendaWeek',
                                          slotDuration: '00:30:00',
                                          minTime: '08:00:00',
                                          maxTime: '23:30:00',
                                          header: false,
                                          defaultDate: '2016-09-12',
                                          navLinks: false, // can click day/week names to navigate views
                                          editable: false,
                                          eventLimit: false// allow "more" link when too many events
                                       
                                        });

                                      
                                    </script>                    
                    </div>
                    <div class="details-view">
                        <h3>Semester {{$key + 1 }}</h3>
                        <script> var k = 0; </script>
                    <?php foreach ($semester as $section): ?>
                        
                        <?php $course = $section->course ?><?php echo $course ?><br>
                        <?php $sectiontype = $section->type ?><?php echo $sectiontype ?><br>
                        <?php $days = $section->days ?><?php echo $days ?><br>
                        <?php $day = str_split(str_replace("-", "", $days)) ?>
                        <?php $start = $section->start ?><?php echo $start ?><br>
                        <?php $end = $section->end ?><?php echo $end ?><br>

                                       <!-- CREATING EVENTS -->
                                       <script>
                                       var events = new Array({{ count($semester) }});

                                       // FORMATTING EVENT DATA
                                       <?php
                                       for($j = 0; $j < count($day) ; $j++ ){
                                            switch($day[$j]){
                                                case "M":
                                                    $daynum = 12;
                                                    break;
                                                case "T":
                                                    $daynum = 13;
                                                    break;
                                                case "W":
                                                    $daynum = 14;
                                                    break;
                                                case "J":
                                                    $daynum = 15;
                                                    break;
                                                case "F":
                                                    $daynum = 16;
                                                    break;        
                                            }
                                        }
                                        ?>
                                           var event = {
                                                 title       : "{{ $course }} {{ $sectiontype }}",
                                                 start       : "2016-09-{{ $daynum }}T{{ $start }}:00",
                                                 end         : "2016-09-{{ $daynum }}T{{ $end }}:00",
                                                 allDay      : false,
                                                };
                                            events[k] = event;

                                            // ADDING EVENTS TO CALENDAR
                                            $('#calendar{{ $indexPS }}{{ $key + 1 }}').fullCalendar( 'renderEvent', events[k]);
                                            k = k + 1;
                                       </script>




                    <?php endforeach; ?>
                    </div>
                    <br><br>
                    <?php endforeach; ?>
                </div>
             <?php endforeach; ?>
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        $('.schedulelist').hide();
        $('#schedule1').show();
    });
    $(function() {    // Makes sure the code contained doesn't run until
                  //     all the DOM elements have loaded
        $('#programschedule').change(function(){
        $('.schedulelist').hide();
        $('#schedule' + $(this).val()).show();
    });

    });
</script>

@endsection
