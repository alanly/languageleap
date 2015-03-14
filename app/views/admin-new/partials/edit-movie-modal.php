<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12" >
			<h1><?php echo Lang::get('admin.modal.edit_media.title'); ?></h1>
			<form>
				<div class="form-group">
					<label for="movie-name"> <?php echo Lang::get('admin.media.movie.table.name'); ?></label>
					<input type="input" id="movie-name" class="form-control" ng-model="movie.name">
				</div>

				<div class="form-group">
					<label for="movie-desc"> <?php echo Lang::get('admin.media.movie.table.description'); ?></label>
					<textarea class="form-control" id="movie-desc"  rows="3" ng-model="movie.description"/>
				</div>

				<div class="form-group">
					<label for="movie-director"> <?php echo Lang::get('admin.media.movie.table.director'); ?></label>
					<input type="input" id="movie-director" class="form-control" ng-model="movie.director">
				</div>

				<div class="form-group">
					<label for="movie-actor"> <?php echo Lang::get('admin.media.movie.table.actor'); ?></label>
					<input type="input" id="movie-actor" class="form-control" ng-model="movie.actor">
				</div>

				<div class="form-group">
					<label for="movie-genre"> <?php echo Lang::get('admin.media.movie.table.genre'); ?></label>
					<input type="input" id="movie-genre" class="form-control" ng-model="movie.genre">
				</div>

				<a ng-click="saveMovie(movie);" class="btn btn-primary"><?php echo Lang::get('admin.buttons.save'); ?> </a>
			</form>
		</div>
	</div>
</div>