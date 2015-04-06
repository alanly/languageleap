<div class="modal-header">
	<h2 class="modal-title"><?= Lang::get('admin.modal.edit_media.title') ?></h2>
</div>
<div class="modal-body">
	<form class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="number"><?= Lang::get('admin.modal.edit_media.episode_number') ?></label>
				<input type="text" class="form-control" id="number" placeholder="<?= Lang::get('admin.form.placeholders.episode.number') ?>" ng-model="episode.number">
			</div>
			<div class="form-group">
				<label for="name"><?= Lang::get('admin.modal.name') ?></label>
				<input type="number" class="form-control" id="name" placeholder="<?= Lang::get('admin.form.placeholders.episode.name') ?>" ng-model="episode.name">
			</div>
			<div class="form-group">
				<label for="description"><?= Lang::get('admin.modal.description') ?></label>
				<textarea name="description" class="form-control" id="description" cols="30" rows="5" placeholder="<?= Lang::get('admin.form.placeholders.episode.description') ?>" ng-model="episode.description"></textarea>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button class="btn btn-primary" ng-click="saveEpisode()"><?php echo Lang::get('admin.modal.edit_media.save'); ?></button>
	<button class="btn btn-default" ng-click="cancelEdit()"><?php echo Lang::get('admin.modal.cancel'); ?></button>
</div>
