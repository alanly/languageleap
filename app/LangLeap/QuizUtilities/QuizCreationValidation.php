<?php namespace LangLeap\QuizUtilities;

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
	
	public function response($user, $input)
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

		// Get all the words in the script; if empty, return 400 (client-side error).
		$scriptWords = $input["all_words"];
		
		if (! $scriptWords || count($scriptWords) < 1)
		{
			return [
				'error',
				"Empty script supplied for video {$videoId}.",
				400
			];
		}

		// Retrieve a collection of all definitions in the script.
		$scriptDefinitions = Definition::whereIn('id', $scriptWords)->get();

		// Use the overriden Collection class.
		$scriptDefinitions = new Collection($scriptDefinitions->all());

		// If words are missing, then return a 404.
		if ($scriptDefinitions->count() != count($scriptWords))
		{
			return [
				'error',
				'Only '.$scriptDefinitions->count().' definitions found for '.count($scriptWords).' words.',
				404
			];
		}

		// Ensure that the _selected_ words are within the realm of the script.
		foreach ($selectedWords as $definitionId)
		{
			// If a selected word is not in the script, return 404.
			if (! $scriptDefinitions->contains($definitionId))
			{
				return [
					'error',
					"Selected definition {$definitionId} is not in video {$videoId}.",
					404
				];
			}
		}
		
		return parent::response($user, $input);
	}
}