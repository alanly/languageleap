<h3><?= Lang::get('admin.video.video_editing'); ?></h3>
<tabset>
	<tab heading="Video">
		<div class="tab-content">
			<div id="video-section">
				<div class="col-md-6">
					<div class="title">
						<h4><?= Lang::get('admin.video.title', ['name' => '{{ current_movie.name }}']); ?></h4>
					</div>
					<div ng-if="current_movie.video.id !== null">
						<video style="width:100%;" ng-src="{{video.path}}" controls></video>
					</div>
				</div>
				<div class="timestamps col-md-6">
					<h4><?= Lang::get('admin.video.timestamps.title'); ?></h4>
					<div ng-repeat="timestamp in video.timestamps">
						<input type="text" class="input-sm" ng-model="timestamp.from"/> 
						<?= Lang::get('admin.video.timestamps.to'); ?>
						<input type="text" class="input-sm" ng-model="timestamp.to"/> 
						<a href="" ng-click="removeTimestamp(timestamp);"><?= Lang::get('admin.video.timestamps.remove'); ?></a>
					</div>
					<a href="" ng-click="addTimestamp()">+</a>
				</div>
			</div>
		</div>
		<div style="clear:both;"></div>
		<a href="" ng-click="saveTimestamps()" class="btn btn-primary"><?= Lang::get('admin.media.video.save_timestamps'); ?></a>
	</tab>
	<tab heading="Update Video">
		<input type="file" name="video" id="video" class="file-input"/>

		<a href="" ng-click="saveMedia()" class="btn btn-primary"><?= Lang::get('admin.media.video.update'); ?></a>
	</tab>
</tabset>

<div style="clear:both;"></div>	

<hr/>

<h3><?= Lang::get('admin.script.script_editing'); ?></h3>

<div class="alert alert-info">
	<?= Lang::get('admin.script.srt_info'); ?>
</div>

<input type="file" id="parsable-script" class="file-input"/>
<a href="" ng-click="parseFile();" class="btn btn-primary"><?= Lang::get('admin.media.script.import'); ?></a>

<br/>

<div class="script-editor" ng-blur="setScript();" contenteditable="true">
</div>

<a href="" ng-click="saveMedia()" class="btn btn-primary"><?= Lang::get('admin.media.script.save'); ?></a>

<div class="script-section">
	<!--
		The next div and the proceeding modal are highly dependent on each other.
		Be very careful if changes need to be done to the structure. The class names
		and ids should not be changed unless you plan on refactoring the javascript file
		related to the script editor. Note that the script editor was implemented way before
		the decision to use AngularJS was made and has not been migrated to use Angular.
	-->
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
								<label>Full Definition</label>
								<textarea type="text" class="form-control" placeholder="Enter a full definition"></textarea>
							</div>
							<div id="pronunciation" class="form-group">
								<label>Pronunciation</label>
								<input type="text" class="form-control" placeholder="Enter the pronunciation" />
							</div>
							<div id="synonyms" class="form-group">
								<label>Synonyms</label>
								<input type="text" class="form-control" placeholder="Enter comma separated synonyms" />
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
</div>
<script src="/js/admin-script.js"></script>