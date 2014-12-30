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
				echo Form::open(array('url' => '#', 'method' => 'post'));
				
				echo '<div class="form-group"/>';
				echo Form::label('video', 'Video', array('class' => 'control-label'));
				
				$dropdowns = array();
				$videos = Video::all()->all();
				foreach($videos as $v)
				{
					$media = $v->viewable;
					$dropdowns[$v->id] = $media->name;
				}
				
				echo Form::select('video', $dropdowns, array('class' => 'form-control'));
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
			?>
			</div>
			</div>
		</div>
	</div>
	<div id="edit-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="edit-form" role="form">
					<div class="modal-header">
						<div class="modal-title">
						</div>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@stop