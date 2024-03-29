<div class="modal-header">
	<h2 class="modal-title"><?php echo Lang::get('admin.modal.new_media.title'); ?></h2>
</div>
<div class="modal-body">
	<form class="row" id="new-movie-form">
		<div class="col-md-8" >
			<div class="form-group">
				<label for="movie-name"> <?php echo Lang::get('admin.media.movie.table.name'); ?></label>
				<input type="input" id="movie-name"  name="name" class="form-control" ng-model="movie.name"  placeholder="<?php echo Lang::get('admin.media.movie.table.name'); ?>">
			</div>

			<div class="form-group">
				<label for="movie-desc"> <?php echo Lang::get('admin.media.movie.table.description'); ?></label>
				<textarea class="form-control" id="movie-desc" name="description" rows="3" ng-model="movie.description"  placeholder="<?php echo Lang::get('admin.media.movie.table.description'); ?>"/>
			</div>

			<div class="form-group">
				<label for="movie-director"> <?php echo Lang::get('admin.media.movie.table.director'); ?></label>
				<input type="input" id="movie-director" name="director" class="form-control" ng-model="movie.director"  placeholder="<?php echo Lang::get('admin.media.movie.table.director'); ?>">
			</div>

			<div class="form-group">
				<label for="movie-actor"> <?php echo Lang::get('admin.media.movie.table.actor'); ?></label>
				<input type="input" id="movie-actor" name="actor" class="form-control" ng-model="movie.actor"  placeholder="<?php echo Lang::get('admin.media.movie.table.actor'); ?>">
			</div>

			<div class="form-group" >
				<label for="movie-genre"> <?php echo Lang::get('admin.media.movie.table.genre'); ?></label>
				<input type="input" id="movie-genre" name="genre" class="form-control" ng-model="movie.genre" placeholder="<?php echo Lang::get('admin.media.movie.table.genre'); ?>">
			</div>

		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="cover"><?php echo Lang::get('admin.media.movie.table.poster'); ?></label>
				<img class="thumbnail cover" ng-src="{{ movie.image_path }}"/>
				<div class="form-group">
					<input type="file" name="media_image" id="media_image"/>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal-footer">
	<button ng-click="storeMovie();" class="btn btn-primary"><?php echo Lang::get('admin.buttons.save'); ?> </button>
	<button ng-click="closeModel();" class="btn btn-default"><?php echo Lang::get('admin.buttons.cancel'); ?> </button>
</div>