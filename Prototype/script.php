<div class="centerProgressIndicators">
	<!-- Change to label-success once a step is finished -->
	<span class="label label-success">Step 1: Select a video</span>
	<span class="label label-success">Step 2: Watch the video</span>
	<span class="label label-primary">Step 3: Review the script</span>
	<span class="label label-danger">Step 4: Review the flashcards</span>
	<span class="label label-danger">Step 5: Answer the quiz</span>
</div>



<div class="progress">
  <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
  </div>
</div>

<script>
	$("#videoScript .wordSegment").click(function () {
		$(this).toggleClass("selectedWordSegment");
	});
</script>