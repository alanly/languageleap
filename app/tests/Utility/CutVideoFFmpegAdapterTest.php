<?php 

use LangLeap\TestCase;
use LangLeap\CutVideoUtilities\CutVideoFFmpegAdapter;

/**
 *	@author Quang Tran <tran.quang@live.com>
 */
class CutVideoFFmpegAdapterTest extends TestCase {
	
	public function testCutVideoByTimes()
	{
		Queue::shouldReceive('connected')->once()->andReturn(true);
		Queue::shouldReceive('push')->once();
		
		$video = $this->getVideoInstance();
		$cutAdapter = new CutVideoFFmpegAdapter();
		
		$segments = [['time' => 0, 'duration' => 5], ['time' => 5, 'duration' => 10]];
		
		$videos = $cutAdapter->cutVideoByTimes($video, $segments);
		
		$this->assertCount(count($segments), $videos);
		$this->assertContainsOnlyInstancesOf('LangLeap\Videos\Video', $videos);
	}
	
	protected function getVideoInstance()
	{
		$video = App::make('LangLeap\Videos\Video');
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
		$video->language_id = 1;
		$video->path = 'storage' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . 'commercials' . DIRECTORY_SEPARATOR . 'test.mp4';
		$video->save();
		
		$script = App::make('LangLeap\Words\Script');
		$script->text = 'test script';
		$script->video_id = $video->id;
		$script->save();
		
		return $video;
	}
}
