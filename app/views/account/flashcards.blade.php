@extends('master')

@section('head')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">
	<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
@stop

@section('content')
<div class="container">
	<table id="flashcards" class="table table-striped table-bordered" cellspacing="0" width="100%">
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

<script>
	$(document).ready(function() 
	{
		$('#flashcards').dataTable(
		{
			"ajax" : "/api/metadata/flashcards",
			"columns" :
			[
				{ "data" : "word"},
				{ "data" : "definition"},
				{ "data" : "pronunciation"}
			]
		});
	});
</script>
@stop