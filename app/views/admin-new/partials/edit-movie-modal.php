<div class="modal-header">
	<h1><?php echo Lang::get('admin.modal.edit_media.title'); ?></h1>
</div>
<div class="modal-body">
	<form class="row">
		<div class="col-md-8" >
			<div class="form-group" ng-class="{ 'has-error' : movie.name.length === 0 }">
				<label for="movie-name"> <?php echo Lang::get('admin.media.movie.table.name'); ?></label>
				<input type="input" id="movie-name" class="form-control" ng-model="movie.name"  placeholder="<?php echo Lang::get('admin.media.movie.table.name'); ?>">
			</div>

			<div class="form-group" ng-class="{ 'has-error' : movie.genre.description === 0 }">
				<label for="movie-desc"> <?php echo Lang::get('admin.media.movie.table.description'); ?></label>
				<textarea class="form-control" id="movie-desc"  rows="3" ng-model="movie.description"  placeholder="<?php echo Lang::get('admin.media.movie.table.description'); ?>"/>
			</div>

			<div class="form-group">
				<label for="movie-director"> <?php echo Lang::get('admin.media.movie.table.director'); ?></label>
				<input type="input" id="movie-director" class="form-control" ng-model="movie.director"  placeholder="<?php echo Lang::get('admin.media.movie.table.director'); ?>">
			</div>

			<div class="form-group">
				<label for="movie-actor"> <?php echo Lang::get('admin.media.movie.table.actor'); ?></label>
				<input type="input" id="movie-actor" class="form-control" ng-model="movie.actor"  placeholder="<?php echo Lang::get('admin.media.movie.table.actor'); ?>">
			</div>

			<div class="form-group">
				<label for="movie-genre"> <?php echo Lang::get('admin.media.movie.table.genre'); ?></label>
				<input type="input" id="movie-genre" class="form-control" ng-model="movie.genre" placeholder="<?php echo Lang::get('admin.media.movie.table.genre'); ?>">
			</div>

		</div>
		<div class="col-md-4">
			<h3><?php echo Lang::get('admin.media.movie.table.poster'); ?></h3>
			<img height="300px" ng-src="{{ movie.image_path }}"/>
			<div class="form-group">
				<input type="file" onchange="angular.element(this).scope().uploadFile(this.files)"/>
			</div>
		</div>
	</form>
</div>

<div class="modal-footer">
	<a ng-click="saveMovie(movie);" class="btn btn-primary"><?php echo Lang::get('admin.buttons.save'); ?> </a>
	<a ng-click="closeModel();" class="btn btn-primary"><?php echo Lang::get('admin.buttons.cancel'); ?> </a>
</div>