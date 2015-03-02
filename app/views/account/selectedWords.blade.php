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
	<table id="selectedWords" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>@lang('account.words.word')</th>
				<th>@lang('account.words.definition')</th>
				<th>@lang('account.words.pronunciation')</th>
			</tr>
		</thead>
 
		<tfoot>
			<tr>
				<th>@lang('account.words.word')</th>
				<th>@lang('account.words.definition')</th>
				<th>@lang('account.words.pronunciation')</th>
			</tr>
		</tfoot>
	</table>
</div>
<audio id="word-audio" autoplay></audio>
<script>
	$(document).ready(function() 
	{
		$('#selectedWords').dataTable(
		{
			"ajax" : "/api/review",
			"columns" :
			[
				{ "data" : "definition.word"},
				{ "data" : "definition.definition"},
				{ "data" : "definition.audio_url"}
			],
			"columnDefs" :
			[
				{
					"render" : function( data, type, row)
					{
						return '<button class="pronunciations-on" id="' + data + '"><span class="glyphicon glyphicon-volume-up volume"></span></button>';
					},
					"targets" : 2
				}
			],
			"fnInitComplete" : function()
			{
				$(".pronunciations-on").click(function()
				{
					$('#word-audio').attr('src', this.id);
				});
			}
		});
	});
</script>
@stop
