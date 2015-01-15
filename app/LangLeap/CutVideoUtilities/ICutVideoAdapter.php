<?php namespace LangLeap\CutVideoUtilities;


/**
 * Define the interface for CutVideo adapter in order to decouple 
 * the project from external video libraries.
 *
 * @author Quang Tran <tran.quang@live.com>
 */
interface ICutVideoAdapter {
	
	/**
	 * Cut a video into equal segments
	 * 
	 * @param $video The video that will be cut
	 * @param $segments The number of segments to cut the video into
	 * @return array of newly made videos
	 */
	public function cutVideoIntoSegments(Video $video, int $segments);
	
	/**
	 * Create new video clips by cutting videos from specific times for specific lengths
	 *
	 * @param $video The base video
	 * @param $times An array of associative arrays where the associative arrays contain 'time' and 'duration'
	 * @return array of newly made videos
	 */
	public function cutVideoByTimes(Video $video, array $times);
}