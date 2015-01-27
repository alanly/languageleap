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

	private $cacheHistorable = true;
	private $engine;
	private $historable;
	private $historableModelCache;


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
		// Get the user model.
		$userModel = $this->modelHistorable($historable);

		// Get the media model.
		$mediaModel = $this->modelClassifiable($classifiable);

		/**
		 * The $userModel will act as the reference model to compare against.
		 * The $mediaModel will act as the subject of our comparison.
		 */

		return $this->engine->classify($userModel, $mediaModel);
	}


	/**
	 * Gets the user model.
	 * @param  Historable $historable The historable instance to generate the model for
	 * @return LangLeap\Videos\RecommendationSystem\Model
	 */
	private function modelHistorable(Historable $historable)
	{
		// If this is the same historable instance and we have a cache of the model
		// then just return the cached model so that we don't have to regenerate it.
		
		if (($historable === $this->historable)
			&& isset($this->historableModelCache)
			&& $this->cacheHistorable)
		{
			return $this->historableModelCache;
		}

		// Create the modeller instance.
		$userModeller = App::make('LangLeap\Videos\RecommendationSystem\Modellers\UserModeller', [$historable]);

		// Model the historable instance.
		$userModel = $userModeller->model();

		// Cache the values
		if ($this->cacheHistorable)
		{
			$this->historable = $historable;
			$this->historableModelCache = $userModel;
		}

		return $userModel;
	}


	/**
	 * Gets the media model.
	 * @param  Classifiable $classifiable The classifiable instance to model
	 * @return LangLeap\Videos\RecommendationSystem\Model
	 */
	private function modelClassifiable(Classifiable $classifiable)
	{
		// Create the modeller.
		$mediaModeller = App::make('LangLeap\Videos\RecommendationSystem\Modellers\MediaModeller', [$classifiable]);

		// Model the instance.
		return $mediaModeller->model();
	}


	/**
	 * Enables the caching of the Historable model, so that we do not have to
	 * regenerate it on consecutive runs of the same Historable. If set to false,
	 * then the model will be created fresh on each run.
	 * @param  boolean $enable Enable caching of the historable model
	 */
	public function enableHistorableCaching($enable = true)
	{
		$this->cacheHistorable = $enable;

		// Clear out the cache if necessary
		if (! $enable)
		{
			$this->historable = null;
			$this->historableModelCache = null;
		}
	}
	
}
