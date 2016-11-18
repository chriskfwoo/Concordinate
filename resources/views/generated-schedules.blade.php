@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>

                <div class="panel-body">
                    Show the generated schedules.

                    <div class="container">
                        <?php foreach ($results as $sections): ?>
                            
                                <h4>Schedule</h4>
                            <?php foreach ($sections as $section): ?>
                                <?php echo $section->id ?><br>
                                <?php echo $section->course ?><br>
                                <?php echo $section->type ?><br>
                                <?php echo $section->days ?><br>
                                <?php echo $section->start ?><br>
                                <?php echo $section->end ?><br>
                                <?php echo $section->room ?><br>
                                <br><br>
                            <?php endforeach; ?>

                        <?php endforeach; ?>
                    </div>

                    <?php echo $results->appends(request()->input())->links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection