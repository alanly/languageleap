@extends('admin.master')


@section('content')

<div class="container">
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th>@lang('admin.media.movie.table.id')</th>
				<th>@lang('admin.media.movie.table.name')</th>
				<th>@lang('admin.media.movie.table.description')</th>
				<th></th>
				<th>@lang('admin.media.movie.table.manage')</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>


<script type="text/javascript">
	$(document).ready(function () {
		//load movies here
	});


</script>

@stop