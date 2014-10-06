<div class="centerProgressIndicators">
	<span class="label label-primary">Step 1: Select a video</span>
	<span class="label label-danger">Step 2: Watch the video</span>
	<span class="label label-danger">Step 3: Review the flashcards</span>
	<span class="label label-danger">Step 4: Answer the quiz</span>
</div>

<div id="mySlider" class="evoslider default">

    <dl>

	    <dt>Media</dt>
	    <dd>
	    </dd>

	    <dt>Commercials</dt>
	    <dd>
	    </dd>

	    <dt>Season</dt>
	    <dd>
	    </dd>

	    <dt>Episode</dt>
	    <dd>
	    </dd>

    </dl>

</div>

<br /><br />

<div class="progress">
  <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 5%">
  </div>
</div>

<script type="text/javascript">

    $("#mySlider").evoSlider({
        mode: "accordion",                  // Sets slider mode ("accordion", "slider", or "scroller")
        width: 1460,                         // The width of slider
        height: 430,                        // The height of slider
        slideSpace: 4,                      // The space between slides

        mouse: false,                        // Enables mousewheel scroll navigation
        keyboard: false,                     // Enables keyboard navigation (left and right arrows)
        speed: 500,                         // Slide transition speed in ms. (1s = 1000ms)
        easing: "swing",                    // Defines the easing effect mode
        loop: true,                         // Rotate slideshow

        autoplay: false,                     // Sets EvoSlider to play slideshow when initialized
        interval: 5000,                     // Slideshow interval time in ms
        pauseOnHover: true,                 // Pause slideshow if mouse over the slide
        pauseOnClick: true,                 // Stop slideshow if playing

        directionNav: true,                 // Shows directional navigation when initialized
        directionNavAutoHide: false,        // Shows directional navigation on hover and hide it when mouseout

        controlNav: true,                   // Enables control navigation
        controlNavAutoHide: false           // Shows control navigation on mouseover and hide it when mouseout
    });

    $(function() {
		$.filtrify("container", "placeHolder");
	});

	$("#commercials").click(function() {

		$("#commercials").height(84);
		$("#commercials").css('align', 'middle');
	});

	$("#firePhone").click(function() {

		$("#firePhone").height(84);
		$("#firePhone").css('align', 'middle');
	});

</script>
