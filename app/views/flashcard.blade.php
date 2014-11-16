<div id="scroller" class="carousel slide" data-ride="carousel">
	<!-- Wrapper for slides -->
	<div class="carousel-inner text-center" role="listbox">
		<?php $i = 0; ?>
		@foreach ($words as $key => $value)
		<div class="item {{ ($i == 0) ? 'active' : '' }}">
			<h3>{{ $value['word'] }}<br>
		
			<small>{{ $value['pronunciation'] }}</small></h3><br>
			<span>{{ $value['full_definition'] }}</span>
		</div>
		<?php $i++; ?>
		@endforeach
	</div>

	<!-- Controls -->
	<a class="left carousel-control" href="#scroller" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#scroller" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>