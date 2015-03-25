<h1><?php echo Lang::get('admin.quiz.manage.title'); ?></h1>

<table class="table table-hover videos" ng-if="videos.length !== 0">
	<thead ng-init="orderByReverse = false; orderByPredicate = 'name';">
		<tr>
			<th class="col-md-1"><?php echo Lang::get('admin.quiz.manage.id') ?></th>
			<th class="col-md-2"><?php echo Lang::get('admin.quiz.manage.action') ?></th>
			<th class="col-md-7"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'name'"><?php echo Lang::get('admin.quiz.manage.name') ?><i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'name'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
			<th class="col-md-2"><?php echo Lang::get('admin.quiz.manage.timestamp') ?></th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="video in videos | orderBy:orderByPredicate:orderByReverse" ng-if="video !== null">
			<td class="id">{{ video.id }}</td>
			<td>
				<a ng-click="openAddModal(video);"><i class="fa fa-plus fa-fw"></i></a>
				<a ng-click="openRemoveModal(video);"><i class="fa fa-minus fa-fw"></i></a>
			</td>
			<td>{{ video.name }}</td>
			<td>{{ }}</td>
		</tr>
	</tbody>
</table>

<div ng-if="videos.length === 0">
	<?php echo Lang::get('admin.terms.empty'); ?>
</div>