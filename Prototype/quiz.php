<div class="centerProgressIndicators">
	<!-- Change to label-success once a step is finished -->
	<span class="label label-success">Step 1: Select a video</span>
	<span class="label label-success">Step 2: Watch the video</span>
	<span class="label label-success">Step 3: Review the flashcards</span>
	<span class="label label-primary">Step 4: Answer the quiz</span>
</div>

<!-- Content -->
<div class="container">
	<div class="row">
		<div id="quiz" class="quiz carousel slide col-sm-6 col-sm-offset-3" data-interval="false">
			<div class="questions carousel-inner">
				<div class="item active">
					<h2>exclusively <small>[ik-skloo-siv]</small></h2>

					<div class="answers">
						<input type="radio" id="q1_a1" name="q1"> <label for="q1_a1" class="bg-success">you cannot get it anywhere else</label><br>
						<input type="radio" id="q1_a2" name="q1"> <label for="q1_a2">possesses to a high degree a particular feature</label><br>
						<input type="radio" id="q1_a3" name="q1" checked> <label for="q1_a3" class="bg-danger"><strong>a trace of something bad or offensive</strong></label><br>
						<input type="radio" id="q1_a4" name="q1"> <label for="q1_a4">a traveller on foot</label>
					</div>

					<hr>

					<button type="button" class="btn btn-primary" data-target="#quiz" data-slide="next">Next Question</button>
				</div>

				<div class="item">
					<h2>watch <small>[woch]</small></h2>

					<div class="answers">
						<input type="radio" id="q2_a1" name="q2"> <label for="q2_a1">to be careful or cautious</label><br>
						<input type="radio" id="q2_a2" name="q2" checked> <label for="q2_a2" class="bg-success"><strong>to watch a TV show or movie</strong></label><br>
						<input type="radio" id="q2_a3" name="q2"> <label for="q2_a3">foolish dandy; pretentious fop</label><br>
						<input type="radio" id="q2_a4" name="q2"> <label for="q2_a4">adjacent in time</label>
					</div>

					<hr>

					<button type="button" class="btn btn-primary" data-target="#quiz" data-slide="next">See Results</button>
				</div>

				<div class="item">
					<h2>Quiz Results</h2>

					<p>You correctly answered <strong>1</strong> out of <strong>2</strong> questions.</p><br>

					<div class="well well-lg bg-warning">
						<h1 class="grade">50%</h1>
						<p class="text-muted"><strong>Room for Improvement.</strong></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<br/>
<div class="progress">
	<div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
	</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/carousel.min.js"></script>