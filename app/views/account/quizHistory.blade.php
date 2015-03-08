@extends('master')

@section('head')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">
	<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>

	<style type="text/css">
	.volume 
	{
		font-size: 20px;
	}
	</style>
@stop

@section('content')
<div class="container">
	<table id="quiz-history" class="table table-striped table-bordered span12">
		<thead>
			<tr>
				<th style="width: 15%">@lang('account.history.title')</th>
				<th style="width: 58%">@lang('index.layout.general.description')</th>
				<th style="width: 5%">@lang('index.layout.general.play')</th>
				<th style="width: 12%">@lang('index.layout.general.part_number')</th>
				<th style="width: 10%">@lang('index.layout.general.score')</th>
			</tr>
		</thead>
 
		<tfoot>
			<tr>
				<th>@lang('account.history.title')</th>
				<th>@lang('index.layout.general.description')</th>
				<th>@lang('index.layout.general.play')</th>
				<th>@lang('index.layout.general.part_number')</th>
				<th>@lang('index.layout.general.score')</th>
			</tr>
		</tfoot>
	</table>
</div>
<audio id="word-audio" autoplay></audio>
<script>
	$(document).ready(function() 
	{
		$('#quiz-history').dataTable(
		{
			"ajax" : "/api/quiz/video-scores",
			"columns" :
			[
				{ "data" : "title"},
				{ "data" : "description"},
				{ "data" : "link"},
				{ "data" : "link"},
				{ "data" : "score"}
			],
			"columnDefs" :
			[
				{
					"render" : function( data, type, row)
					{
						return '<a href="' + data + '" class="btn btn-default glyphicon glyphicon-play-circle"></a>';
					},
					"targets" : 2
				},
				{
					"render" : function( data, type, row)
					{
						return data.substr(data.lastIndexOf('/') + 1);
					},
					"targets" : 3
				},
				{
					"render" : function( data, type, row)
					{
						var stars = '';
						
						var numStars = data/20;
						for(var i = 0; i < numStars; i++)
						{
							stars += '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
						}
						
						return '<span hidden="hidden">' + data + '</span>' + stars;
					},
					"targets" : 4
				}
			],
		});
	});
</script>
@stop
