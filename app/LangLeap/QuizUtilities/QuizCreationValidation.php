<?php namespace LangLeap\QuizUtilities;

use LangLeap\Accounts\User;
use LangLeap\Core\Collection;
use LangLeap\Core\InputDecorator;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;

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
			return ['error', 'Must be logged in to create a quiz.', 401];
		}
	
		// Ensure the video exists.
		$videoId = $input["video_id"];

		if (! Video::find($videoId))
		{
			return ['error', "Video {$videoId} does not exists", 404];
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
			if(strlen($word) < 1) return ['error', "The selected word was not found.", 404];

			$sentence = $selectedWord['sentence'];
			if(strlen($sentence) < 1) return ['error', "The selected word was not associated to a sentence.", 400];

			if(stripos($sentence, $word) === FALSE)
			{
				return ['error', "The selected word was not found in the provided sentence.", 400];
			}
		}
		
		return parent::response($user, $input);
	}

}
