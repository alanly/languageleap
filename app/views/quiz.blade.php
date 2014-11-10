@extends('master')

@section('javascript')
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.0/angular.min.js"></script>
@stop

@section('content')
<div class="container" ng-app="quizApp">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="quiz-container" ng-controller="QuizController">
				<div id="quiz-carousel" class="carousel slide" data-ride="carousel">

					<!-- Slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active" ng-repeat="question in questions">
							<h3>{% question.string %}</h3>

							<form role="form">
								<div class="radio" ng-repeat="definition in question.definitions">
									<label>
										<input type="radio" name="definition" ng-model="selection.definition_id" value="{% definition.id %}">
										{% definition.description %}
									</label>
								</div>

								<button type="button" class="btn btn-primary" ng-click="submit(selection)">Next</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$('#quiz-carousel').carousel({
	interval: false
});
</script>
<script src="{{ asset('js/QuizController.js') }}"></script>
@stop