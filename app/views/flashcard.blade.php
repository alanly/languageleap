<div id="scroller" class="carousel slide" data-ride="carousel">
	<!-- Loading gif -->
	{{ HTML::image('/img/misc/loading.gif', 'Loading', array('class' => 'center-block loading')) }}

	<!-- Wrapper for slides -->
	<div class="carousel-inner text-center" role="listbox">
		<div class="item"></div>
	</div>

	<!-- Controls -->
	<a class="left carousel-control" href="#scroller" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">@lang('pagination.previous')</span>
	</a>
	<a class="right carousel-control" href="#scroller" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">@lang('pagination.next')</span>
	</a>
</div>
