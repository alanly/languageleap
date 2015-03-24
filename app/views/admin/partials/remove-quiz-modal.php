<div class="modal-header">
	<h1>{{ video.name }}</h1>
	<h3><?php echo Lang::get('admin.quiz.remove.heading'); ?></h3>
</div>

<div class="modal-body">
	<table class="table table-hover videos" ng-if="questions.length !== 0">
		<thead>
			<tr>
				<th><?php echo Lang::get('admin.quiz.manage.id') ?></th>
				<th><?php echo Lang::get('admin.quiz.manage.action') ?></th>
				<th><?php echo Lang::get('admin.quiz.manage.question') ?></th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="question in questions" ng-if="question !== null">
				<td class="id">{{ question.id }}</td>
				<td>
					<a ng-click="remove(question);"><i class="fa fa-trash fa-fw"></i></a>
				</td>
				<td>{{ question.question }}</td>
			</tr>
		</tbody>
	</table>

	<div ng-if="questions.length === 0">
		<?php echo Lang::get('admin.terms.empty'); ?>
	</div>
	
</div>

<div class="modal-footer">
	<div class="pull-right button-group">
		<a ng-click="closeModel();" class="btn btn-primary" style="margin:2px"><?php echo Lang::get('admin.buttons.exit'); ?> </a>
	</div>
</div>