<!doctype html>
<html lang="en">
<head>
	@include('layouts.jQuery')

	<script type="text/javascript" src="libraries/accordion/js/evoslider.js"></script>
	<script type="text/javascript" src="libraries/accordion/js/easing.js"></script>
	<script type="text/javascript" src="js/accordion.js"></script>

	<script type="text/javascript" src="libraries/filtrify/js/filtrify.js"></script>
	<script type="text/javascript" src="libraries/filtrify/js/highlight.pack.js"></script>
	<script type="text/javascript" src="libraries/filtrify/js/script.js"></script>

	@include('layouts.bootstrap')

    <link rel="stylesheet" href="libraries/accordion/css/evoslider.css" />
    <link rel="stylesheet" href="libraries/accordion/css/default.css" />
    <link rel="stylesheet" href="libraries/accordion/css/reset.css" />

    <link rel="stylesheet" href="libraries/filtrify/css/style.css">
	<link rel="stylesheet" href="libraries/filtrify/css/sunburst.css">
	<link rel="stylesheet" href="libraries/filtrify/css/filtrify.css">

</head>
<body>
	<div id="accordion" class="evoslider default">
	    <dl>
		    <dt id="firstTab">Select Media</dt>
		    <dd>
		    	<div class="main" role="main">
				    <div class="demo content">
							<ul>
							    <li><strong>Movies</strong><img id="movies" src="" alt="Movies"></li>
							    <li><strong>TV Series</strong><img id="series" src="" alt="TV Series"></li>
							    <li><strong>Commercials</strong><img id="commercials" src="" alt="Commercials"></li>
							</ul>
					</div>
				</div>
		    </dd>

		    <dt id="secondTab"></dt>
		    <dd id="secondTabContent">
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
		    </dd>
		
		    <dt id="fourthTab"></dt>
		    <dd>        
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
		});
		
		$("#commercials").click(function() {
			commercialsClick();
		});

		$("#movies").click(function() {
			moviesClick();
		});

		$("#series").click(function() {
			seriesClick();
		});

	</script>

</body>
</html>


