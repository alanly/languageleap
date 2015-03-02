<?php namespace LangLeap\Videos\RecommendationSystem\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class RecommendationRepositoryServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'LangLeap\Videos\RecommendationSystem\Repositories\RecommendationRepository',
			'LangLeap\Videos\RecommendationSystem\Repositories\RedisRecommendationRepository'
		);
	}
	
}
