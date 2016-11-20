@extends('layouts.header')

@section('content')
<div class="container-full">
    <div class="row">

        <div id="sidemenu" class="col-sm-2">
          <p style="text-align: center">Choose A Program Schedule</p>
          <div class="program-schedule">
            <!-- make sure the size is variable -->
            <?php
            $size = sizeof($schedules);
            ?>
                <select id="programschedule" size="<?= $size ?>">
                    <?php foreach ($schedules as $key => $schedule): ?>
                    <option value="{{ $key + 1}}">Program Schedule {{ $key + 1}}</option>
                    <?php endforeach; ?>
                </select>
          </div>
        </div>

        <div id="schedule-content" class="col-sm-10">
        <?php foreach ($schedules as $key => $schedule): ?>
                            
                                <div id="schedule{{ $key + 1 }}" class="schedulelist"><h2>Schedule {{ $key + 1 }}</h2>
                            <?php foreach ($schedule as $key => $semester): ?>
                                    <h3>Semester {{$key + 1 }}</h3>
                                <?php foreach ($semester as $section): ?>
                                    random section of course <?php echo $section->course ?> <br>

                                <?php endforeach; ?>
                                <br><br>
                            <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
        </div>

        </div>

    </div>
</div>
<script>
            $(function() {    // Makes sure the code contained doesn't run until
                  //     all the DOM elements have loaded

    $('#programschedule').change(function(){
        $('.schedulelist').hide();
        $('#schedule' + $(this).val()).show();
    });

});
</script>
@endsection
