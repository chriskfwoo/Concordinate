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
                <div id='calendar'></div>
                <div class="panel-body">
                    <div class="container">
                        <?php foreach ($results as $sections): ?>
                            <?php
                            $i++;
                            ?>
                            <form role="form" action="{{ url('/generated/schedules/save') }}" method="post" class="generated-form">
                                <input type="hidden" name="continue" value="{{ $continue }}">
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
                                <input type="text" name="days[]" value="{{ $days }}" hidden="true">{{ $days }}<br>
                                <?php $start = $section->start ?>
                                <input type="text" name="start[]" value="{{ $start }}" hidden="true">Start: {{ $start }} ||
                                <?php $end = $section->end ?>
                                <input type="text" name="end[]" value="{{ $end }}" hidden="true">End: {{ $end }}
                                <br><br>
                            <?php endforeach; ?>
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