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
				{{ Form::open(['url' => 'tutorialquiz', 'class' => 'form-horizontal reg-form', 'role' => 'form', 'action' => 'RankQuizController@checkAnsweredAll']) }}
					<div class="form-group">
						{{ Form::label('q1', '1. What does Language Leap teach?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a1', 'French', false) }} French </br>
							{{ Form::radio('a1', 'English', false) }} English </br>
							{{ Form::radio('a1', 'Spanish', false) }} Spanish </br>
							{{ Form::radio('a1', 'Games', false) }} Math </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q2', '2. What do you see beside the video?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a2', 'Another video', false) }} Another video </br>
							{{ Form::radio('a2', 'Nothing', false) }} Nothing </br>
							{{ Form::radio('a2', 'Picture', false) }} Picture </br>
							{{ Form::radio('a2', 'Script', false) }} Script </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q3', '3. What can you gain by spending more time on Language Leap?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a3', 'Higher difficulties', false) }} Higher difficulties </br>
							{{ Form::radio('a3', 'Higher rank', false) }} Higher rank</br>
							{{ Form::radio('a3', 'More English knowledge', false) }} More English knowledge </br>
							{{ Form::radio('a3', 'All of the above', false) }} All of the above </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q4', '4. How do you learn new words?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a4', 'Through highlighting and provided definitions', false) }} Through highlighting and provided definitions </br>
							{{ Form::radio('a4', 'With your own dictionary', false) }}  With your own dictionary</br>
							{{ Form::radio('a4', 'Search the definition on Google', false) }} Search the definition on Google </br>
							{{ Form::radio('a4', 'It is impossible to learn new words', false) }} It is impossible to learn new words </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q5', '5. What do you need to use Language Leap?', ['class' => 'control-label']) }}
						<div class="col-sm-8">
							{{ Form::radio('a5', 'Account', false) }} An account </br>
							{{ Form::radio('a5', 'Friends', false) }}  Friends</br>
							{{ Form::radio('a5', 'Nothing', false) }} Nothing </br>
							{{ Form::radio('a5', 'Being a lurker', false) }} Being a lurker </br>
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