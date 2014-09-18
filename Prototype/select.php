<div class="centerProgressIndicators">
	<!-- Change to label-success once a step is finished -->
	<span class="label label-primary">Step 1: Select a video</span>
	<span class="label label-danger">Step 2: Watch the video</span>
	<span class="label label-danger">Step 3: Review the script</span>
	<span class="label label-danger">Step 4: Review the flashcards</span>
	<span class="label label-danger">Step 5: Answer the quiz</span>
</div>
<!--
<div class="list-group">
	<a href="#" class="list-group-item active">Commercials</a>
	<button type="button" class="btn btn-default">Amazon Fire Phone</button>
	<br/>
	<button type="button" class="btn btn-default">Samsung Galaxy S5</button>
	<br/>
	<button type="button" class="btn btn-default">iPhone 6</button>
	<br/>

  	<a href="#" class="list-group-item active">TV Series</a>
  	<button type="button" class="btn btn-default" disabled>Coming Soon!</button>
  	<br/>
</div>
-->
<div id="wrapper" class="centerProgressIndicators">
		<div class="accordionButton">Media Type</div>
			<div class="accordionContent">
				<button type="button" class="btn btn-default" disabled>Movies</button>
				<br/>
				<button type="button" class="btn btn-default" disabled>TV Shows</button>
				<br/>
				<button type="button" class="btn btn-default" id="commercials">Commercials</button>
				<br/>
			</div>
		<div class="accordionButton">Commercials</div>
			<div class="accordionContent" id="accordionCommercials">
				<button type="button" class="btn btn-default">Amazon Fire Phone</button>
				<br/>
				<button type="button" class="btn btn-default">Samsung Galaxy S5</button>
				<br/>
				<button type="button" class="btn btn-default">iPhone 6</button>
				<br/>
			</div>
		<div class="accordionButton">Season</div>
		<div class="accordionContent"></div>
		<div class="accordionButton">Episode</div>
		<div class="accordionContent"></div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br />

<div class="progress">
  <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 5%">
  </div>
</div>

<script>

	$(document).ready(function(){
	//ACCORDION BUTTON ACTION
	$('div.accordionButton').click(function() {
	//IF THE DIV YOU CLICKED IS ALREADY OPEN, CLOSE AND REMOVE THE OPEN CLASS
	if ($(this).next().hasClass('openDiv')) {
		$('div.accordionContent.openDiv').slideUp('normal');
		$('div.accordionContent.openDiv').removeClass('openDiv');
	}
    //CLOSE ANY OPEN DIVS, OPEN THE CLICKED DIV
	else {
		$('div.accordionContent.openDiv').slideUp('normal');
		$('div.accordionContent.openDiv').removeClass('openDiv');
		$(this).next().slideDown('normal');
		$(this).next().addClass('openDiv');
	}
	});
	//HIDE THE DIVS ON PAGE LOAD
	$("div.accordionContent").hide();
	});

	$("#commercials").click(function() {
	  	$('div.accordionContent.openDiv').slideUp('normal');
		$('div.accordionContent.openDiv').removeClass('openDiv');
	});


</script>
