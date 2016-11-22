@extends('layouts.header')

@section('content')

<div class="container">
   <div class="row">
       <div class="col-md-8 col-md-offset-2">
           <div class="panel panel-default">
               <div class="panel-heading"><h4><b>Show the generated schedules. {{ $totalResults }} schedules were generated</b></h4></div>
               <?php
               $i = 0;
               ?>
               <div class="panel-body">

                   <div class="container">
                       <?php foreach ($results as $sections): ?>
                        <script> var k = 0; </script>
                           <?php $i++; ?>

                           <form role="form" action="{{ url('/generated/schedules/save') }}" method="post" class="generated-form">
                               <input type="hidden" name="continue" value="{{ $continue }}">
                                <div id="calendar{{ $i }}" class="viewcalendar">
                                   <script>
                                    $('#calendar{{ $i }}').fullCalendar({

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
                               <div class="details">
                                   <h4>Schedule {{ $i }}</h4>
                                   <?php foreach ($sections as $section): ?>

                                    

                                       <?php $course = $section->course ?>
                                       <input type="text" name="course[]" value="{{ $course }}" hidden="true">{{ $course }}: <br>
                                       <?php $sectiontype = $section->type ?>
                                       <?php if ($section->type == "Lec") 
                                               {$sectioncode = $section->section1;} 
                                               else 
                                               {$sectioncode = $section->section2;} ?>
                                       <input type="text" name="sectiontype[]" value="{{ $sectiontype }}" hidden="true">{{ $sectiontype }}: Section <input type="text" name="sectioncode[]" value="{{ $sectioncode }}" hidden="true">{{ $sectioncode }}<br>
                                       <?php $days = $section->days ?>
                                       <?php $day = str_split(str_replace("-", "", $days)) ?>
                                       <input type="text" name="days[]" value="{{ $days }}" hidden="true">{{ $days }}<br>
                                       <?php $start = $section->start ?>
                                       <input type="text" name="start[]" value="{{ $start }}" hidden="true">Start: {{ $start }}<br>
                                       <?php $end = $section->end ?>
                                       <input type="text" name="end[]" value="{{ $end }}" hidden="true">End: {{ $end }}
                                       <br><br>

                                       <!-- CREATING EVENTS -->
                                       <script>
                                       var events = new Array({{ count($sections) }});

                                       // FORMATTING EVENT DATA
                                       <?php
                                       $daynum = 0;
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
                                            $('#calendar{{ $i }}').fullCalendar( 'renderEvent', events[k]);
                                            k = k + 1;
                                       </script>
                                       
                                    <?php endforeach; ?>

                               </div>

                              

                                <button type="submit" class="btn completed-btn">Pick this Schedule</button>
                           </form>
                           <br>
                       <?php endforeach; ?>
                   </div>

                   <?php echo $results->appends(request()->input())->links(); ?>
               </div>
           </div>
       </div>
   </div>
</div>


@endsection