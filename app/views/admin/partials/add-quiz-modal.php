<div class="modal-header">
	<h2 class="modal-title"><?php echo Lang::get('admin.quiz.insert.heading'); ?> '{{ video.name }}'</h2>
</div>

<div class="modal-body">
	<form id="add-quiz-form">
	
		<div class="form-group">
			<label for="question"> <?php echo Lang::get('admin.quiz.insert.question_label'); ?></label>
			<input type="input" id="question" class="form-control" ng-model="question.question"  placeholder="<?php echo Lang::get('admin.quiz.insert.question_placeholder'); ?>">
		</div>
		
		<div class="form-group">
			<label for="answer"> <?php echo Lang::get('admin.quiz.insert.correct_answer_label'); ?></label>
			<input type="input" id="answer[]" class="form-control" ng-model="question.answer[0]"  placeholder="<?php echo Lang::get('admin.quiz.insert.answer_placeholder'); ?>">
		</div>
		
		<div class="form-group">
			<label for="answer"> <?php echo Lang::get('admin.quiz.insert.other_answers_label'); ?></label>
			<div class="form-group">
				<input type="input" id="answer[]" class="form-control" ng-model="question.answer[1]"  placeholder="<?php echo Lang::get('admin.quiz.insert.answer_placeholder'); ?>">
			</div>
			<div class="form-group">
				<input type="input" id="answer[]" class="form-control" ng-model="question.answer[2]"  placeholder="<?php echo Lang::get('admin.quiz.insert.answer_placeholder'); ?>">
			</div>
			<div class="form-group">
				<input type="input" id="answer[]" class="form-control" ng-model="question.answer[3]"  placeholder="<?php echo Lang::get('admin.quiz.insert.answer_placeholder'); ?>">
			</div>
		</div>
		
	</form>
</div>

<div class="modal-footer">
	<div class="pull-right button-group">
		<a ng-click="storeQuestion();" class="btn btn-primary" style="margin:2px"><?php echo Lang::get('admin.buttons.save'); ?> </a>
		<a ng-click="closeModel();" class="btn btn-primary" style="margin:2px"><?php echo Lang::get('admin.buttons.cancel'); ?> </a>
	</div>
</div>