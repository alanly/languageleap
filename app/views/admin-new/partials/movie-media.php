<h1><?= Lang::get('admin.video.video_editing'); ?></h1>
<div>
	<div class="video-section">
		<div class="col-md-6">
			<div class="title">
				<h4><?= Lang::get('admin.video.title', ['name' => '{{ current_movie.name }}']); ?></h4>
			</div>
			<div ng-if="current_movie.video.id === null">
				<video ng-src="video.path"/>
			</div>

			<div ng-if="current_movie.video.length !== 0">
				<input type="file" name="video" id="video"/>
			</div>
		</div>
		<div class="timestamps col-md-6">
			<h4>Timestamps</h4>
			<div ng-repeat="timestamp in video.timestamps">
				<input type="text" class="input-sm" ng-model="timestamp.start"/> 
				TO:
				<input type="text" class="input-sm" ng-model="timestamp.end"/> 
				<a href="" ng-click="removeTimestamp(timestamp);">X</a>
			</div>
			<a href="" ng-click="addTimestamp()">+</a>
		</div>
	</div>
	<div style="clear:both;"></div>

<br/>
<br/>
<br/>
<br/>

	<div class="script-section">
		<div class="script-editor" contenteditable="true" ng-bind="video.script">
		</div>
	</div>

	<a href="" ng-click="saveMedia()" class="btn btn-primary"><?= Lang::get('admin.media.video.save'); ?></a>
</div>	

<script src="/js/admin-script.js"></script>