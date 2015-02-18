<?php

use LangLeap\Questions\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Words\Definition;
class QuestionTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$question = App::make('LangLeap\Questions\Question');
		$dq = App::make('LangLeap\Questions\DefinitionQuestion');
		$cq = App::make('LangLeap\Questions\CustomQuestion');
		$ddq = App::make('LangLeap\Questions\DragAndDropQuestion');
		
		$dq->question = "What is the definition of hello?";
		$dq->definition_id = 1;
		$dq->save();
		$question->create(["question_type" => "LangLeap\Questions\DefinitionQuestion", "question_id" => $dq->id, "answer_id" => 1]);

		$cq->question = "What is the movie about?";
		$cq->save();
		$question->create(["question_type" => "LangLeap\Questions\CustomQuestion", "question_id" => $cq->id, "answer_id" => 2]);

		$ddq->sentence = "The **BLANK** is scared of water.";
		$ddq->save();
		$question->create(["question_type" => "LangLeap\Questions\DragAndDropQuestion", "question_id" => $ddq->id, "answer_id" => 3]);
	}
	
}
