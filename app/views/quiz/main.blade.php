@extends('master')

@section('javascript')
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.0/angular.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.11.2/ui-bootstrap-tpls.min.js"></script>
@stop

@section('css')
<style>
	.carousel-indicators, .carousel-control { display: none; }
	.radio-group { padding: 1rem 3rem 2rem; text-align: left; }
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