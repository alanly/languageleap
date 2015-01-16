<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Videos\Video;

/**
 * Define the interface for CutVideo adapter in order to decouple 
 * the project from external video libraries.
 *
 * @author Quang Tran 	<tran.quang@live.com>
 */
interface ICutVideoAdapter {
	
	/**
	 * Create new video clips by cutting videos from specific times for specific lengths
	 *
	 * @param $video The base video
	 * @param $times An array of associative arrays where the associative arrays contain 'time' and 'duration'
	 * @return array of newly made videos
	 */
	public function cutVideoByTimes(Video $video, array $times);
}