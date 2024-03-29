<?php namespace LangLeap\QuizUtilities;

use Lang;
use LangLeap\Accounts\User;
use LangLeap\Core\Collection;
use LangLeap\Core\InputDecorator;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;
use LangLeap\WordUtilities\WordInformation;

/**
 * Concrete decorator that adds validation behavior to Quiz creation
 *
 * @author Quang Tran <tran.quang@live.com>
 */
class QuizCreationValidation extends InputDecorator {
	
	/**
	 * Return an array with the parameters for BaseController::apiResponse in the same order
	 *
	 * @param  User  $user
	 * @param  array $input
	 * @return array
	 */
	public function response(User $user, array $input)
	{
		if (! $user)
		{
			return ['error', Lang::get('controllers.quiz.create_no-auth'), 401];
		}
	
		// Ensure the video exists.
		$videoId = $input["video_id"];

		if (! Video::find($videoId))
		{
			return ['error', Lang::get('controllers.videos.error', ['id' => $videoId]), 404];
		}

		// Get all the selected words; if empty, return with redirect.
		$selectedWords = $input["selected_words"];
		if (! $selectedWords || count($selectedWords) < 1)
		{
			return [
				'success',
				[ 'result' => ['redirect' => 'http://www.google.ca/'] ],
				200
			];
		}

		foreach($selectedWords as $selectedWord)
		{
			$word = $selectedWord['word'];
			if(strlen($word) < 1) return ['error', Lang::get('controllers.quiz.selected_error'), 404];

			$sentence = $selectedWord['sentence'];
			if(strlen($sentence) < 1) return ['error', Lang::get('controllers.quiz.sentence_error'), 400];

			if(stripos($sentence, $word) === FALSE)
			{
				return ['error', Lang::get('controllers.quiz.sentence_error'), 400];
			}
		}
		
		$wordInformations = WordInformation::fromInput($selectedWords, $videoId);
		if(count($wordInformations) < 1)
		{
			return ['error', Lang::get('controllers.quiz.no_def'), 404];
		}
		
		return parent::response($user, $input);
	}

}
