<div class="modal-header">
	<h2 class="modal-title">Edit Show</h2>
</div>
<div class="modal-body">
	<form class="row">
		<div class="col-md-8">
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-control" id="name" placeholder="Enter TV show name" ng-model="show.name">
			</div>
			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" class="form-control" id="description" cols="30" rows="5" placeholder="Enter a description" ng-model="show.description"></textarea>
			</div>
			<div class="form-group">
				<label for="directors">Directors</label>
				<input type="text" name="directors" class="form-control" id="directors" placeholder="Enter director names separated by commas (eg. 'Samuel Jackson, Steve Nolan')" ng-model="show.director">
			</div>
			<div class="form-group">
				<label for="actors">Actors</label>
				<input type="text" name="actors" class="form-control" id="actors" placeholder="Enter actor names separated by commas" ng-model="show.actor">
			</div>
			<div class="form-group">
				<label for="genres">Genres</label>
				<input type="text" name="genres" class="form-control" id="genres" placeholder="Enter genres separated by commas" ng-model="show.genre">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="cover">Cover</label>
				<img class="thumbnail cover" src="{{ show.image_path }}">
				<input type="file" id="cover">
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button class="btn btn-primary" ng-click="saveShow()">Save</button>
	<button class="btn btn-default" ng-click="cancelEdit()">Cancel</button>
</div>
