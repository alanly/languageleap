@extends('admin.master')

@section('head')
	<link rel="stylesheet" href="/css/script-editor.admin.css"/>
	<script type="text/javascript" src="/js/script-editor.admin.js"></script>
@stop

@section('content')
	<?php
		use LangLeap\Videos\Video;
	?>
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Insert Custom Quiz
			</div>
			<div class="panel-body">
			<?php
				echo Form::open(array('method' => 'put', 'action' => 'ApiQuizController@putCustomQuestion'));
				
				echo '<div class="form-group"/>';
				echo Form::label('video_id', 'Video', array('class' => 'control-label'));
				
				$dropdowns = array();
				$videos = Video::all()->all();
				foreach($videos as $v)
				{
					$media = $v->viewable;
					$dropdowns[$v->id] = $media->name;
				}
				
				echo Form::select('video_id', $dropdowns, array('class' => 'form-control'));
				echo '</div>';
				
				echo '<div class="form-group"/>';
				echo Form::label('question', 'Question', array('class' => 'control-label'));
				echo Form::text('question', null, array('class' => 'form-control', 'placeholder' => 'Insert question here'));
				echo '</div>';
				
				echo '<div class="form-group"/>';
				echo Form::label('answer[]', 'Correct Answer', array('class' => 'control-label'));
				echo Form::text('answer[]', null, array('class' => 'form-control', 'placeholder' => 'Insert answer here'));
				echo '</div>';
				
				echo '<div class="form-group"/>';
				echo Form::label('answer[]', 'Other Answers', array('class' => 'control-label'));
				echo Form::text('answer[]', null, array('class' => 'form-control', 'placeholder' => 'Insert answer here'));
				echo Form::text('answer[]', null, array('class' => 'form-control', 'placeholder' => 'Insert answer here'));
				echo Form::text('answer[]', null, array('class' => 'form-control', 'placeholder' => 'Insert answer here'));
				echo '</div>';
				
				echo Form::submit('Save', array('class' => 'btn btn-success pull-right'));
				echo Form::close();
				
				$success = Session::get('success');
			?>
			</div> <!-- panel-body -->
		</div> <!-- panel-primary -->
		<?php
		if($success !== null)
			{
				if($success)
				{
		?>
					<div class="alert alert-success">
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
						<span class="sr-only">Save Successful:</span>
						<?php echo Session::get('message') ?>
					</div>
		<?php
				}
				else
				{
		?>
					<div class="alert alert-danger">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">Save Failed:</span>
						<?php echo Session::get('message') ?>
					</div>
		<?php
				}
			}
		?>
	</div> <!-- col-md-6 -->
@stop