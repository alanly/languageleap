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
						{{ Form::label('q1', $q1, ['class' => 'control-label']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a1', 'French', false) }} {{ $a1 }} </br>
							{{ Form::radio('a1', 'English', false) }} {{ $a2 }} </br>
							{{ Form::radio('a1', 'Spanish', false) }} {{ $a3 }} </br>
							{{ Form::radio('a1', 'Games', false) }} {{ $a4 }} </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q2', $q2, ['class' => 'control-label']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a2', 'Another video', false) }} {{ $a5 }} </br>
							{{ Form::radio('a2', 'Nothing', false) }} {{ $a6 }} </br>
							{{ Form::radio('a2', 'Picture', false) }} {{ $a7 }} </br>
							{{ Form::radio('a2', 'Script', false) }} {{ $a8 }} </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q3', $q3, ['class' => 'control-label']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a3', 'Higher difficulties', false) }} {{ $a9 }} </br>
							{{ Form::radio('a3', 'Higher rank', false) }} {{ $a10 }} </br>
							{{ Form::radio('a3', 'More English knowledge', false) }} {{ $a11 }}  </br>
							{{ Form::radio('a3', 'All of the above', false) }} {{ $a12 }} </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q4', $q4, ['class' => 'control-label']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a4', 'Through highlighting and provided definitions', false) }} {{ $a13 }} </br>
							{{ Form::radio('a4', 'With your own dictionary', false) }} {{ $a14 }} </br>
							{{ Form::radio('a4', 'Search the definition on Google', false) }} {{ $a15 }} </br>
							{{ Form::radio('a4', 'It is impossible to learn new words', false) }} {{ $a16 }} </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q5', $q1, ['class' => 'control-label']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a5', 'Account', false) }} {{ $a17 }} </br>
							{{ Form::radio('a5', 'Friends', false) }}  {{ $a18 }}</br>
							{{ Form::radio('a5', 'Nothing', false) }} {{ $a19 }} </br>
							{{ Form::radio('a5', 'Being a lurker', false) }} {{ $a20 }} </br>
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