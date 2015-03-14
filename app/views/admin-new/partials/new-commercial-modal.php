<div class="modal-header">
	<h1><?php echo Lang::get('admin.modal.edit_media.title'); ?></h1>
</div>
<div class="modal-body">
	<form class="row">
		<div class="col-md-8" >
			<div class="form-group">
				<label for="commercial-name"> <?php echo Lang::get('admin.media.commercial.table.name'); ?></label>
				<input type="input" id="commercial-name"  name="name" class="form-control" ng-model="commercial.name"  placeholder="<?php echo Lang::get('admin.media.commercial.table.name'); ?>">
			</div>

			<div class="form-group">
				<label for="commercial-desc"> <?php echo Lang::get('admin.media.commercial.table.description'); ?></label>
				<textarea class="form-control" id="commercial-desc" name="description" rows="3" ng-model="commercial.description"  placeholder="<?php echo Lang::get('admin.media.commercial.table.description'); ?>"/>
			</div>

			<div class="form-group">
				<label for="commercial-director"> <?php echo Lang::get('admin.media.commercial.table.director'); ?></label>
				<input type="input" id="commercial-director" name="director" class="form-control" ng-model="commercial.director"  placeholder="<?php echo Lang::get('admin.media.commercial.table.director'); ?>">
			</div>

			<div class="form-group">
				<label for="commercial-actor"> <?php echo Lang::get('admin.media.commercial.table.actor'); ?></label>
				<input type="input" id="commercial-actor" name="actor" class="form-control" ng-model="commercial.actor"  placeholder="<?php echo Lang::get('admin.media.commercial.table.actor'); ?>">
			</div>

			<div class="form-group" >
				<label for="commercial-genre"> <?php echo Lang::get('admin.media.commercial.table.genre'); ?></label>
				<input type="input" id="commercial-genre" name="genre" class="form-control" ng-model="commercial.genre" placeholder="<?php echo Lang::get('admin.media.commercial.table.genre'); ?>">
			</div>

		</div>
		<div class="col-md-4">
			<h3><?php echo Lang::get('admin.media.commercial.table.poster'); ?></h3>
			<img height="300px" ng-src="{{ commercial.image_path }}"/>
			<div class="form-group">
				<input type="file" id="media-image" name="media-image">
			</div>
		</div>
	</form>
</div>

<div class="modal-footer">
	<a ng-click="storeCommercial(commercial);" class="btn btn-primary"><?php echo Lang::get('admin.buttons.save'); ?> </a>
	<a ng-click="" class="btn btn-primary"><?php echo Lang::get('admin.buttons.cancel'); ?> </a>
</div>