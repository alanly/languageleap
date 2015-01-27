<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\Videos\Media;

/**
 * ScoredMedia is a basic structure that contains a media instance and its
 * associated score.
 * @author Alan Ly <hello@alan.ly>
 */
class ScoredMedia {

	private $media;
	private $score;


	public function __construct(Media $media, $score)
	{
		$this->media = $media;
		$this->score = $score;
	}


	public function getMedia()
	{
		return $this->media;
	}


	public function getScore()
	{
		return $this->score;
	}

}
