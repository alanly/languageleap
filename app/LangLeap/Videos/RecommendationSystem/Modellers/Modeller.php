<?php namespace LangLeap\Videos\RecommendationSystem;

/**
 * Modeller builds attribute preference models for objects.
 * @author Alan Ly <hello@alan.ly>
 */
interface Modeller {

	/**
	 * Generate the model.
	 * @return Model The attribute model
	 */
	public function model();
	
}
