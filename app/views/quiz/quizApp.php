<div class="container" ng-app="quizApp">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="quiz-container" ng-controller="QuizController">
				<carousel interval="-1">
					<slide ng-repeat="question in questions" active="question.active">
						<h3>{{ question.description }}</h3>

						<form class="question-form" role="form">
							<div class="radio-group">
								<div class="radio" id="radio-selection-id-{{ definition.id }}" ng-repeat="definition in question.definitions">
									<label>
										<input type="radio" name="definition" ng-model="selection.definition_id" value="{{ definition.id }}" ng-click="submit(selection)">
										{{ definition.description }}
									</label>
								</div>
							</div>

							<button type="button" id="btn-submit-{{ question.id }}" class="btn btn-primary" ng-click="submit(selection)">Submit Answer</button>
							<button type="button" id="btn-next-{{ question.id }}" class="btn" ng-click="nextQuestion()" disabled="disabled">Next Question</button>
						</form>
					</slide>
				</carousel>
			</div>
		</div>
	</div>
</div>