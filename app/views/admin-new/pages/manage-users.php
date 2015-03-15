<h1>Manage Users</h1>

<table class="table table-hover users" ng-if="users.length !== 0">
	<thead>
		<tr>
			<th>ID</th>
			<th>Actions</th>
			<th>UserName</th>
			<th>Email</th>
			<th>Active</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="user in users">
			<td class="id">{{ user.id }}</td>
			<td><a ng-click="remove(user);"><i class="fa fa-trash fa-fw"></i></a></td>
			<td>{{ user.username }}</td>
			<td>{{ user.email }}</td>
			<td><input class="publish" type="checkbox" ng-model="user.is_active" ng-click="onActiveClick($event, user);" ng-checked="user.is_active" /></td>
		</tr>
	</tbody>
</table>

<div ng-if="users.length === 0">
	There doesn't seem to be anything here.
</div>