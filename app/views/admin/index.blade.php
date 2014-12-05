@extends('admin.master')

@section('head')
@stop

@section('content')

 	<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
      	<div class="container-fluid">
        	<div class="navbar-header">
          		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            		<span class="sr-only">Toggle navigation</span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
          		</button>
          	<a class="navbar-brand" href="#">Language Leap</a>
        	</div>

        	<div id="navbar" class="navbar-collapse collapse">
          		<ul class="nav navbar-nav navbar-right">
            		<li><a href="#">Dashboard</a></li>
            		<li><a href="#">Settings</a></li>
            		<li><a href="#">Profile</a></li>
            		<li><a href="#">Help</a></li>
          		</ul>
         		<form class="navbar-form navbar-right">
            		<input type="text" class="form-control" placeholder="Search...">
          		</form>
        	</div>
      	</div>
    </nav>

<div class="container-fluid" style="padding-top: 70px;">

	<div class="col-md-2 padded">
	    <ul class="nav nav-pills nav-stacked">
	        <li class="active"><a href="#">Home</a></li>
	        <li><a href="#">Upload Videos</a></li>
	        <li class="upload-script"><a href="#">Upload Scripts</a></li>
	        <li><a href="#">Insert Definitions</a></li>
	    </ul>
	</div>

	<div id="new-slidedown" class="clearfix col-md-10" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="slide-title">Script Upload</h2>
				</div>

				<div class="modal-body" style="display: block;">
				</div>
			</div>
		</div>
	</div>

	<!--
	<div id="new" class="pull-right">
		<button type="button" class="btn btn-success center-block">Add Media</button>
	</div>

	
	<div id="search" class="container">
		<input class="rounded" style="margin-right: 5px;" /><i class="fa fa-search fa-lg"></i>
	</div>
	-->

	<div id="select" class="container">
		<span id="select-movies">Movies</span> <span id="select-commercials">Commercials</span> <span id="select-commercials">TV Shows</span>
	</div>

	<div id="content" class="container">
	</div>

	<div id="add" class="container">
	</div>
</div>

<div id="media-modal" class="modal fade" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h2 class="modal-title"></h2>
			</div>
			
			<div class="modal-body info" aria-hidden="false" style="display: block;">
				<div class="row">
						<div class="col-xs-4">
							<img class="modal-image" src="" />
						</div>

						<div class="col-xs-8">
							<div class="info-row">ID: <span class="modal-id"></span></div>
							<div class="info-row">Name: <span class="modal-name"></span></div>
							<div class="info-row">Description: <span class="modal-desc"></span></div>
							<div class="info-row">Director: <span class="modal-director"></span></div>
							<div class="info-row">Actor: <span class="modal-actor"></span></div>
						</div>
				</div>
			</div>

			<div class="modal-body media" aria-hidden="true" style="display: none;">
				Media goes here
			</div>

			<div class="modal-body script clearfix" aria-hidden="true" style="display: none;">
				{{-- change route and function to whatever you need --}}
				{{ Form::open(array('url' => 'foo/bar', 'class'=>'form-script')) }}
				{{-- Form::model($script, array('route' => array('script.create', $script->id))) --}}
				{{ Form::label('text', 'Script') }}
				{{ Form::textarea('text') }}
				{{ FOrm::submit('Submit') }}
				{{ Form::close() }}
			</div>

			<div class="modal-body flash" aria-hidden="true" style="display: none;">
				Flashcards go here
			</div>

			<div class="modal-footer">
				<div class="row-fluid">
					<div id="footer-info" class="span2 text-center">
						Info
					</div>

					<div id="footer-media" class="span2 text-center">
						Media
					</div>
					
					<div id="footer-script" class="span2 text-center">
						Script
					</div>
					
					<div id="footer-flash" class="span2 text-center">
						Flashcards
					</div>
					
					<div id="" class="span2 text-center">
						Aaaaaa
					</div>
					
					<div id="" class="span2 text-center">
						Bbbbbb
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(".upload-script").click(function()
{
	$("#new-slidedown").slideToggle("slow", function()
	{

	});
});

$("#select-movies").click(function()
{
	$.getJSON("/api/metadata/movies/", function(data)
	{
			var s = "";
			
			$.each(data.data, function(key, val)
			{
				var id = val.id;
				var name = val.name;
				console.log(key + " " + id + " " + name);
				s += '<span class="media" db-id="' + id + '">' + name + '</span>';
			});
			
			$('#content').empty().append(s);
			//s.detach();
	});
});

$('#content').on('click', 'span.media', function(event)
{
	var id = $(this).attr('db-id');
	var name;
	var description;
	var director;
	var actor;
	var thumb = "http://ia.media-imdb.com/images/M/MV5BMTY5NTAzNTc1NF5BMl5BanBnXkFtZTYwNDY4MDc3._V1_SX640_SY720_.jpg";
	
	$.getJSON("/api/metadata/movies/" + id, function(data)
	{
		name = data.data.name;
		description = data.data.description;
		director = data.data.director;
		actor = data.data.actor;
		
		$('.modal-title').empty().append(name);
		$('.modal-image').attr("src", thumb);
		$('.modal-id').empty().append(id);
		$('.modal-name').empty().append(name);
		$('.modal-desc').empty().append(description);
		$('.modal-director').empty().append(director);
		$('.modal-actor').empty().append(actor);
		
		$('#media-modal').modal('show');
	});
});

$('.modal-footer').on('click', '.span2', function(event)
{
	var id = $(this).attr('id');
	$('.modal-body').attr("aria-hidden", true);
	$('.modal-body').css("display", "none");
	
	if (id == "footer-info")
	{
		$('.modal-body.info').attr("aria-hidden", false);
		$('.modal-body.info').css("display", "block");
	}
	else if (id == "footer-script")
	{
		$('.modal-body.script').attr("aria-hidden", false);
		$('.modal-body.script').css("display", "block");
	}

});
</script>
@stop
