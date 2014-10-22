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
<div id="accordion" class="evoslider default">
    <dl>
	    <dt id="firstTab">Select Media</dt>
	    <dd>
	    	<div class="main" role="main">
			    <div class="demo content">
						<ul>
						    <li>
							    <strong>Movies</strong>
						    	<a class="tooltiptext">
						    		<img id="movies" src="" alt="Movies">
						    	</a>
							</li>
						    <li>
						    	<strong>TV Shows</strong>
						    	<a class="tooltiptext">
							    	<img id="shows" src="" alt="TV Shows">
							    </a>
						    </li>
						    <li>
						    	<strong>Commercials</strong>
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

		displayMoreInfo("movies", "Movies","Learn through your favorite Movies!");
		displayMoreInfo("commercials", "Commercials", "Learn through fun and interesting Commercials!");
		displayMoreInfo("shows", "Television Shows", "Learn through your favorite Television Shows!");
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

</script>
@stop

