<?php namespace LangLeap\Videos\RecommendationSystem\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class ModellerUtilitiesServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('modeller.utilities', function()
		{
			return App::make('LangLeap\Videos\RecommendationSystem\ModellerUtilities');
		});
	}
	
}
