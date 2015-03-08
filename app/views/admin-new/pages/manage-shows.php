<h1>Manage TV Shows</h1>

<table class="table table-hover shows">
	<thead>
		<tr>
			<th>ID</th>
			<th>Action</th>
			<th>Name</th>
			<th>Publish</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="show in shows">
			<td class="id">{{ show.id }}</td>
			<td><a href="#"><i class="fa fa-edit fa-fw"></i></a><a href="javascript:;" ng-confirm-message="<?php echo Lang::get('admin.delete.confirm'); ?>" ng-confirm-click="onDeleteShowClick($event, show)"><i class="fa fa-trash fa-fw"></i></a></td>
			<td>{{ show.name }}</td>
			<td><input class="publish" type="checkbox" ng-model="show.is_published" ng-checked="show.is_published" ng-click="onPublishClick($event, show)"></td>
		</tr>
	</tbody>
</table>