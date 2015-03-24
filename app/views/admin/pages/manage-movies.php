<h1>Manage Movies</h1>
<a ng-click="openAddModal();" class="btn btn-primary pull-right">+</a>
<table class="table table-hover movies" ng-if="movies.length !== 0">
	<thead ng-init="orderByReverse = false; orderByPredicate = 'name';">
		<tr>
			<th class="col-md-1">ID</th>
			<th class="col-md-2">Action</th>
			<th class="col-md-8"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'name'">Name<i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'name'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
			<th class="col-md-1"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'is_published'">Publish<i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'is_published'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="movie in movies | orderBy:orderByPredicate:orderByReverse">
			<td class="id">{{ movie.id }}</td>
			<td>
				<a ng-click="openEditModal(movie);"><i class="fa fa-edit fa-fw"></i></a>
				<a ng-click="remove(movie);"><i class="fa fa-trash fa-fw"></i></a>
				<a ng-click="manageMedia(movie);"><i class="fa fa-film fa-fw"></i></a>
			</td>
			<td>{{ movie.name }}</td>
			<td><input class="publish" type="checkbox" ng-model="movie.is_published" ng-click="onPublishClick($event, movie);" ng-checked="movie.is_published" /></td>
		</tr>
	</tbody>
</table>

<div ng-if="movies.length === 0">
	<?php echo Lang::get('admin.terms.empty'); ?>
</div>

<div class="manage-media" ng-include="movie_media">

</div>