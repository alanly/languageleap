@extends('admin.master')

@section('head')
	<link rel="stylesheet" href="/css/script-editor.admin.css"/>
	<script type="text/javascript" src="/js/script-editor.admin.js"></script>
@stop

@section('content')
	<div id="edit-container">
		<div id="save-success" class="alert alert-success" role="alert">@lang('admin.script.save_success')</div>
		<div id="script" contenteditable=true></div>
		<button id="perma-save" type="button" class="btn btn-success">@lang('admin.buttons.save')</button>
	</div>
	<div id="edit-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="edit-form" role="form">
					<div class="modal-header">
						<div class="modal-title">
							<h2>@lang('admin.modal.edit_script.title')</h2>
						</div>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="selected-text">@lang('admin.modal.edit_script.selected_text')</label>
							<input type="text" id="selected-text" class="form-control" />
						</div>
						<div class="form-group">
							<label>@lang('admin.modal.edit_script.tag_text_as')</label>
							<div class="radio">
								<label>
									<input type="radio" name="tag-radio" id="no-tag-radio" value="none" checked> @lang('admin.terms.none')
								</label>
							</div>
							<div class="radio word-button">
								<label>
									<input type="radio" name="tag-radio" id="word-radio" value="word"> @choice('admin.terms.words', 2)
								</label>
							</div>
							<div class="radio actor-button">
								<label>
									<input type="radio" name="tag-radio" id="actor-radio" value="actor"> @choice('admin.terms.actors', 1)
								</label>
							</div>
						</div>
						<div id="actor-form">
							<div id="timestamp" class="form-group">
								<label>@choice('admin.terms.timestamps', 1)</label>
								<input type="text" class="form-control" title="@lang('admin.modal.edit_script.timestamp.title')"
								       placeholder="@lang('admin.modal.edit_script.timestamp.placeholder')" pattern="^\d+:\d\d$" />
							</div>
						</div>
						<div id="word-form">
							<div id="definition" class="form-group">
								<label>@choice('admin.terms.definitions', 1)</label>
								<textarea type="text" class="form-control" placeholder="Enter a definition"></textarea>
							</div>
							<div id="full-definition" class="form-group">
								<label>@lang('admin.modal.edit_script.full_def')</label>
								<textarea type="text" class="form-control"
								          placeholder="@lang('admin.modal.edit_script.full_def_placehold')"></textarea>
							</div>
							<div id="pronunciation" class="form-group">
								<label>@lang('admin.modal.edit_script.pronun')</label>
								<input type="text" class="form-control" placeholder="@lang('admin.modal.edit_script.pronun_placehold')" />
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">@lang('admin.buttons.save')</button>
						<button id="remove-button" type="button" class="btn btn-danger" data-dismiss="modal">@lang('admin.buttons.remove')</button>
						<button id="cancel-button" type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.buttons.cancel')</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@stop