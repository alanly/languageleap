<!doctype html>
<html lang="en">
<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="javaScript/accordion/accordionJS/evoslider.js"></script>
	<script type="text/javascript" src="javaScript/accordion/accordionJS/easing.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/accordion/accordionCSS/evoslider.css" />
    <link rel="stylesheet" href="css/accordion/accordionCSS/default.css" />
    <link rel="stylesheet" href="css/accordion/accordionCSS/reset.css" />

</head>
<body>
	<div id="accordion" class="evoslider default">
	    <dl>
		    <dt id="firstTab">Select Media</dt>
		    <dd>
		    	<button id="commercial">Commercial</button>
		    	<button id="movies">Movies</button>
		    	<button id="series">Televeision Series</button>

		    </dd>

		    <dt id="secondTab"></dt>
		    <dd>
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
		});
		
		$("#commercial").click(function() {
			disableExtraTabs();
			accordion.next();
			setTabName("firstTab", "commercial");
			setTabName("secondTab", "Select Commercial");

			$("#secondTab").removeClass("disabled");
		});

		$("#movies").click(function() {
			disableExtraTabs();
			accordion.next();
			setTabName("firstTab", "movies");
			setTabName("secondTab", "Select Movie");

			$("#secondTab").removeClass("disabled");
		});

		$("#series").click(function() {
			enableExtraTabs();
			accordion.next();
			setTabName("firstTab", "series");
			setTabName("secondTab", "Select Series");
			setTabName("thirdTab", "Select Season");
			setTabName("fourthTab", "Select Episode");

			accordion.bindClicker(1);
			$("#secondTab").removeClass("disabled");
		});

		function disableExtraTabs()
		{
			$("#thirdTab").addClass("disabled");
			$("#fourthTab").addClass("disabled");

			setTabName("thirdTab", "");
			setTabName("fourthTab", "");

			disableClickableTabs();
		}

		function enableExtraTabs()
		{
			$("#thirdTab").removeClass("disabled");
			$("#fourthTab").removeClass("disabled");

			enableClickableTabs();

		}

		function setTabName(tabId, name)
		{
			$("#" + tabId).html();
			$("#" + tabId).text(name);
		}

		function disableAllTabs()
		{
			$("#secondTab").addClass("disabled");
			$("#thirdTab").addClass("disabled");
			$("#fourthTab").addClass("disabled");

			accordion.unbindClicker(1);
			accordion.unbindClicker(2);
			accordion.unbindClicker(3);
		}

		function enableClickableTabs()
		{
			accordion.bindClicker(2);
			accordion.bindClicker(3);
		}

		function disableClickableTabs()
		{
			accordion.unbindClicker(2);
			accordion.unbindClicker(3);
		}

	</script>

</body>
</html>


