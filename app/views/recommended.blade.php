@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/recommended.css">
@stop

@section('content')
	<h2>Recommended Videos</h2>
	<div id="recommended-scroller" class="carousel slide" data-ride="carousel">
		<!-- Wrapper for slides -->
		<div class="carousel-inner text-center" role="listbox">
			<div class="item active">
				<div class="col-sm-4">
					{{ HTML::image('img/auth/airport2_bg@2x.jpg') }}
					<br>
					<span>How I met your mother</span>
				</div>
				<div class="col-sm-4">
					{{ HTML::image('img/auth/airport2_bg@2x.jpg') }}
					<br>
					<span>How I met your mother</span>
				</div>
				<div class="col-sm-4">
					{{ HTML::image('img/auth/airport2_bg@2x.jpg') }}
					<br>
					<span>How I met your mother</span>
				</div>
			</div>
			<div class="item">
				<div class="col-sm-4">
					{{ HTML::image('img/auth/airport2_bg@2x.jpg') }}
					<br>
					<span>How I met your mother</span>
				</div>
				<div class="col-sm-4">
					{{ HTML::image('img/auth/airport2_bg@2x.jpg') }}
					<br>
					<span>How I met your mother</span>
				</div>
				<div class="col-sm-4">
					{{ HTML::image('img/auth/airport2_bg@2x.jpg') }}
					<br>
					<span>How I met your mother</span>
				</div>
			</div>
		</div>

		<!-- Controls -->
		<a class="left carousel-control" href="#recommended-scroller" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">@lang('pagination.previous')</span>
		</a>
		<a class="right carousel-control" href="#recommended-scroller" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">@lang('pagination.next')</span>
		</a>
	</div>
@stop