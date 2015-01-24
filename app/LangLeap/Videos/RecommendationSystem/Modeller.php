<?php namespace LangLeap\Videos\RecommendationSystem;

use LangLeap\Core\Collection;
use LangLeap\Videos\RecommendationSystem\Facades\ClassifierUtilities;
use App;

/**
 * Modeller builds the preference models for a user based on their viewing
 * history and explicit preferences (if available).
 * @author Alan Ly <hello@alan.ly>
 */
class Modeller {

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
	 * @return Model The user preference model
	 */
	public function model()
	{
		// Get the viewing history collection from the modelable instance.
		$history = $this->modelable->getViewingHistory();

		// Parse through the history and grab all classifiable media.
		$media = ClassifierUtilities::getClassifiableMediaFromHistory($history);

		// Get a Model instance.
		$model = App::make('LangLeap\Videos\RecommendationSystem\Model');

		// @TODO Get the classification data and generate the model.

		return $model;
	}
	
}
