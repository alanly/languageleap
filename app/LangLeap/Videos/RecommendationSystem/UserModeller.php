<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\Core\Collection;
use LangLeap\Videos\RecommendationSystem\Facades\ModellerUtilities;
use App;

/**
 * UserModeller builds attribute preference models for a modelable user.
 * @author Alan Ly <hello@alan.ly>
 */
class UserModeller implements Modeller {

	/**
	 * @var Modelable
	 */
	private $modelable;


	/**
	 * Constructs a new instance.
	 * @param Modelable $modelable The modelable instance
	 */
	public function __construct(Modelable $modelable)
	{
		$this->modelable = $modelable;
	}


	/**
	 * Creates a new modeller for a given modelable instance.
	 * @param  Modelable $modelable The modelable instance
	 * @return Modeller             A new modeller
	 */
	public static function create(Modelable $modelable)
	{
		return new static($modelable);
	}


	/**
	 * Generate the model.
	 * @return Model The attribute model
	 */
	public function model()
	{
		// Get the viewing history collection from the modelable instance.
		$history = $this->modelable->getViewingHistory();

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
