<?php

return array(
	
	/*
	|------------------------------------------------------------------
	| Controller Language Lines.
	|------------------------------------------------------------------
	|
	| The following language lines will be used for the english 
	| version for controllers.
	|
	*/

	'definition' => array(
		'error' => 'Definition :id not found.',
	),
	'dictionary' => array(
		'word_error' => 'Word :word does not exist.',
		'video_error' => 'Video :videoId does not exist.',
		'lang_error' => 'Language for :videoId not found.',
		'dictionary_error' => ':videoLang dictionary not found.',
		'definition_error' => 'Definition not found.',
	),
	'episodes' => array(
		'show_error' => 'Show :showId could not be found.',
		'season_error' => 'Season :seasonId not found for show :showId.',
		'show-season_error' => 'Season :seasonId of show :showId could not be found.',
		'episode_error' => 'Episode :episodeId of season :seasonId for show :showId could not be found.',
		'episode-deletion_error' => 'Episode :episodeId of season :seasonId for show :showId could not be deleted.',
		'season-deletion_error' => 'Unable to delete season :seasonId for show :showId.'
	),
	'commercial' => array(
		'error' => 'Commercial :id not found.',
		'removed' => 'Commercial :id has been removed.',
	),
	'movies' => array(
		'movie_error' => 'Movie :id not found.',
		'movie_deletion' => 'Movie :id has been removed.',
	),
	'quiz' => array(
		'saved' => 'Custom question saved successfully',
		'database_error' => 'Video not found in database.',
		'blank-fields_error' => 'Fields not filled in properly.',
		'quiz_error' => 'Quiz :quiz_id not found.',
		'quiz_no-auth' => 'Not authorized to view quiz :quiz_id.',
	),
	'recommended' => array(
		'not-logged_error' => 'User not logged in.',
	),
	'scripts' => array(
		'script_error' => 'Script :id not found.',
		'script_deletion' => 'Script :id has been removed.',
	),
	'shows' => array(
		'error' => 'Show :id not found.',
		'deletion' => 'Show :id has been removed.',
	),
);