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
		'empty'			 => 'There doesn\'t seem to be anything here',
	),

	'media' => array(
		'movie' => array(
			'name' => 'Movies',
			'table' => array(
				'id'          => 'Id',
				'name'        => 'Name',
				'description' => 'Description',
				'actor'		  => 'Actor',
				'director' 	  => 'Director',
				'genre' 	  => 'Genre',
				'manage'      => 'Manage',
				'poster'	  => 'Poster',
			),
		),
		'commercial' => array(
			'name' => 'Commercials',
			'table' => array(
				'id'          => 'Id',
				'name'        => 'Name',
				'description' => 'Description',
				'manage'      => 'Manage',
				'poster'	  => 'Poster',
			),
		),
		'show' => array(
			'name' => 'TV Shows',
			'table' => array(
			),
		),
		'add' => 'Add Media',
	),

	'new_video' => array(
		'type' => array(
			'commercial' => 'Commercial',
			'movie' => 'Movie',
			'show' => 'Show',
		),
		'video' => 'Video',
		'script' => 'Script',
		'submit' => 'Submit',
	),

	'script' => array(
		'upload'       => 'Script Upload',
		'save_success' => 'Script saved successfully',
	),

	'upload' => array(
		'uploading'          => 'Uploading Media, Please Wait...',
		'success'            => 'Media Uploaded Successfully',
		'image_store_failed' => 'An error occured while storing the media image.',
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
	'index' => array(
		'menu' => array(
			'dashboard' => 'Dashboard',
			'logout' => 'Sign Out',
			'client' => 'Client Side',
			'videos' => 'Manage Videos',
			'scripts' => 'Manage Scripts',
			'users' => 'Manager Users',
		),
	),
	'delete' => array(
		'confirm' => 'Are you sure that you want to delete this?'
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
			'title' 	 => 'Edit Media',
		),
		'new_media' => array(
			'title'		=> 'New Media',
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