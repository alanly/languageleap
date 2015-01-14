<?php 

use LangLeap\TestCase;

/**
*		@author Dror Ozgaon <Dror.Ozgaon@gmail.com>
*/
class ApiCutVideoTest extends TestCase {

	public function testCutVideoEqually()
	{
		$commercial = $this->getCommercialInstance();
		$video = $this->getVideoInstance();

		$response = $this->action('GET', 'ApiCutVideoController@cutIntoSegments', [], [	"video_id" => $video->id, 
																						"mediaType" => "Commercial", 
																						"media_id" => $commercial->id,
																						"segments" => 5
																					]);

	}
	
	protected function getVideoInstance()
	{
		$video = App::make('LangLeap\Videos\Video');
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
		$video->language_id = 1;
		$video->path = 'storage\media\videos\commercials\test.mp4';
		$video->save();

		return $video;
	}	

	protected function getCommercialInstance()
	{
		$commercial = App::make('LangLeap\Videos\Commercial');
		$commercial->name = 'TedTalks';
		$commercial->description ='Vacation';
		$commercial->level_id = 1;
		$commercial->save();
		
		return $commercial;
	}
}
