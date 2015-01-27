<?php namespace LangLeap\Videos\RecommendationSystem\ClassificationEngines;

use LangLeap\Videos\RecommendationSystem\Model;

/**
 * Defines the interface for a classifier engine.
 * @author Alan Ly <hello@alan.ly>
 */
interface ClassificationEngine {

	/**
	 * Determines the probability that the classifiable instance will meet the
	 * expectations outlined by the reference model.
	 * @param Model $referenceModel The reference model to compare against
	 * @param Model $classifyModel  The model that we want to classify
	 * @return float The likelihood that we will meet expectations
	 */
	public function classify(Model $referenceModel, Model $classifyModel);

}
