<div class="centerProgressIndicators">
	<!-- Change to label-success once a step is finished -->
	<span class="label label-success">Step 1: Select a video</span>
	<span class="label label-primary">Step 2: Watch the video</span>
	<span class="label label-danger">Step 3: Review the flashcards</span>
	<span class="label label-danger">Step 4: Answer the quiz</span>
</div>

<!--<div>-->
	<div class="centerYoutubeVideo">
		<iframe width="853" height="480" src="//www.youtube.com/embed/NuzH3x6kGMg" frameborder="1" allowfullscreen></iframe>
	</div>

	<div id="videoScript">
			<ul>
				<li><span class="scriptLine">Boy:</span> 
					<span class="wordSegment">So</span> 
					<span class="wordSegment">whatchu</span> 
					<span class="wordSegment">got</span> 
					<span class="wordSegment">on</span> 
					<span class="wordSegment">deck?</span></li>
				<li><span class="scriptLine">Girl:</span> 
					<span class="wordSegment">Skyfall,</span> 
					<span class="wordSegment">Lean</span> 
					<span class="wordSegment">In,</span> 
					<span class="wordSegment">Dance(?),</span> 
					<span class="wordSegment">and</span> 
					<span class="wordSegment">Pinterest.</span> 
					<span class="wordSegment">You</span>?</li>
				<li><span class="scriptLine">Boy:</span> 
					<span class="wordSegment">Twitter,</span> 
					<span class="wordSegment">Minecraft,</span> 
					<span class="wordSegment">and</span> 
					<span class="wordSegment">Hunger</span> 
					<span class="wordSegment">Games.</span> 
					<span class="wordSegment">Boom!</span></li>
				<li><span class="scriptLine">Woman:</span> 
					<span class="wordSegment">Oh,</span> 
					<span class="wordSegment">you</span> 
					<span class="wordSegment">guys</span> 
					<span class="wordSegment">are</span> 
					<span class="wordSegment">all</span> 
					<span class="wordSegment">set,</span> 
					<span class="wordSegment">huh?</span></li>
				<li><span class="scriptLine">Boy:</span> 
					<span class="wordSegment">Oh</span> 
					<span class="wordSegment">yeah!</span> 
					<span class="wordSegment">New</span> 
					<span class="wordSegment">Amazon</span> 
					<span class="wordSegment">Fire</span> 
					<span class="wordSegment">Phone.</span></li>
				<li><span class="scriptLine">Girl:</span> 
					<span class="wordSegment">It</span> 
					<span class="wordSegment">comes</span> 
					<span class="wordSegment">with</span> 
					<span class="wordSegment">Amazon</span> 
					<span class="wordSegment">Prime.</span> 
					<span class="wordSegment">Tons</span> 
					<span class="wordSegment">of</span> 
					<span class="wordSegment">cool</span> 
					<span class="wordSegment">stuff</span> 
					<span class="wordSegment">for</span> 
					<span class="wordSegment">no</span> 
					<span class="wordSegment">extra</span> 
					<span class="wordSegment">charge.</span></li>
				<li><span class="scriptLine">Woman:</span> 
					<span class="wordSegment">Really?</span> 
					<span class="wordSegment">It</span> 
					<span class="wordSegment">comes</span> 
					<span class="wordSegment">with</span> 
					<span class="wordSegment">Amazon</span> 
					<span class="wordSegment">prime?</span></li>
				<li><span class="scriptLine">Girl:</span> 
					<span class="wordSegment">Yeah.</span> 
					<span class="wordSegment">There's</span> 
					<span class="wordSegment">so</span> 
					<span class="wordSegment">much</span> 
					<span class="wordSegment">to</span> 
					<span class="wordSegment">watch.</span></li>
				<li><span class="scriptLine">Boy:</span> 
					<span class="wordSegment">I've</span> 
					<span class="wordSegment">been</span> 
					<span class="wordSegment">on</span> 
					<span class="wordSegment">this</span> 
					<span class="wordSegment">Earth</span> 
					<span class="wordSegment">for</span> 
					<span class="wordSegment">9</span> 
					<span class="wordSegment">years</span> 
					<span class="wordSegment">and</span> 
					<span class="wordSegment">I've</span> 
					<span class="wordSegment">never</span> 
					<span class="wordSegment">seen</span> 
					<span class="wordSegment">anything</span> 
					<span class="wordSegment">like</span> 
					<span class="wordSegment">it.</span></li>
				<li><span class="scriptLine">Announcer:</span> 
					<span class="wordSegment">The</span> 
					<span class="wordSegment">new</span> 
					<span class="wordSegment">Amazon</span> 
					<span class="wordSegment">Fire</span> 
					<span class="wordSegment">Phone</span> 
					<span class="wordSegment">with</span> 
					<span class="wordSegment">a</span> 
					<span class="wordSegment">full</span> 
					<span class="wordSegment">year</span> 
					<span class="wordSegment">of</span> 
					<span class="wordSegment">Prime</span> 
					<span class="wordSegment">included</span> 
					<span class="wordSegment">exclusively</span> 
					<span class="wordSegment">on</span> 
					<span class="wordSegment">at&amp;.</span></li>
			</ul>
	</div>

<!--</div>-->
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<div class="progress">
  <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
  </div>
</div>


<script>
	$("#videoScript .wordSegment").click(function () {
		$(this).toggleClass("selectedWordSegment");
	});
</script>