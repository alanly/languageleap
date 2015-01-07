<?php namespace LangLeap\QuizUtilities;

use LangLeap\Core\UserInputResponse;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Quizzes\Quiz;


/**
 * Encapsulate the behavior of response for answering questions in a quiz
 *
 * @author Quang Tran <tran.quang@live.com>
 */
 
 class QuizAnswerUpdate implements UserInputResponse
 {
	public function response($user_id, $input)
	{
		$quiz = Quiz::find($input['quiz_id']);
		$selectedId = $input['selected_id'];
		$videoquestion = VideoQuestion::find($input['videoquestion_id']);
		
		// Check if the answer is correct
		$isCorrectAnswer = $videoquestion->question->answer_id.'' === $selectedId;
		
		 // Update the correctness of the quiz
		$videoquestion->quiz()->updateExistingPivot($quiz->id, ['is_correct' => $isCorrectAnswer]);
		
		// Update the quiz score
		$correctAnswers = $quiz->videoQuestions->filter(function($vq) {
			return $vq->pivot->is_correct;
		});
		$score = ($correctAnswers->count() * 100)/$quiz->videoQuestions->count();
		$quiz->score = $score;
		$quiz->save();
		
		return [
			'success',
			[
				'is_correct'	=> $isCorrectAnswer,
			],
			200
		];
	}
 }