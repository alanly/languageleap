@extends('master')

@section('javascript')
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.0/angular.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.11.2/ui-bootstrap-tpls.min.js"></script>
<script src="js/angular-dragdrop.min.js"></script>
@stop

@section('css')
<style>
	.carousel-indicators, .carousel-control { display: none; }
	.radio-group { padding: 1rem 3rem 2rem; text-align: left; }
	label, .btn { transition-duration: 0.3s; }
	.has-success label { font-weight: 800; }
	#score-modal-body { text-align: center; }
	#final-score { font-size: 4rem; font-weight: 800; padding-bottom: 1rem; }	
	#level-up { font-size: 6rem; font-weight: 800; padding-bottom: 2rem; }
	#recommended .cover img { height: 153px; width: 115px; }
	#recommended .element {	display: inline-block; padding: 5px; }
</style>
@stop

@section('content')
@include('quiz.quizApp')

<script>
$('#quiz-carousel').carousel(
{
	interval: false
});
</script>
<script src="{{ asset('js/QuizController.js') }}"></script>
@stop