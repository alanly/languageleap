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
					<h3>@lang('index.layout.general.description')</h3>
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
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="error" style="display:none;">
		<div class="alert alert-danger" role="alert" id="show-error">
			
		</div>
	</div>

	<script type="text/javascript">

		var seasons_loaded = [];
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
					$(".container").hide();

					//show error here
					$(".error").show();

					var message = data.responseJSON.data;

					if(message === undefined)
					{
						message = "@lang('index.layout.general.error')";
					}

					$("#show-error").html(message);
				}
			});
		}
		
		function loadSeasons(seasons)
		{
			$.each(seasons, function(index,value){
				var season_holder = $(".clonable").clone();
				season_holder.removeClass("clonable");

				season_holder.find(".season-number").attr("href", ".season-" + value.id);
				season_holder.find(".season-number").html("Season " + value.number);

				//Add a custom click function
				season_holder.find(".season-number").click(function(){
					loadEpisodes(value.id);
				});

				season_holder.find(".season-information").addClass("season-" + value.id);

				season_holder.show();
				$(".season-selection").append(season_holder);

				//Initially all ids are false
				seasons_loaded[value.id] = false;
			});
		}

		function loadEpisodes(season_id)
		{
			if(!seasons_loaded[season_id])
			{
				//When clicked on season header, need to load the episodes
				$.ajax({
					url : "/api/metadata/shows/{{ $show_id }}/seasons/" + season_id + "/episodes",
					dataType : "JSON",
					success : function(data){
						seasons_loaded[season_id] = true;

						var episode_data = "";
						var episodes = data.data.episodes;

						$.each(episodes, function(index, value){
							episode_data += "<li class='list-group-item'><a href='/episode/" + value.id + "'>Episode " + value.number + "</a></li>";
						});

						if(episodes.length > 0)
						{
							$(".season-" + season_id).find(".list-group").html(episode_data);
						}
						else
						{
							$(".season-" + season_id).find(".list-group").html("@lang('index.layout.show.seasons.empty')");
						}
					},
					error : function(data){
						seasons_loaded[season_id] = false;

					}
				});
			}
		}
	</script>
@stop