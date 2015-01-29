<?php namespace LangLeap\Videos\RecommendationSystem\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ClassificationDriverServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'LangLeap\Videos\RecommendationSystem\ClassificationDrivers\ClassificationDriver',
			'LangLeap\Videos\RecommendationSystem\ClassificationDrivers\SimilarityClassificationDriver'
		);
	}

}
