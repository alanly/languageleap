<?php namespace LangLeap\VideoCutterUtilities;

use LangLeap\Core\Collection;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
interface IVideoCutter 
{
	public function cutVideoIntoSegmets($numberOfSegments);
	public function cutVideoAtLocation($cutOffTimes)
}

