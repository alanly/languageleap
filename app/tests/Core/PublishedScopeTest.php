<?php

use LangLeap\TestCase;
use LangLeap\Core\PublishedScope;
use Mockery as m;

/**
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class PublishedScopeTest extends TestCase {
	
	protected function getBuilderMock()
	{
		return m::mock('Illuminate\Database\Eloquent\Builder');
	}

	protected function getQueryBuilderMock()
	{
		return m::mock('Illuminate\Database\Query\Builder');
	}

	protected function getModelMock()
	{
		return m::mock('StdClass');
	}

	protected function getUserInstance($admin = false) {
		$user = App::make('LangLeap\Accounts\User');
		$user->username = 'username';
		$user->email = 'username@email.com';
		$user->password = Hash::make('password');
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->language_id = 1;
		$user->is_admin = $admin;

		return m::mock($user);
	}

	public function testApply()
	{
		$builder = $this->getBuilderMock();
		$model = $this->getModelMock();

		$model->shouldReceive('getQualifiedPublishedColumn')->once()->andReturn('is_published');
		$builder->shouldReceive('getModel')->once()->andReturn($model);
		$builder->shouldReceive('where')->once();

		$ps = new PublishedScope;

		$ps->apply($builder);
	}

	public function testApplyAsAdmin()
	{
		$builder = $this->getBuilderMock();
		$model = $this->getModelMock();

		$model->shouldReceive('getQualifiedPublishedColumn')->once()->andReturn('is_published');
		$builder->shouldReceive('getModel')->once()->andReturn($model);

		$this->be($this->getUserInstance(true));

		$ps = new PublishedScope;

		$ps->apply($builder);
	}

	public function testRemove()
	{
		$builder = $this->getBuilderMock();
		$query = $this->getQueryBuilderMock();
		$model = $this->getModelMock();

		$builder->shouldReceive('getQuery')->once()->andReturn($query);
		$builder->shouldReceive('getModel')->once()->andReturn($model);
		$model->shouldReceive('getQualifiedPublishedColumn')->once()->andReturn('table.is_published');

		$query->wheres = [['type' => 'Null', 'column' => 'foo'], ['type' => 'Basic', 'column' => 'table.is_published', 'value' => 1]];
		$query->shouldReceive('getRawBindings')->once()->andReturn($bindings = ['where' => ['something', 'somethingelse']]);
		$query->shouldReceive('setBindings');

		$ps = new PublishedScope;

		$ps->remove($builder);

		$this->assertEquals($query->wheres, [['type' => 'Null', 'column' => 'foo']]);
	}

}
