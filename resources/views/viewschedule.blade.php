@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>

                <div class="panel-body">
                    VIEW SCHEDULE PAGE

                    <div class="container">
                        <?php foreach ($schedules as $key => $schedule): ?>
                            
                                <h2>Schedule {{ $key + 1 }}</h2>
                            <?php foreach ($schedule as $key => $semester): ?>
                                    <h3>Semester {{$key + 1 }}</h3>
                                <?php foreach ($semester as $section): ?>
                                    random section of course <?php echo $section->course ?> <br>

                                <?php endforeach; ?>
                                <br><br>
                            <?php endforeach; ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
