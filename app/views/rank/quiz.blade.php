@extends('master')

@section('javascript')
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.0/angular.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.11.2/ui-bootstrap-tpls.min.js"></script>
@stop

@section('css')
<style>
	body {
		padding: 3rem 0;
	}
	div.question {
		border-radius: 3px;
		padding: 0.5rem 1rem;
		transition-duration: 0.2s;
		transition-property: background;
	}
</style>
@stop

@section('content')
@include('rank.rankingQuizApp')

<script src="{{ asset('js/RankingQuizApp.js') }}"></script>
@stop