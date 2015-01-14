<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\Collection;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
interface ICutVideo 
{
	public function cutVideoIntoSegmets($numberOfSegments);
	public function cutVideoAtSpecifiedTimes($cutOffTimes);
}

