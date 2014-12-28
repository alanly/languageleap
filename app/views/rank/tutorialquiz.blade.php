@extends('master')

@section('css')
<style>
	body {
		padding-top: 3rem;
	}
	.reg-form {
		padding-top: 3rem;
	}
</style>
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="text-center">Tutorial Quiz!</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-6 col-md-offset-3">
				{{ Form::open(['url' => 'tutorialquiz', 'class' => 'form-horizontal reg-form', 'role' => 'form', 'action' => 'RankQuizController@rankUser']) }}
					<div class="form-group">
						{{ Form::label('q1', '1. What does Language Leap teach?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a1', 'french', false) }} French </br>
							{{ Form::radio('a1', 'english', false) }} English </br>
							{{ Form::radio('a1', 'spanish', false) }} Spanish </br>
							{{ Form::radio('a1', 'games', false) }} Math </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q2', '2. What do you see beside the video?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a2', 'video', false) }} Another video </br>
							{{ Form::radio('a2', 'nothing', false) }} Nothing at all </br>
							{{ Form::radio('a2', 'picture', false) }} Picture </br>
							{{ Form::radio('a2', 'script', false) }} Script </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q3', '3. What can you gain by spending more time on Language Leap?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a3', 'higher', false) }} Higher difficulties </br>
							{{ Form::radio('a3', 'rank', false) }}  Higher rank</br>
							{{ Form::radio('a3', 'knowledge', false) }} More English knowledge </br>
							{{ Form::radio('a3', 'all', false) }} All of the above </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q4', '4. How do you learn new words?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a4', 'definition', false) }} Through highlighting and provided definitions </br>
							{{ Form::radio('a4', 'dictionary', false) }}  With your own dictionary</br>
							{{ Form::radio('a4', 'search', false) }} Search the definition on Google </br>
							{{ Form::radio('a4', 'impossible', false) }} It is impossible to learn new words </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q5', '5. What do you need to use Language Leap?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a5', 'account', false) }} An account </br>
							{{ Form::radio('a5', 'friends', false) }}  Friends</br>
							{{ Form::radio('a5', 'nothing', false) }} Nothing </br>
							{{ Form::radio('a5', 'lurker', false) }} Being a lurker </br>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							{{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop