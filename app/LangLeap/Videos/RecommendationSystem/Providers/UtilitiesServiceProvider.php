<?php namespace LangLeap\Videos\RecommendationSystem\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class UtilitiesServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('classifier.utilities', function()
		{
			return App::make('LangLeap\Videos\RecommendationSystem\Utilities');
		});
	}
	
}
