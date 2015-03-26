<div class="modal-header">
	<h2 class="modal-title"><?php echo Lang::get('admin.modal.edit_media.title'); ?></h2>
</div>
<div class="modal-body">
	<form class="row" id="edit-commercial-form">
		<div class="col-md-8" >
			<div class="form-group" ng-class="{ 'has-error' : commercial.name.length === 0 }">
				<label for="commercial-name"> <?php echo Lang::get('admin.media.commercial.table.name'); ?></label>
				<input type="input" id="commercial-name" class="form-control" ng-model="commercial.name"  placeholder="<?php echo Lang::get('admin.media.commercial.table.name'); ?>">
			</div>

			<div class="form-group" ng-class="{ 'has-error' : commercial.genre.description === 0 }">
				<label for="commercial-desc"> <?php echo Lang::get('admin.media.commercial.table.description'); ?></label>
				<textarea class="form-control" id="commercial-desc"  rows="3" ng-model="commercial.description"  placeholder="<?php echo Lang::get('admin.media.commercial.table.description'); ?>"/>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="cover"><?php echo Lang::get('admin.media.commercial.table.poster'); ?></label>
				<img class="thumbnail cover" ng-src="{{ commercial.image_path }}">
				<div class="form-group">
					<input type="file" id="media_image" name="media_image">
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal-footer">
	<button ng-click="saveCommercial(commercial);" class="btn btn-primary"><?php echo Lang::get('admin.buttons.save'); ?> </button>
	<button ng-click="closeModel();" class="btn btn-default"><?php echo Lang::get('admin.buttons.cancel'); ?> </button>
</div>