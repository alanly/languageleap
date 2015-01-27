<?php namespace LangLeap\Videos\RecommendationSystem\ClassificationDrivers;

use App;
use LangLeap\Videos\RecommendationSystem\Classifiable;
use LangLeap\Videos\RecommendationSystem\Historable;
use LangLeap\Videos\RecommendationSystem\ClassificationEngines\SimilarityClassificationEngine;

/**
 * The SimilartyClassificationDriver is an intermediary driver for the
 * SimilarityClassificationEngine.
 * @author Alan Ly <hello@alan.ly>
 */
class SimilarityClassificationDriver implements ClassificationDriver {

	protected $engine;


	public function __construct(SimilarityClassificationEngine $engine)
	{
		$this->engine = $engine;
	}


	/**
	 * Classifies the classifiable subject against the historable user's profile.
	 * @param  Historable   $historable   The historable user that serves as the reference
	 * @param  Classifiable $classifiable The media subject that is classifiable
	 * @return float                      The rating of the classifiable subject
	 */
	public function classify(Historable $historable, Classifiable $classifiable)
	{
		// Create the modeller instances for each parameter.
		$userModeller = App::make('LangLeap\Videos\RecommendationSystem\Modellers\UserModeller', [$historable]);
		$mediaModeller = App::make('LangLeap\Videos\RecommendationSystem\Modellers\MediaModeller', [$classifiable]);

		// Retrieve the respective models.
		$userModel = $userModeller->model();
		$mediaModel = $mediaModeller->model();

		/**
		 * The $userModel will act as the reference model to compare against.
		 * The $mediaModel will act as the subject of our comparison.
		 */

		return $this->engine->classify($userModel, $mediaModel);
	}
	
}
