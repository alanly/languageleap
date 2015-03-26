<div class="modal-header">
	<h2 class="modal-title"><?= Lang::get('admin.modal.edit_media.title'); ?></h2>
</div>
<div class="modal-body">
	<form class="row" id="new-movie-form">
		<div class="col-md-8" >
			<div class="form-group" ng-class="{ 'has-error' : movie.name.length === 0 }">
				<label for="movie-name"> <?= Lang::get('admin.media.movie.table.name'); ?></label>
				<input type="input" id="movie-name" class="form-control" ng-model="movie.name"  placeholder="<?= Lang::get('admin.media.movie.table.name'); ?>">
			</div>

			<div class="form-group" ng-class="{ 'has-error' : movie.genre.description === 0 }">
				<label for="movie-desc"> <?= Lang::get('admin.media.movie.table.description'); ?></label>
				<textarea class="form-control" id="movie-desc"  rows="3" ng-model="movie.description"  placeholder="<?= Lang::get('admin.media.movie.table.description'); ?>"/>
			</div>

			<div class="form-group">
				<label for="movie-director"> <?= Lang::get('admin.media.movie.table.director'); ?></label>
				<input type="input" id="movie-director" class="form-control" ng-model="movie.director"  placeholder="<?= Lang::get('admin.media.movie.table.director'); ?>">
			</div>

			<div class="form-group">
				<label for="movie-actor"> <?= Lang::get('admin.media.movie.table.actor'); ?></label>
				<input type="input" id="movie-actor" class="form-control" ng-model="movie.actor"  placeholder="<?= Lang::get('admin.media.movie.table.actor'); ?>">
			</div>

			<div class="form-group">
				<label for="movie-genre"> <?= Lang::get('admin.media.movie.table.genre'); ?></label>
				<input type="input" id="movie-genre" class="form-control" ng-model="movie.genre" placeholder="<?= Lang::get('admin.media.movie.table.genre'); ?>">
			</div>

		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="cover"><?php echo Lang::get('admin.media.movie.table.poster'); ?></label>
				<img class="thumbnail cover" ng-src="{{ movie.image_path }}">
				<div class="form-group">
					<input type="file" name="media_image" id="media_image"/>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal-footer">
	<button ng-click="saveMovie(movie);" class="btn btn-primary"><?= Lang::get('admin.buttons.save'); ?> </button>
	<button ng-click="closeModel();" class="btn btn-default"><?= Lang::get('admin.buttons.cancel'); ?> </button>
</div>