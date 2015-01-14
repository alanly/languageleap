<?php namespace LangLeap\VideoCutterUtilities;

use LangLeap\Core\Collection;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class VideoCutterFactory
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

