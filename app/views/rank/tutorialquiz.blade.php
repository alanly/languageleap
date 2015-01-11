@extends('master')

@section('css')
<style>
	body {
		padding-top: 3rem;
	}
	.reg-form {
		padding-top: 3rem;
	}
	.skip{
		position: fixed;
		top: 0px;
		right: 0px; 
	}
</style>
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-4">
				<button type="button" class="btn btn-primary btn-lg skip" data-toggle="modal" data-target="#skip">Skip Ranking Process</button>
			</div>

			<div class="modal fade" id="skip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">You will be ranked as "Beginner"</h4>
							</div>
							<div class="modal-body">
	 							Skipping the ranking process will automatically rank you as a beginner.
							</div>
						<div class="modal-footer">
							{{ Form::open(['url' => '/rank/skip', 'class' => 'form-horizontal reg-form', 'role' => 'form', 'method' => 'GET']) }}
							{{ Form::submit('Continue', ['class' => 'btn btn-primary']) }}
							{{ Form::button('Cancel', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) }}
							{{ Form::close() }}
						</div>
						</div>
					</div>
			</div>
			<div class="col-sm-12">
				<h2 class="text-center">Tutorial Quiz!</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-6 col-md-offset-3">
				{{ Form::open(['url' => '/rank/quiz/answers', 'class' => 'form-horizontal reg-form', 'role' => 'form', 'action' => 'POST']) }}
					<div class="form-group">
						{{ Form::label('q1', '1. ', ['class' => 'control-label', 'id' => 'q1']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a1', 'French', false) }}
							{{ Form::label('a1', ' ', ['class' => 'control-label', 'id' => 'a1']) }} </br>
							{{ Form::radio('a1', 'English', false) }}
							{{ Form::label('a1', ' ', ['class' => 'control-label', 'id' => 'a2']) }} </br>
							{{ Form::radio('a1', 'Spanish', false) }}
							{{ Form::label('a1', ' ', ['class' => 'control-label', 'id' => 'a3']) }} </br>
							{{ Form::radio('a1', 'Games', false) }} 
							{{ Form::label('a1', ' ', ['class' => 'control-label', 'id' => 'a4']) }} <br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q2', '2. ', ['class' => 'control-label', 'id' => 'q2']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a2', 'Another video', false) }} 
							{{ Form::label('a2', ' ', ['class' => 'control-label', 'id' => 'a5']) }} </br>
							{{ Form::radio('a2', 'Nothing', false) }} 
							{{ Form::label('a2', ' ', ['class' => 'control-label', 'id' => 'a6']) }} </br>
							{{ Form::radio('a2', 'Picture', false) }} 
							{{ Form::label('a2', ' ', ['class' => 'control-label', 'id' => 'a7']) }} </br>
							{{ Form::radio('a2', 'Script', false) }} 
							{{ Form::label('a2', ' ', ['class' => 'control-label', 'id' => 'a8']) }} </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q3', '3. ' , ['class' => 'control-label', 'id' => 'q3']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a3', 'Higher difficulties', false) }} 
							{{ Form::label('a3', ' ', ['class' => 'control-label', 'id' => 'a9']) }} </br>
							{{ Form::radio('a3', 'Higher rank', false) }} 
							{{ Form::label('a3', ' ', ['class' => 'control-label', 'id' => 'a10']) }} </br>
							{{ Form::radio('a3', 'More English knowledge', false) }} 
							{{ Form::label('a3', ' ', ['class' => 'control-label', 'id' => 'a11']) }} </br>
							{{ Form::radio('a3', 'All of the above', false) }} 
							{{ Form::label('a3', ' ', ['class' => 'control-label', 'id' => 'a12']) }} </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q4', '4. ', ['class' => 'control-label', 'id' => 'q4']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a4', 'Through highlighting and provided definitions', false) }}
							{{ Form::label('a4', ' ', ['class' => 'control-label', 'id' => 'a13']) }} </br>
							{{ Form::radio('a4', 'With your own dictionary', false) }} 
							{{ Form::label('a4', ' ', ['class' => 'control-label', 'id' => 'a14']) }} </br>
							{{ Form::radio('a4', 'Search the definition on Google', false) }} 
							{{ Form::label('a4', ' ', ['class' => 'control-label', 'id' => 'a15']) }} </br>
							{{ Form::radio('a4', 'It is impossible to learn new words', false) }} 
							{{ Form::label('a4', ' ', ['class' => 'control-label', 'id' => 'a16']) }} </br>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('q5', '5. ', ['class' => 'control-label', 'id' => 'q5']) }} </br>
						<div class="col-sm-8">
							{{ Form::radio('a5', 'Account', false) }} 
							{{ Form::label('a5', ' ', ['class' => 'control-label', 'id' => 'a17']) }} </br>
							{{ Form::radio('a5', 'Friends', false) }} 
							{{ Form::label('a5', ' ', ['class' => 'control-label', 'id' => 'a18']) }} </br>
							{{ Form::radio('a5', 'Nothing', false) }} 
							{{ Form::label('a5', ' ', ['class' => 'control-label', 'id' => 'a19']) }} </br>
							{{ Form::radio('a5', 'Being a lurker', false) }} 
							{{ Form::label('a5', ' ', ['class' => 'control-label', 'id' => 'a20']) }} </br>
						</div>
					</div>
					
					{{ Form::hidden('q1', '', ['id' => 'q1id']) }}
					{{ Form::hidden('q2', '', ['id' => 'q2id']) }}
					{{ Form::hidden('q3', '', ['id' => 'q3id']) }}
					{{ Form::hidden('q4', '', ['id' => 'q4id']) }}
					{{ Form::hidden('q5', '', ['id' => 'q5id']) }}
					
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
					$("#q1").append(data.data[0][0].question);
					$("#q1id").val(data.data[0][0].id);
					$("#a1").append(data.data[1][0].answer);
					$("#a2").append(data.data[1][1].answer);
					$("#a3").append(data.data[1][2].answer);
					$("#a4").append(data.data[1][3].answer);
					
					$("#q2").append(data.data[0][1].question);
					$("#q2id").val(data.data[0][1].id);
					$("#a5").append(data.data[1][4].answer);
					$("#a6").append(data.data[1][5].answer);
					$("#a7").append(data.data[1][6].answer);
					$("#a8").append(data.data[1][7].answer);
					
					$("#q3").append(data.data[0][2].question);
					$("#q3id").val(data.data[0][2].id);
					$("#a9").append(data.data[1][8].answer);
					$("#a10").append(data.data[1][9].answer);
					$("#a11").append(data.data[1][10].answer);
					$("#a12").append(data.data[1][11].answer);
					
					$("#q4").append(data.data[0][3].question);
					$("#q4id").val(data.data[0][3].id);
					$("#a13").append(data.data[1][12].answer);
					$("#a14").append(data.data[1][13].answer);
					$("#a15").append(data.data[1][14].answer);
					$("#a16").append(data.data[1][15].answer);
					
					$("#q5").append(data.data[0][4].question);
					$("#q5id").val(data.data[0][4].id);
					$("#a17").append(data.data[1][16].answer);
					$("#a18").append(data.data[1][17].answer);
					$("#a19").append(data.data[1][18].answer);
					$("#a20").append(data.data[1][19].answer);
				}
			});
		});
	</script>
@stop