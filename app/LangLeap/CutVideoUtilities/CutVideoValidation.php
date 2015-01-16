<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\InputDecorator;
use LangLeap\Accounts\User;
use LangLeap\Videos\Video;

/**
 * Validation decorator for the CutVideoResponse.
 * Makes sure that the user is an admin and the inputs are properly formed.
 *
 * @author Quang Tran <tran.quang@live.com>
 */
class CutVideoValidation extends InputDecorator {

	public function response(User $user, array $input)
	{
		if(!$user || !$user->is_admin)
		{
			return ['error', 'Must be an administrator to edit videos',	401];
		}
		
		if(!isset($input['video_id']))
		{
			return ['error', "Video id is missing.",	400];
		}

		$video = Video::find($input['video_id']);
		if(!$video)
		{
			return ['error',	"Video " . $input['video_id'] . " is missing.", 404];
		}

		if(!isset($input['segments']))
		{
			return ['error',	"Cut into segments value is missing.", 400];
		}
		
		$segments = $input['segments'];
		if(is_array($segments))
		{
			if(count($segments) < 1)
			{
				return ['error', 'Segments must contain at least one entry', 400];
			}
			foreach($segments as $times)
			{
				if(!isset($times['time']) || !isset($times['duration']))
				{
					return ['error', 'Segment entries must contain time and duration', 400];
				}
			}
		}
		else
		{
			return ['error', 'Segments value is not the correct type', 400];
		}
		
		return parent::response($user, $input);
	}
}