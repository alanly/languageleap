<h1>Manage Users</h1>

<table class="table table-hover users" ng-if="users.length !== 0">
	<thead ng-init="orderByReverse = false; orderByPredicate = 'username';">
		<tr>
			<th class="col-md-1">ID</th>
			<th class="col-md-2">Actions</th>
			<th class="col-md-3"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'username'">UserName<i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'username'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
			<th class="col-md-5"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'email'">Email<i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'email'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
			<th class="col-md-1"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'is_active'">Active<i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'is_active'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="user in users | orderBy:orderByPredicate:orderByReverse">
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