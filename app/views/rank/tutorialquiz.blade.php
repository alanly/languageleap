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
						{{ Form::label('q1', '', ['class' => 'control-label', 'id' => 'question1']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a1', 'French', false) }} 1</br>
							{{ Form::radio('a1', 'English', false) }} 2</br>
							{{ Form::radio('a1', 'Spanish', false) }} 3</br>
							{{ Form::radio('a1', 'Games', false) }} 4<br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q2', '', ['class' => 'control-label', 'id' => 'question2']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a2', 'Another video', false) }} 5</br>
							{{ Form::radio('a2', 'Nothing', false) }} 6</br>
							{{ Form::radio('a2', 'Picture', false) }} 7</br>
							{{ Form::radio('a2', 'Script', false) }} 8</br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q3', '', ['class' => 'control-label', 'id' => 'question3']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a3', 'Higher difficulties', false) }} 9</br>
							{{ Form::radio('a3', 'Higher rank', false) }} 10</br>
							{{ Form::radio('a3', 'More English knowledge', false) }} 11</br>
							{{ Form::radio('a3', 'All of the above', false) }} 12</br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q4', '', ['class' => 'control-label', 'id' => 'question4']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a4', 'Through highlighting and provided definitions', false) }} 13</br>
							{{ Form::radio('a4', 'With your own dictionary', false) }} 14</br>
							{{ Form::radio('a4', 'Search the definition on Google', false) }} 15</br>
							{{ Form::radio('a4', 'It is impossible to learn new words', false) }} 16</br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q5', '', ['class' => 'control-label', 'id' => 'question5']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a5', 'Account', false) }} 17</br>
							{{ Form::radio('a5', 'Friends', false) }} 18</br>
							{{ Form::radio('a5', 'Nothing', false) }} 19</br>
							{{ Form::radio('a5', 'Being a lurker', false) }} 20</br>
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
	<script type="text/javascript">
		$(document).ready(function() {
			$.ajax({
				type: 'GET',
				url: '/rank/tutorial',
				dataType: 'json',
				success : function(data) {
					alert("derp");
					/*$('#question1').append(data.data.tutorialQuestions[1]);*/
				},
				error : function(data) {
				}
			});
		});
	</script>
@stop