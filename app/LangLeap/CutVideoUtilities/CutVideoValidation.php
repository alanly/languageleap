<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\InputDecorator;
use LangLeap\Accounts\User;
use LangLeap\Videos\Video;
use Lang;
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
			return ['error', Lang::get('videoutilities.validation.admin'),	401];
		}
		
		if(!isset($input['video_id']))
		{
			return ['error', Lang::get('videoutilities.validation.no_video'),	400];
		}

		$video = Video::find($input['video_id']);
		if(!$video)
		{
			return ['error', Lang::get('videoutilities.validation.video_missing', ['video_id', $input['video_id']]), 404];
		}

		if(!isset($input['segments']))
		{
			return ['error', Lang::get('videoutilities.validation.segments_missing'), 400];
		}
		
		$segments = $input['segments'];
		if(is_array($segments))
		{
			if(count($segments) < 1)
			{
				return ['error', Lang::get('videoutilities.validation.atleast_one_segment'), 400];
			}
			foreach($segments as $times)
			{
				if(!isset($times['time']) || !isset($times['duration']))
				{
					return ['error', Lang::get('videoutilities.validation.time_duration'), 400];
				}
			}
		}
		else
		{
			return ['error', Lang::get('videoutilities.validation.invalid_type'), 400];
		}
		
		return parent::response($user, $input);
	}
}