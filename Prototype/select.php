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
	    	<div id="main" role="main">
			    <div id="content" class="demo">
						<ul id="containerMedia">
						    <li><strong>Movies</strong><img id="movies" src="Filter/img/film.png"></li>
						    <li><strong>TV Shows</strong><img id="tvShows" src="Filter/img/film.png"></li>
						    <li><strong>Commercials</strong><img id="commercials" src="Filter/img/film.png"></li>
						</ul>    
				</div>
			</div>
	    </dd>

	    <dt>Commercials</dt>
	    <dd>
	    	<div id="main" role="main">
		    	<div id="content" class="demo" style="overflow:auto;">
			       	<div id="placeHolder"></div>
						<ul id="container">
						    <li data-genre="Comedy" data-main-actors="John Di Girolamo, Mike Lavoie, Alan Ly" data-director="Amazon"><strong>Amazon Fire Phone</strong><img id="firePhone" src="Filter/img/film.png"><span>Genre: <i>Comedy</i></span><span>Actors: <i>John Di Girolamo, Mike Lavoie, Alan Ly</i></span><span>Director: <i>Amazon</i></span></li>
						    <li data-genre="Sci-Fi" data-main-actors="Quang Tran, Kwok-Chak Wan" data-director="Samsung"><strong>Samsung Galaxy S5</strong><img id="galaxyS5" src="Filter/img/film.png"><span>Genre: <i>Sci-Fi</i></span><span>Actors: <i>Quang Tran, Kwok-Chak Wan</i></span><span>Director: <i>Samsung</i></span></li>
						    <li data-genre="Thriller" data-main-actors="Dror Ozgaon, David Siekut, Thomas Rahn" data-director="Apple"><strong>Apple iPhone 6</strong><img id="iPhone6" src="Filter/img/film.png"><span>Genre: <i>Thriller</i></span><span>Actors: <i>Dror Ozgaon, David Siekut, Thomas Rahn</i></span><span>Director: <i>Apple</i></span></li>
						</ul>    
				</div>
			</div>   
	    </dd>
	
	    <dt>Season</dt>
	    <dd>	        
	       Please select a show.    
	    </dd>
	
	    <dt>Episode</dt>
	    <dd>        
	       Please select a season.      
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
