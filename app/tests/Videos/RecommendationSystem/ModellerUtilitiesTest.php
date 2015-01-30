<?php namespace LangLeap\Videos\RecommendationSystem\Utilities;

use App;
use LangLeap\TestCase;
use Mockery as m;

class ModellerUtilitiesTest extends TestCase {	

	protected function getCollectionInstance($items = [])
	{
		// Collection's and Traversable's are kind of hairy to mock, so we'll
		// just instantiate a Collection.
		return App::make('LangLeap\Core\Collection', [$items]);
	}


	public function testGetClassifiableMediaFromHistoryReturnsACollection()
	{
		$u = new ModellerUtilities;

		$media = m::mock('LangLeap\Videos\Media, LangLeap\Videos\RecommendationSystem\Classifiable');

		$video = m::mock('LangLeap\Videos\Video');
		$video->shouldReceive('getAttribute')->with('viewable')->andReturn($media);

		$history = m::mock('LangLeap\Core\ValidatedModel');
		$history->shouldReceive('getAttribute')->with('video')->andReturn($video);

		$c = $this->getCollectionInstance([$history]);

		$this->assertInstanceOf(
			'LangLeap\Core\Collection',
			$u->getClassifiableMediaFromHistory($c)
		);

		$this->assertSame($media, $u->getClassifiableMediaFromHistory($c)->first());
	}


	public function testGetClassificationAttributesFromMediaForSingleClassifiableInstance()
	{
		$c = m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');
		$c->shouldReceive('getClassificationAttributes')->once()->andReturn('foo');

		$u = new ModellerUtilities;
		$a = $u->getClassificationAttributesFromMedia($c);

		$this->assertInstanceOf('Traversable', $a);
		$this->assertSame('foo', $a[0]);
	}


	public function testGetClassificationAttributesFromMediaForCollectionOfClassifiableInstances()
	{
		$classifiable = m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');
		$classifiable->shouldReceive('getClassificationAttributes')->times(3)->andReturn('foo');

		$collection = $this->getCollectionInstance([$classifiable, $classifiable, $classifiable]);

		$u = new ModellerUtilities;
		$a = $u->getClassificationAttributesFromMedia($collection);

		$this->assertCount(3, $a);
		$this->assertInstanceOf('Traversable', $a);
		$this->assertSame('foo', $a[0]);
		$this->assertSame('foo', $a[1]);
		$this->assertSame('foo', $a[2]);
	}


	public function testGetClassificationAttributesFromMediaForArrayOfClassifiableInstances()
	{
		$classifiable = m::mock('LangLeap\Videos\RecommendationSystem\Classifiable');
		$classifiable->shouldReceive('getClassificationAttributes')->times(3)->andReturn('foo');

		$array = [$classifiable, $classifiable, $classifiable];

		$u = new ModellerUtilities;
		$a = $u->getClassificationAttributesFromMedia($array);

		$this->assertCount(3, $a);
		$this->assertInstanceOf('Traversable', $a);
		$this->assertSame('foo', $a[0]);
		$this->assertSame('foo', $a[1]);
		$this->assertSame('foo', $a[2]);
	}


	public function testCreatingModelFromClassifiableAttributesForOneDictionary()
	{
		// Create an attribute.
		$attributes = $this->getCollectionInstance([
			[
				'director' => 'M. Night Shyamalan',
				'actors'   => ['Anna Kendrick', 'Rob Lowe'],
				'genres'   => ['Drama', 'Action'],
			],
		]);

		// Create a model
		$model = App::make('LangLeap\Videos\RecommendationSystem\Model');

		$u = new ModellerUtilities;
		$return = $u->populateModelFromAttributes($model, $attributes);

		$this->assertSame($model, $return);
		$this->assertSame($model->size(), $return->size());

		$this->assertCount(3, $model);
		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Attribute', $model->director);
		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Attribute', $model->actors);
		$this->assertInstanceOf('LangLeap\Videos\RecommendationSystem\Attribute', $model->genres);

		$this->assertSame(1, $model->director->size());
		$this->assertSame(2, $model->actors->size());
		$this->assertSame(2, $model->genres->size());

		$this->assertSame(1, $model->actors->count('Anna Kendrick'));
	}


	public function testCreatingModelFromAttributesForMultipleDictionaries()
	{
		$attributes = $this->getCollectionInstance([
			[
				'director' => 'M. Night Shyamalan',
				'actors'   => ['Anna Kendrick', 'Rob Lowe'],
				'genres'   => ['Drama', 'Action'],
			],
			[
				'actors' => ['Anna Kendrick', 'Zooey Deschanel', 'Audrey Plaza'],
				'genres' => ['Comedy', 'Sitcom'],
				'type'   => 'show',
			],
		]);

		$model = App::make('LangLeap\Videos\RecommendationSystem\Model');

		$u = new ModellerUtilities;
		$return = $u->populateModelFromAttributes($model, $attributes);

		$this->assertSame($model, $return);
		$this->assertSame($model->size(), $return->size());

		$this->assertCount(4, $model);

		$this->assertSame(1, $model->director->size());
		$this->assertSame(4, $model->actors->size());
		$this->assertSame(4, $model->genres->size());
		$this->assertSame(1, $model->type->size());
	}
	
}
