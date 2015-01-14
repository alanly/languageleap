<div class="container" ng-app="rankingQuizApp">
	<div class="row">
		<div class="col-sm-6">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#skip">Skip Ranking Process</button>
		</div>
		<div class="col-sm-6 col-sm-offset-3">
			<h2>Let's see how good you are!</h2>
			<p>This ranking procedure let's us figure out how much you already know,
			so that we can tailor lessons to your needs.</p>

			<hr>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<form id="ranking-quiz-form" ng-controller="RankingQuizController">
				<div class="form-group question" id="question-{{ q.id }}" ng-repeat="q in questions">
					<h4>{{ q.text }}</h4>
					<div class="radio" ng-repeat="a in q.answers">
						<label>
							<input type="radio" name="questions[{{ q.id }}]" ng-model="q.selected" value="{{ a.id }}">
							{{ a.text }}
						</label>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<button type="button" class="btn btn-primary" ng-click="submit()">Submit Answers</button>
				</div>
			</form>
		</div>
	</div>

	<script type="text/ng-template" id="ResultModalTemplate.html">
		<div class="modal-header">
			<h3 class="modal-title">Your Ranking</h3>
		</div>

		<div id="modal-body" class="modal-body text-center">
			<h1><span class="glyphicon glyphicon-certificate"></span></h1>
			<h2>You are at the <strong>{{ level.description }}</strong> level.</h2>
		</div>

		<div class="modal-footer">
			<a href="{{ redirect }}" class="btn btn-primary">Continue</a>
		</div>
	</script>
</div>

<div class="modal fade" id="skip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">You will be ranked as "Beginner"</h4>
			</div>
			<div class="modal-body">
					Skipping the ranking process will automatically rank you as a beginner.
			</div>
			<div class="modal-footer">
				<form action="/rank/skip" class="form-horizontal reg-form" method="GET">
					<input type="submit" class="btn btn-primary" value="Skip"/>
					<input type="button" class="btn btn-primary" data-dismiss="modal" value="Cancel"/>
				</form>
			</div>
		</div>
	</div>
</div>