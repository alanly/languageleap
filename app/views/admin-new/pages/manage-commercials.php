<h1>Manage Commercials</h1>
<a ng-click="openAddModal();" class="btn btn-primary pull-right">+</a>
<table class="table table-hover commercials" ng-if="commercials.length !== 0">
	<thead>
		<tr>
			<th>ID</th>
			<th>Action</th>
			<th>Name</th>
			<th>Publish</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="commercial in commercials">
			<td class="id">{{ commercial.id }}</td>
			<td><a ng-click="openEditModal(commercial);"><i class="fa fa-edit fa-fw"></i></a><a ng-click="remove(commercial);"><i class="fa fa-trash fa-fw"></i></a></td>
			<td>{{ commercial.name }}</td>
			<td><input class="publish" type="checkbox" ng-model="commercial.is_published" ng-click="onPublishClick($event, commercial);" ng-checked="commercial.is_published" /></td>
		</tr>
	</tbody>
</table>

<div ng-if="commercials.length === 0">
	There doesn't seem to be anything here.
</div>