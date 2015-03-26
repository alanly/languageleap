<h1>Manage Commercials</h1>
<a ng-click="openAddModal();" class="btn btn-primary pull-right">+</a>
<table class="table table-hover commercials" ng-if="commercials.length !== 0">
	<thead ng-init="orderByReverse = false; orderByPredicate = 'name';">
		<tr>
			<th class="col-md-1">ID</th>
			<th class="col-md-2">Action</th>
			<th class="col-md-8"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'name'">Name<i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'name'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
			<th class="col-md-1"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'is_published'">Publish<i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'is_published'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="commercial in commercials | orderBy:orderByPredicate:orderByReverse">
			<td class="id">{{ commercial.id }}</td>
			<td>
				<a ng-click="openEditModal(commercial);"><i class="fa fa-edit fa-fw"></i></a>
				<a ng-confirm-message="<?= Lang::get('admin.delete.confirm') ?>" ng-confirm-click="remove(commercial);"><i class="fa fa-trash fa-fw"></i></a>
				<a ng-click="manageMedia(commercial);"><i class="fa fa-film fa-fw"></i></a>
			</td>
			<td>{{ commercial.name }}</td>
			<td><input class="publish" type="checkbox" ng-model="commercial.is_published" ng-click="onPublishClick($event, commercial);" ng-checked="commercial.is_published" /></td>
		</tr>
	</tbody>
</table>

<div ng-if="commercials.length === 0">
	<?php echo Lang::get('admin.terms.empty'); ?>
</div>
<div class="manage-media" ng-include="commercial_media">

</div>