@extends('master')

@section('css')
	<style>
		.cover img {
			height: 300px;
			width: 225px;
		}

		.thumbnail.cover {
			width: 225px;
		}

		.video-selection tbody tr {
			cursor: pointer;
		}
	</style>
@stop

@section('content')
	<div class="container">
		<h2 id="show-title"></h2>
		<hr>
		<div class="row">
			<div class="col-md-3">
				<div class="thumbnail cover center-block">
					<img src="http://placehold.it/225x300" />
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
					<span class="director col-md-4 col-xs-6">
						<h3 id="show-title">Director</h3>
						<p id="show-directory"></p>
					</span>
					<span class="starring col-md-4 col-xs-6">
						<h3>Starring</h3>
						<p id="show-actor"></p>
					</span>
				</div>
				<span class="description">
					<h3>Description</h3>
					<p id="show-description"></p>
				</span>
				<br>
				<div class="season-selection panel-group" role="tablist" aria-multiselectable="true">
				</div>
			</div>
		</div>

		<div class="panel panel-default clonable" style="display:none;">
			<div class="panel-heading" role="tab">
				<h4 class="panel-title">
					<a class="collapsed season-number" data-toggle="collapse" data-parent=".season-selection" href="" aria-expanded="false" id="show-season"></a>
				</h4>
			</div>
			<div class="panel-collapse collapse season-information" role="tabpanel">
				<div class="panel-body">
					<ul class="list-group">
						<li class="list-group-item"><a href="#">Episode 1</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			loadShow();
		});

		function loadShow()
		{
			$.ajax({
				type : "GET",
				url : "/api/metadata/shows/{{ $show_id }}/seasons",
				dataType : "JSON",
				success : function(data)
				{
					var show = data.data.show;
					$("#show-title").html(show.name);
					$("#show-description").html(show.description);
					$("#show-level").html(show.level);

					if(show.image_path != null)
					{
						$("#show-image").attr("src", show.image_path);
					}

					loadSeasons(data.data.seasons);
				},
				error: function(data)
				{

				}
			});
		}
		function loadSeasons(seasons)
		{
			$.each(seasons, function(index,value){
				var season_holder = $(".clonable").clone();
				season_holder.removeClass("clonable");

				season_holder.find(".season-number").attr("href", ".season-" + value.number);
				season_holder.find(".season-information").addClass("season-" + value.number);
				season_holder.find(".season-number").html("Season " + value.number);

				season_holder.show();
				$(".season-selection").append(season_holder);
			});
		}

		function loadEpisodes(season_id)
		{
			
		}
	</script>
@stop