<div id="edit-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="edit-form" role="form">
				<div class="modal-header">
					<div class="modal-title">
						<h2>Edit</h2>
					</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="selected-text">Selected text</label>
						<input type="text" id="selected-text" class="form-control" />
					</div>
					<div class="form-group">
						<label>Tag text as</label>
						<div class="radio">
							<label>
								<input type="radio" name="tag-radio" id="no-tag-radio" value="none" checked> None
							</label>
						</div>
						<div class="radio word-button">
							<label>
								<input type="radio" name="tag-radio" id="word-radio" value="word"> Word(s)
							</label>
						</div>
						<div class="radio actor-button">
							<label>
								<input type="radio" name="tag-radio" id="actor-radio" value="actor"> Actor
							</label>
						</div>
					</div>
					<div id="actor-form">
						<div id="timestamp" class="form-group">
							<label>Timestamp</label>
							<input type="text" class="form-control" title="'#:##' (ie. 2:46)" placeholder="Enter the clip time (ie. 2:46)" pattern="^\d+:\d\d$" />
						</div>
					</div>
					<div id="word-form">
						<div id="definition" class="form-group">
							<label>Definition</label>
							<textarea type="text" class="form-control" placeholder="Enter a definition"></textarea>
						</div>
						<div id="full-definition" class="form-group">
							<label>Full Definition (Optional)</label>
							<textarea type="text" class="form-control" placeholder="Enter a full definition"></textarea>
						</div>
						<div id="pronunciation" class="form-group">
							<label>Pronunciation (Optional)</label>
							<input type="text" class="form-control" placeholder="Enter the pronunciation" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="save-button" type="submit" class="btn btn-primary">Save</button>
					<button id="remove-button" type="button" class="btn btn-danger" data-dismiss="modal">Remove</button>
					<button id="cancel-button" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->