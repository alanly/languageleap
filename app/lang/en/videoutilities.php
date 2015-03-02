<?php

return array(
	'validation' => array(
		'admin' => 'Must be an administrator to edit videos',
		'no_video' => 'Video id is missing.',
		'video_missing' => '"Video :video_id is missing.',
		'segments_missing' => 'Cut into segments value is missing.',
		'atleast_one_segment' => 'Segments must contain at least one entry',
		'time_duration' => 'Segment entries must contain time and duration',
		'invalid_type' => 'Segments value is not the correct type',

	),
	'response' => array(
		'error' => 'The request to break the video at specified times could not be completed.',
	),

);