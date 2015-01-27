<?php namespace LangLeap\Videos\RecommendationSystem\ClassificationEngines;

/**
 * Defines the interface for a classifier engine.
 * @author Alan Ly <hello@alan.ly>
 */
interface ClassificationEngine {

	/**
	 * Determines the probability that the classifiable instance will meet the
	 * expectations outlined by the reference model.
	 * @return float The likelihood that we will meet expectations
	 */
	public function classify();

}
