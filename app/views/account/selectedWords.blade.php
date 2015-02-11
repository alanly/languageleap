@extends('master')

@section('head')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">
	<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>

	<style type="text/css">
	.pronunciations-on 
	{
		background: url(http://cdn.flaticon.com/png/64/498.png) no-repeat center;
		height: 60px;
		width: 70px;
	}
	</style>
@stop

@section('content')
<div class="container">
	<table id="selectedWords" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Word</th>
				<th>Definition</th>
				<th>Pronunciation</th>
			</tr>
		</thead>
 
		<tfoot>
			<tr>
				<th>Word</th>
				<th>Definition</th>
				<th>Pronunciation</th>
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
			"ajax" : "/api/metadata/selectedWords",
			"columns" :
			[
				{ "data" : "word"},
				{ "data" : "definition"},
				{ "data" : "pronunciation"}
			],
			"columnDefs" :
			[
				{
					"render" : function( data, type, row)
					{
						var button = '<button class="pronunciations-on" id="' + data + '"></button>';
						return button;
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