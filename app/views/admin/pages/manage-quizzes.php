<h1><?php echo Lang::get('admin.quiz.manage.title'); ?></h1>

<table class="table table-hover videos" ng-if="videos.length !== 0">
	<thead>
		<tr>
			<th><?php echo Lang::get('admin.quiz.manage.id') ?></th>
			<th><?php echo Lang::get('admin.quiz.manage.action') ?></th>
			<th><?php echo Lang::get('admin.quiz.manage.name') ?></th>
			<th><?php echo Lang::get('admin.quiz.manage.timestamp') ?></th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="video in videos" ng-if="video !== null">
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