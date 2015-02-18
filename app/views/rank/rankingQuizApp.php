<div class="container" ng-app="rankingQuizApp">
	<div class="row">
		<div class="col-sm-6">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#skip"><?php echo Lang::get('rank.quiz.skip') ?></button>
		</div>
		<div class="col-sm-6 col-sm-offset-3">
			<h2><?php echo Lang::get('rank.quiz.intro') ?></h2>
			<p><?php echo Lang::get('rank.quiz.desc') ?></p>

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
					<button type="button" class="btn btn-primary" ng-click="submit()"><?php echo Lang::get('rank.quiz.submit') ?></button>
				</div>
			</form>
		</div>
	</div>

	<script type="text/ng-template" id="ResultModalTemplate.html">
		<div class="modal-header">
			<h3 class="modal-title"><?php echo Lang::get('rank.rank.self') ?></h3>
		</div>

		<div id="modal-body" class="modal-body text-center">
			<h1><span class="glyphicon glyphicon-certificate"></span></h1>
			<h2><?php echo Lang::get('rank.rank.score', ['level' => '{{ level.description }}']) ?></h2>
		</div>

		<div class="modal-footer">
			<a href="{{ redirect }}" class="btn btn-primary"><?php echo Lang::get('rank.rank.continue') ?></a>
		</div>
	</script>
</div>

<div class="modal fade" id="skip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo Lang::get('rank.skip.ranked') ?></h4>
			</div>
			<div class="modal-body">
					<?php echo Lang::get('rank.skip.desc') ?>
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