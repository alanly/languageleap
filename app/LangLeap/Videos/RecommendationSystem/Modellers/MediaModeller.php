<?php namespace LangLeap\Videos\RecommendationSystem;

use App;
use LangLeap\Videos\RecommendationSystem\Facades\ModellerUtilities;


/**
 * MediaModeller builds attribute models for a classifiable media.
 * @author Alan Ly <hello@alan.ly>
 */
class MediaModeller implements Modeller {

	/**
	 * Instance of the classifiable media we'll be modelling.
	 * @var Classifiable
	 */
	private $classifiable;


	/**
	 * Constructs a new instance.
	 * @param Classifiable $classifiable The classifiable instance
	 */
	public function __construct(Classifiable $classifiable)
	{
		$this->classifiable = $classifiable;
	}


	/**
	 * Creates a new modeller for a given classifiable instance.
	 * @param  Classifiable $classifiable The classifiable instance
	 * @return MediaModeller              A new modeller
	 */
	public static function create(Classifiable $classifiable)
	{
		return new static($classifiable);
	}


	/**
	 * Generate the model.
	 * @return Model The attribute model
	 */
	public function model()
	{
		// Get the classification attributes from the media.
		$attributes = ModellerUtilities::getClassificationAttributesFromMedia($this->classifiable);

		// Create a model instance.
		$model = App::make('LangLeap\Videos\RecommendationSystem\Model');

		// Populate the model.
		ModellerUtilities::populateModelFromAttributes($model, $attributes);

		return $model;
	}
	
}
