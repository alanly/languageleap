@extends('master')
@section('javascript')
<script type="text/javascript" src="libraries/accordion/js/evoslider.js"></script>
<script type="text/javascript" src="libraries/accordion/js/easing.js"></script>
<script type="text/javascript" src="js/accordion.js"></script>

<script type="text/javascript" src="libraries/filtrify/js/filtrify.js"></script>
<script type="text/javascript" src="libraries/filtrify/js/highlight.pack.js"></script>
<script type="text/javascript" src="libraries/filtrify/js/script.js"></script>

<script type="text/javascript" src="libraries/qtip/js/qtip.js"></script>
@stop

@section('css')
<link rel="stylesheet" href="libraries/accordion/css/evoslider.css" />
<link rel="stylesheet" href="libraries/accordion/css/default.css" />
<link rel="stylesheet" href="libraries/accordion/css/reset.css" />

<link rel="stylesheet" href="libraries/filtrify/css/style.css">
<link rel="stylesheet" href="libraries/filtrify/css/sunburst.css">
<link rel="stylesheet" href="libraries/filtrify/css/filtrify.css">

<link rel="stylesheet" href="libraries/qtip/css/qtip.css">

<link rel="stylesheet" href="libraries/loading/css/loading.css">
<link rel="stylesheet" href="css/accordion.css">
@stop

@section('content')
<div id="navbar">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-buttons">
				</button>
				<a class="navbar-brand" href="/" style="text-decoration: none;">Language Leap</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-buttons">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="text-decoration: none;">
							@lang('navbar.buttons.quiz-reminder.name')
							<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="text-center" id="quiz-link">@lang('navbar.buttons.quiz-reminder.none')</li>
						</ul>
					</li>
				</ul>
			</div> <!-- / .navbar-collapse -->
		</div> <!-- / .container-fluid -->
	</nav>
</div>
<div id="accordion" class="evoslider default">
	<dl>
		<dt id="firstTab">@lang('index.accordion.items.default')</dt>
		<dd>
			<div class="main" role="main">
				<div class="demo content">
						<ul>
							<li>
								<strong>@lang('index.accordion.movies.name')</strong>
								<a class="tooltiptext">
									<img id="movies" src="" alt="Movies">
								</a>
							</li>
							<li>
								<strong>@lang('index.accordion.shows.name')</strong>
								<a class="tooltiptext">
									<img id="shows" src="" alt="TV Shows">
								</a>
							</li>
							<li>
								<strong>@lang('index.accordion.commercials.name')</strong>
								<a class="tooltiptext">
									<img id="commercials" src="" alt="Commercials">
								</a>
							</li>
						</ul>
				</div>
			</div>
		</dd>

		<dt id="secondTab"></dt>
		<dd>
			<div class="main" role="main">
				<div class="demo content">
					<div id="placeHolder"></div>
					<ul id="container">
					</ul>
				</div>
			</div>
		</dd>
	
		<dt id="thirdTab"></dt>
		<dd>
			<div class="main" role="main">
				<div class="demo content">
					<ul id="seasonContainer">	
					</ul>
				</div>
			</div>        
		</dd>
	
		<dt id="fourthTab"></dt>
		<dd> 
			<div class="main" role="main">
				<div class="demo content">
					<ul id="episodeContainer">	
					</ul>
				</div>
			</div>       
		</dd>

		<dt id="fifthTab"></dt>
		<dd> 
			<div class="main" role="main">
				<div class="demo content">
					<ul id="videoContainer">	
					</ul>
				</div>
			</div>       
		</dd>  	  	
	</dl>
</div>

<script type="text/javascript">
	var accordion = $("#accordion").evoSlider({
		mode: "accordion",                  // Sets slider mode ("accordion", "slider", or "scroller")
		width: screen.width - 50,           // The width of slider
		height: screen.height - 150,        // The height of slider
		slideSpace: 5,                      // The space between slides

		mouse: false,                       // Enables mousewheel scroll navigation
		keyboard: false,                    // Enables keyboard navigation (left and right arrows)
		speed: 500,                         // Slide transition speed in ms. (1s = 1000ms)
		easing: "swing",                    // Defines the easing effect mode (easeOutBounce, linear)
		loop: false,                         // Rotate slideshow

		autoplay: false,                    // Sets EvoSlider to play slideshow when initialized
		interval: 5000,                     // Slideshow interval time in ms
		pauseOnHover: false,                 // Pause slideshow if mouse over the slide
		pauseOnClick: false,                 // Stop slideshow if playing

		directionNav: true,                 // Shows directional navigation when initialized
		directionNavAutoHide: false,        // Shows directional navigation on hover and hide it when mouseout

		controlNav: true,                   // Enables control navigation
		controlNavAutoHide: false           // Shows control navigation on mouseover and hide it when mouseout
	});


	$(document).ready(function() {
		disableAllTabs();
		$.filtrify("container", "placeHolder");

		displayMoreInfo("movies", "@lang('index.accordion.movies.name')","@lang('index.accordion.movies.desc')");
		displayMoreInfo("commercials", "@lang('index.accordion.commercials.name')","@lang('index.accordion.commercials.desc')");
		displayMoreInfo("shows", "@lang('index.accordion.shows.name')","@lang('index.accordion.shows.desc')");
	});
	
	$("#commercials").click(function() {
		commercialsClick();
	});

	$("#movies").click(function() {
		moviesClick();
	});

	$("#shows").click(function() {
		showsClick();
	});

	var dictionary = {
		"selectMovies" : 			"@lang('index.accordion.movies.select')",		
		"movies" : 					"@lang('index.accordion.movies.name')",	
		"selectCommercials" : 		"@lang('index.accordion.commercials.select')",		
		"commercials" : 			"@lang('index.accordion.commercials.name')",	
		"selectShows" : 			"@lang('index.accordion.shows.select')",		
		"shows" : 					"@lang('index.accordion.shows.name')",		
		"selectSeason" : 			"@lang('index.accordion.seasons.select')",	
		"selectEpisode" : 			"@lang('index.accordion.episodes.select')",	
		"selectVideos" : 			"@lang('index.accordion.videos.select')",	
	};
	
	// When the document is ready, make a request to the server to see if there is a quiz to do
	$(document).ready(function() {
		$.ajax({
			type: "GET",
			url: "api/quiz/reminder",
			success: function(data) {
				var quiz_id = data.data.quiz_id;
				if(quiz_id > 0)
				{
					$("#quiz-link").html('<a href="quiz"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>');
				}
			},
		})
	});
</script>
@stop

