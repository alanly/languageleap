<?php 

use LangLeap\TestCase;
use LangLeap\Words\Definition;
use LangLeap\DictionaryUtilities\DictionaryFactory;


class ApiDictionaryTest extends TestCase {

	private function getDefinitionMock()
	{
		return Mockery::mock('LangLeap\Words\Definition');
	}

	private function getAdapterMock()
	{
		return Mockery::mock('LangLeap\DictionaryUtilities\IDictionaryAdapter');
	}

	private function getFactoryMock()
	{
		return Mockery::mock('LangLeap\DictionaryUtilities\DictionaryFactory');
	}

	public function testWordDefinition()
	{
		// Mock the definition instance.
		$definition = $this->getDefinitionMock();
		$definition->shouldReceive('toResponseArray')->once()->andReturn(['word' => 'foobar']);

		// Mock the dictionary adapter.
		$adapter = $this->getAdapterMock();
		$adapter->shouldReceive('getDefinition')->once()->andReturn($definition);
		
		// Mock the factory.
		$factory = $this->getFactoryMock();
		$factory->shouldReceive('getDictionary')->once()->andReturn($adapter);

		DictionaryFactory::getInstance($factory);

		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@index', [], ['word' => 'dog', 'video_id' => '1']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;
		
		$this->assertSame('foobar', $data->word);
	}

	public function testWordDefinitionNotFound()
	{
		// Mock the dictionary adapter.
		$adapter = $this->getAdapterMock();
		$adapter->shouldReceive('getDefinition')->once()->andReturn(null);
		
		// Mock the factory.
		$factory = $this->getFactoryMock();
		$factory->shouldReceive('getDictionary')->once()->andReturn($adapter);

		DictionaryFactory::getInstance($factory);

		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@index', [], ['word' => 'abcdef', 'video_id' => '1']);

		$data = $response->getData()->data;

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);

		$this->assertSame('Definition not found.', $data);
	}

	public function testVideoIdInvalid()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@index', [], ['word' => 'dog', 'video_id' => '-1']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

}
