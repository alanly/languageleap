<div class="container" ng-app="quizApp">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="quiz-container" ng-controller="QuizController">
				<carousel interval="-1">
					<slide ng-repeat="question in questions" active="true">
						<h3>{{ question.description }}</h3>

						<form class="question-form" role="form">
							<div class="radio-group">
								<div class="radio" ng-repeat="definition in question.definitions">
									<label>
										<input type="radio" id="definition-id-{{ definition.id }}" name="definition" ng-model="selection.definition_id" value="{{ definition.id }}">
										{{ definition.description }}
									</label>
								</div>
							</div>

							<button type="button" id="btn-submit-{{ question.id }}" class="btn btn-primary" ng-click="submit(selection)">Answer</button>
							<button type="button" id="btn-next-{{ question.id }}" class="btn btn-success hide" data-target="#quiz-carousel" data-slide="next">Next Question</button>
						</form>
					</slide>
				</carousel>
			</div>
		</div>
	</div>
</div>