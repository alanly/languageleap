@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="/css/script-editor.admin.css"/>
@stop

@section('javascript')
	<script type="text/javascript" src="/js/script-editor.admin.js"></script>
@stop

@section('content')
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				@lang('admin.quiz.insert.heading')
			</div>
			<div class="panel-body">
			{{ Form::open(array('method' => 'put', 'action' => 'ApiQuizController@putCustomQuestion')) }}
				<div class="form-group"/>
				{{ Form::label('video_id', trans('admin.quiz.insert.video_label'), array('class' => 'control-label')) }}
				<select name="video_id" id="video_id">
					@foreach($videos as $v)
						<option value="{{ $v->id }}">{{ $v->viewable->name }}</option>
					@endforeach
				</select>
				</div>
				
				<div class="form-group"/>
					{{ Form::label('question', trans('admin.quiz.insert.question_label'), array('class' => 'control-label')) }}
					{{ Form::text('question', null, array('class' => 'form-control', 'placeholder' => trans('admin.quiz.insert.question_placeholder'))) }}
				</div>
				
				<div class="form-group"/>
				{{ Form::label('answer[]', trans('admin.quiz.insert.correct_answer_label'), array('class' => 'control-label')) }}
				{{ Form::text('answer[]', null, array('class' => 'form-control', 'placeholder' => trans('admin.quiz.insert.answer_placeholder'))) }}
				</div>
				
				<div class="form-group"/>
					{{ Form::label('answer[]', trans('admin.quiz.insert.other_answers_label'), array('class' => 'control-label')) }}
					{{ Form::text('answer[]', null, array('class' => 'form-control', 'placeholder' => trans('admin.quiz.insert.answer_placeholder'))) }}
					{{ Form::text('answer[]', null, array('class' => 'form-control', 'placeholder' => trans('admin.quiz.insert.answer_placeholder'))) }}
					{{ Form::text('answer[]', null, array('class' => 'form-control', 'placeholder' => trans('admin.quiz.insert.answer_placeholder'))) }}
				</div>
			
				{{ Form::submit(trans('admin.quiz.insert.save_button'), array('class' => 'btn btn-success pull-right')) }}
			{{ Form::close() }}
			</div> <!-- panel-body -->
		</div> <!-- panel-primary -->
		
		@if(Session::get('success') !== null)
			@if(Session::get('success'))
				<div class="alert alert-success">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
					<span class="sr-only">@lang('admin.quiz.insert.save_success'):</span>
					{{ Session::get('message') }}
				</div>
			@else
				<div class="alert alert-danger">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">@lang('admin.quiz.insert.save_fail'):</span>
					{{ Session::get('message') }}
				</div>
			@endif
		@endif
	</div> <!-- col-md-6 -->
@stop