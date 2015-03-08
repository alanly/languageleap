<h1>Manage Movies</h1>

<table class="table table-hover movies" ng-if="movies.length !== 0">
	<thead>
		<tr>
			<th>ID</th>
			<th>Action</th>
			<th>Name</th>
			<th>Publish</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="movie in movies">
			<td class="id">{{ movie.id }}</td>
			<td><a href="#"><i class="fa fa-edit fa-fw"></i></a><a ng-click="remove(movie);"><i class="fa fa-trash fa-fw"></i></a></td>
			<td>{{ movie.name }}</td>
			<td><input class="publish" type="checkbox" ng-model="movie.is_published" ng-click="onPublishClick($event, movie);" ng-checked="movie.is_published" /></td>
		</tr>
	</tbody>
</table>

<div ng-if="movies.length === 0">
	There doesn't seem to be anything here.
</div>