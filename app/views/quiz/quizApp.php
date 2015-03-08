<div class="container" ng-app="quizApp">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="quiz-container" ng-controller="QuizController">
				<carousel interval="-1">
					<slide ng-repeat="question in questions" active="question.active">

						<form id="form-question-id-{{ question.id }}" class="question-form" role="form">
							<h3>{{ question.question }}</h3>
							
							<div ng-switch="question.type">
							
								<div ng-switch-when="multipleChoice" class="radio-group">
									<div class="radio" id="selection-id-{{ question.id }}-{{ definition.id }}" ng-repeat="definition in question.answers">
										<label>
											<input type="radio" name="definition" ng-model="selection.answer_id" value="{{ definition.id }}" ng-click="multiplechoice(selection)">
											{{ definition.answer }}
										</label>
									</div>
								</div>
								
								<div ng-switch-when="dragAndDrop">
								
									<span class="droppable label label-default" data-drop="true"  jqyoui-droppable="{ onDrop: 'drag'}">_______</span>
									
									<div class="btn-group" style="padding-bottom:10px">
									
										<div id="selection-id-{{ question.id }}-{{ word.id }}" class="pull-left" ng-repeat="word in question.answers" style="padding:5px">
											<div class="btn btn-primary"  data-word-id="{{ word.id }}" data-drag="true" data-jqyoui-options="{revert: 'invalid'}" jqyoui-draggable="{animate:true}">
												{{ word.answer }}
											</div>
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
			<h3 class="modal-title"><?php echo Lang::get('quiz.completed') ?></h3>
		</div>

		<div id="score-modal-body" class="modal-body">
			<h2><?php echo Lang::get('quiz.results.quiz') ?></h2>
			<p class="lead"><?php echo Lang::get('quiz.results.result', ['correct' => "{{ correctQuestionsCount }}", 'count' => "{{ questionsCount }}"]) ?></p>
			<br>
			<span id="final-score">{{ finalScore() }}%</span>
			<br/>
			<span id="level-up">{{ levelUp() }}</span>
			<hr>
			<h4>Recommended</h4>
			<div id="recommended"></div>
		</div>

		<div class="modal-footer">
			<a href="{{ redirect }}" class="btn btn-primary"><?php echo Lang::get('quiz.continue') ?></a>
		</div>
		
		<script>
			function refreshPopovers() {
				$('[data-toggle="popover"]').popover();
			}

			function getContentUrl(content) {
				var typeArray = content.type.split('\\');
				var type = typeArray[typeArray.length - 1].toLowerCase();

				return '/' + type + '/' + content.id;
			}

			function onLoadRecommendedSuccess(data) {
				$.each(data.data, function(i, v) {
					var url = getContentUrl(v);
					var coverUrl = (v.image_path) ? v.image_path : 'http://placehold.it/115x153';
					var element = 	'<div class="element">' +
										'<a href="' + url + '" class="thumbnail cover" data-toggle="popover" data-trigger="hover" data-placement="auto" title="' + v.name + '" data-content="' + v.description + '">' +
											'<img src="' + coverUrl + '" />' +
										'</a>' +
									'</div>';

					$('#recommended').append(element);
				});

				refreshPopovers();
			}

			function loadRecommendations() {
				var url = '/api/metadata/recommended';
				var data = { 'take' : 4 };
				$.ajax({
					type: 'GET',
					url: url,
					data: data,
					success: onLoadRecommendedSuccess,
					error: function(data) {
					}
				});
			}

			$(function() {
				loadRecommendations();
			});
		</script>
	</script>	
</div>