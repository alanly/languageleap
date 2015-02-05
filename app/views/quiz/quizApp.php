<div class="container" ng-app="quizApp">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="quiz-container" ng-controller="QuizController">
				<carousel interval="-1">
					<slide ng-repeat="question in questions" active="question.active">

						<form id="form-question-id-{{ question.id }}" class="question-form" role="form">
							<h3>{{ question.question }}</h3>
							
							<div ng-switch="{{ question.type }}">
								<div ng-switch-when="multipleChoice" class="radio-group">
									<div class="radio" id="selection-id-{{ question.id }}-{{ definition.id }}" ng-repeat="definition in question.answers">
										<label>
											<input type="radio" name="definition" ng-model="selection.answer_id" value="{{ definition.id }}" ng-click="multiplechoice(selection)">
											{{ definition.answer }}
										</label>
									</div>
								</div>
								
								<div ng-switch-when="dragAndDrop">
								
									<div class="droppable jumbotron">
										Drag answer here.
										<input type="hidden" name="word" ng-model="selection.answer_id" value="-1" ng-change="drag(selection)"/>
									</div>
									
									<div id="selection-id-{{ question.id }}-{{ definition.id }}" ng-repeat="word in question.answers">
										<div class="draggable col-md-3 btn btn-default"   data-word-id="{{ word.id }}">
											{{ word.answer }}
										</div>
									</div>
									
								</div>
							</div>

							<button type="button" id="btn-next-{{ question.id }}" class="btn btn-next" ng-click="nextQuestion()" disabled="disabled">
								{{ currentQuestionIndex == (questions.length - 1) ? 'Finish Quiz' : 'Next Question' }}
							</button>
						</form>
						
					</slide>
				</carousel>
			</div>
		</div>
	</div>

	<script type="text/ng-template" id="scoreModalTemplate.html">
		<div class="modal-header">
			<h3 class="modal-title">Quiz completed!</h3>
		</div>

		<div id="score-modal-body" class="modal-body">
			<h2>Quiz Results</h2>
			<p class="lead">You correctly answered <strong>{{ correctQuestionsCount }}</strong> out of <strong>{{ questionsCount }}</strong> questions.</p>
			<br>
			<span id="final-score">{{ finalScore() }}%</span>
		</div>

		<div class="modal-footer">
			<a href="{{ redirect }}" class="btn btn-primary">Continue</a>
		</div>
	</script>
	
	<script type="text/JavaScript">
		$(function() {
			$(".draggable").draggable({ 
				revert: "invalid",
				start: function(event, ui) {
					$('.droppable').css('outline', '2px solid blue');
				},
				stop: function(event, ui) {
					$('.droppable').css('outline', 'none');
				}
			});
			
			$(".droppable").droppable({
				drop: function( event, ui ) {
					$(this).find("input").val(ui.draggable.attr("data-word-id"));
				}
			});
		});
	</script>
</div>