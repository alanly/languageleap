<div id="scroller" class="evoslider default"> <!-- start evo slider -->

	<dl>
		<?php
			foreach($words as $key => $value)
			{
				$data = "<dt></dt>";
				$data .= "<dd>";
				$data .= "<div class='word'>" . $value["word"] . "</div>";
				$data .= "<div class='pronunciation'>" . $value["pronunciation"] . "</div>"; 
				$data .= "<div class='definition'>" . $value["full_definition"] . "</div>";
				$data .= "</dd>";

				echo $data;
			}
		?>
	</dl>

</div> <!-- end evo slider -->

<script type="text/javascript">
			
	$("#scroller").evoSlider({
		mode: "scroller",                   // Sets slider mode ("accordion", "slider", or "scroller")
		width: 400,                         // The width of slider
		height: 400,                        // The height of slider
		slideSpace: 5,                      // The space between slides
	
		mouse: false,                       // Enables mousewheel scroll navigation
		keyboard: false,                    // Enables keyboard navigation (left and right arrows)
		speed: 500,                         // Slide transition speed in ms. (1s = 1000ms)
		easing: "swing",                    // Defines the easing effect mode
		loop: true,                         // Rotate slideshow
	
		autoplay: false,                    // Sets EvoSlider to play slideshow when initialized
		interval: 5000,                     // Slideshow interval time in ms
		pauseOnHover: true,                 // Pause slideshow if mouse over the slide
		pauseOnClick: true,                 // Stop slideshow if playing
		
		directionNav: true,                 // Shows directional navigation when initialized
		directionNavAutoHide: false,        // Shows directional navigation on hover and hide it when mouseout
	
		controlNav: true,                   // Enables control navigation
		controlNavAutoHide: false           // Shows control navigation on mouseover and hide it when mouseout 
	});                            
	
</script>
