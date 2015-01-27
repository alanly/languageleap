<?php namespace LangLeap\Videos\RecommendationSystem;

use App;
use LangLeap\Videos\RecommendationSystem\Facades\ModellerUtilities;

/**
 * UserModeller builds attribute preference models for a historable user.
 * @author Alan Ly <hello@alan.ly>
 */
class UserModeller implements Modeller {

	/**
	 * Instance of the historable user that we'll be modelling.
	 * @var Historable
	 */
	private $historable;


	/**
	 * Constructs a new instance.
	 * @param Historable $historable The historable instance
	 */
	public function __construct(Historable $historable)
	{
		$this->historable = $historable;
	}


	/**
	 * Creates a new modeller for a given historable instance.
	 * @param  Historable $historable The historable instance
	 * @return UserModeller           A new modeller
	 */
	public static function create(Historable $historable)
	{
		return new static($historable);
	}


	/**
	 * Generate the model.
	 * @return Model The attribute model
	 */
	public function model()
	{
		// Get the viewing history collection from the historable instance.
		$history = $this->historable->getViewingHistory();

		// Parse through the history and get a collection of classifiable media.
		$media = ModellerUtilities::getClassifiableMediaFromHistory($history);

		// Get the classification data from the media and generate the model.
		$attributes = ModellerUtilities::getClassificationAttributesFromMedia($media);

		// Get a Model instance.
		$model = App::make('LangLeap\Videos\RecommendationSystem\Model');

		// Populate the model.
		ModellerUtilities::populateModelFromAttributes($model, $attributes);

		return $model;
	}

}
