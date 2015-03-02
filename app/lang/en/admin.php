<?php

return array(
	
	/*
	|------------------------------------------------------------------
	| Admin Language Lines.
	|------------------------------------------------------------------
	|
	| The following language lines will be used for the english 
	| version of the admin page.
	|
	*/

	/**
	 * Generic Button Text
	 */
	'buttons' => array(
		'save'   => 'Save',
		'remove' => 'Remove',
		'cancel' => 'Cancel',
		'add'    => 'Add',
	),

	/**
	 * Generic Terminologies
	 */
	'terms' => array(
		'actors'         => 'Actor|Actors',
		'definitions'    => 'Definition|Definitions',
		'full_defin'     => 'Full Definition|Full Definitions',
		'none'           => 'None',
		'pronunciations' => 'Pronunciation|Pronunciations',
		'timestamps'     => 'Timestamp|Timestamps',
		'words'          => 'Word|Words',
	),

	'media' => array(
		'movie' => array(
			'name' => 'Movies',
			'table' => array(
				'id'          => 'Id',
				'name'        => 'Name',
				'description' => 'Description',
				'manage'      => 'Manage'
			),
		),
		'commercial' => array(
			'name' => 'Commercials',
			'table' => array(
			),
		),
		'show' => array(
			'name' => 'TV Shows',
			'table' => array(
			),
		),
		'add' => 'Add Media',
	),

	'script' => array(
		'upload'       => 'Script Upload',
		'save_success' => 'Script saved successfully',
	),

	'upload' => array(
		'uploading' => 'Uploading Media, Please Wait...',
		'success'   => 'Media Uploaded Successfully',
	),

	'quiz' => array(
		'insert' => array(
			'heading'              => 'Insert Custom Quiz',
			'video_label'          => 'Video',
			'question_label'       => 'Question',
			'correct_answer_label' => 'Correct Answer',
			'other_answers_label'  => 'Other Answers',
			'save_button'          => 'Save',
			'save_success'         => 'Save Successful',
			'save_fail'            => 'Save Failed',
			'question_placeholder' => 'Insert question here',
			'answer_placeholder'   => 'Insert answer here',
		),
	),

	'modal' => array(

		/**
		 * The translations general to all modals.
		 */
		
		'id'          => 'ID:',
		'name'        => 'Name',
		'description' => 'Description',
		'level'       => 'Level',
		'language'    => 'Language',
		'director'    => 'Director',
		'actor'       => 'Actor',
		'genre'       => 'Genre',
		'file'        => 'File',

		/**
		 * The translations specific to each modal.
		 */
		
		'add_media' => array(
			'media_info' => 'Media Info',
			'media_type' => 'Media Type:',
		),

		'edit_media' => array(
			'save'       => 'Save',
			'season'     => 'Season|Seasons',
			'episode'    => 'Episode',
			'add'        => 'Add',
			'timestamps' => 'Timestamps',
			'info'       => 'Info',
			'script'     => 'Script',
			'media'      => 'Media',
		),

		'edit_script' => array(
			'title'         => 'Edit',
			'selected_text' => 'Selected Text:',
			'tag_text_as'   => 'Tag Selected Text As:',
			'timestamp'     => array(
				'title'       => 'Format as #:## (i.e. 2:46)',
				'placeholder' => 'Enter the clip time (i.e. 2:46)',
			),
			'def_placehold' => 'Enter a definition',
			'full_def'      => 'Full Definition (Optional)',
			'full_def_placehold' => 'Enter a full definition',
			'pronun'        => 'Pronunciation (Optional)',
			'pronun_placehold' => 'Enter the pronunciation',
		),

	),

);