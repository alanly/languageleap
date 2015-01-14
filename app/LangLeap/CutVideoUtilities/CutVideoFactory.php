<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\Collection;
use FFMpeg;
use FFProbe;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideoFactory
{
	private static $instance;

	public static function getInstance()
	{
		if (!isset(static::$instance)) 
		{
			static::$instance = new static;
		}

		return static::$instance;
	}

	public function getFFmpeg($videoPath)
	{
		$ffmpeg = FFMpeg::create();
		return $ffmpeg->open("app\\" . $videoPath);
	}

	public function getFFprobe($videoPath)
	{
		$ffprobe = FFProbe::create();
		return $ffprobe->format("app\\" . $videoPath);
	}
}

