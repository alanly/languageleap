<?php namespace LangLeap\QuizUtilities;

use LangLeap\Accounts\User;
use LangLeap\Core\UserInputResponse;
use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Words\WordBank;

/**
 * Encapsulate the behavior of response for answering questions in a quiz
 *
 * @author Quang Tran <tran.quang@live.com>
 */
class QuizAnswerUpdate implements UserInputResponse {

	/**
	 * Return an array with the parameters for BaseController::apiResponse in the same order
	 *
	 * @param  User  $user
	 * @param  array $input
	 * @return array
	 */
	public function response(User $user, array $input)
	{
		$quiz = Quiz::find($input['quiz_id']);
		$selectedId = $input['selected_id'];
		$videoquestion = VideoQuestion::find($input['videoquestion_id']);
		
		// Check if the answer is correct
		$isCorrectAnswer = $videoquestion->question->answer_id.'' === $selectedId;
		
		if(!$isCorrectAnswer && $videoquestion->question->questionType->isBankable()) // Store for user to review
		{
			$word = WordBank::where('user_id', '=', $user->id)
							->where('word', '=', $videoquestion->question->questionType->word)
							->where('media_id', '=', $videoquestion->video->viewable_id)
							->where('media_type', '=', $videoquestion->video->viewable_type)->first();
							
			if(!$word) // Create a wordbank item if there is none
			{
				WordBank::create([
					'user_id' => $user->id,
					'media_id' => $videoquestion->video->viewable_id,
					'media_type' => $videoquestion->video->viewable_type,
					'word' => $videoquestion->question->questionType->word
				]);
			}
		}
		
		// Update the correctness of the quiz
		$videoquestion->quiz()->updateExistingPivot(
			$quiz->id,
			['is_correct' => $isCorrectAnswer, 'attempted' => true]
		);
		
		// Update the quiz score
		$correctAnswers = $quiz->videoQuestions->filter(function($vq)
		{
			return $vq->pivot->is_correct;
		});
		$score = ($correctAnswers->count() * 100) / $quiz->videoQuestions->count();
		$quiz->score = $score;
		$quiz->category->attempted = true;
		$quiz->save();
		
		return [
			'success',
			['is_correct'	=> $isCorrectAnswer],
			200
		];
	}

}
