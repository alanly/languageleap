<div class="modal-header">
	<h2 class="modal-title"><?php echo Lang::get('admin.modal.edit_media.title'); ?></h2>
</div>
<div class="modal-body">
	<form class="row">
		<div class="col-md-8">
			<div class="form-group">
				<label for="name"><?php echo Lang::get('admin.media.show.table.name'); ?></label>
				<input type="text" class="form-control" id="name" placeholder="<?php echo Lang::get('admin.form.placeholders.show.name'); ?>" ng-model="show.name">
			</div>
			<div class="form-group">
				<label for="description"><?php echo Lang::get('admin.media.show.table.description'); ?></label>
				<textarea name="description" class="form-control" id="description" cols="30" rows="5" placeholder="<?php echo Lang::get('admin.form.placeholders.show.description'); ?>" ng-model="show.description"></textarea>
			</div>
			<div class="form-group">
				<label for="directors"><?php echo Lang::get('admin.media.show.table.director'); ?></label>
				<input type="text" name="directors" class="form-control" id="directors" placeholder="<?php echo Lang::get('admin.form.placeholders.show.director'); ?>" ng-model="show.director">
			</div>
			<div class="form-group">
				<label for="actors"><?php echo Lang::get('admin.media.show.table.actor'); ?></label>
				<input type="text" name="actors" class="form-control" id="actors" placeholder="<?php echo Lang::get('admin.form.placeholders.show.actor'); ?>" ng-model="show.actor">
			</div>
			<div class="form-group">
				<label for="genres"><?php echo Lang::get('admin.media.show.table.genre'); ?></label>
				<input type="text" name="genres" class="form-control" id="genres" placeholder="<?php echo Lang::get('admin.form.placeholders.show.genre'); ?>" ng-model="show.genre">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="cover"><?php echo Lang::get('admin.media.show.table.poster'); ?></label>
				<img class="thumbnail cover" ng-src="{{ show.image_path }}">
				<input type="file" id="cover">
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button class="btn btn-primary" ng-click="saveShow()"><?php echo Lang::get('admin.modal.edit_media.save'); ?></button>
	<button class="btn btn-default" ng-click="cancelEdit()"><?php echo Lang::get('admin.modal.cancel'); ?></button>
</div>
