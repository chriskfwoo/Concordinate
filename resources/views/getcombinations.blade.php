<h1>All Combinations</h1>
@foreach ($all_combinations as $combination)
	<h3>combination:</3>
	@foreach($combination as $section)
		<div>
			{{$section->course}} {{$section->section1}}  {{$section->section2}} {{$section->days}} {{$section->start}} {{$section->end}}
		</div>
	@endforeach
@endforeach

<h1> Conflicting Combinations</h1>
@foreach ($conflicting_combinations as $combination)
	<h3>combination:</3>
	@foreach($combination as $section)
		<div>
			{{$section->course}} {{$section->section1}}  {{$section->section2}} {{$section->days}} {{$section->start}} {{$section->end}}
		</div>
	@endforeach
@endforeach

@foreach ($combos_for_courses as $combos_for_course)
	<h3>new course</h3>
	{{count ($combos_for_course)}}
	@foreach ($combos_for_course as $combo_for_course)
		<h4>new combo</h4>
		@foreach ($combo_for_course as $combo)
			   {{$combo->section1}}  {{$combo->section2}} ,  
		@endforeach
	@endforeach
@endforeach