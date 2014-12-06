@extends('admin.master')

@section('head')
	<link rel="stylesheet" href="/css/script-editor.admin.css"/>
	<script type="text/javascript" src="/js/script-editor.admin.js"></script>
@stop

@section('content')
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Insert Custom Quiz
			</div>
			<div class="panel-body">
			<?php
				{{ Form::open(array('url' => '#', 'method' => 'post')); }}
				echo Form::label('question', 'Question', array('class' => 'control-label'));
				echo Form::text('question', null, array('class' => 'form-control', 'placeholder' => 'Insert question here'));
				echo Form::submit('Save', array('class' => 'btn btn-success pull-right'));
				{{ Form::close(); }}
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