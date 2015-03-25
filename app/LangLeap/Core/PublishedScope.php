<?php namespace LangLeap\Core;
 
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ScopeInterface;
use Auth;

/**
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class PublishedScope implements ScopeInterface {

	/**
	* Apply scope on the query.
	* 
	* @param \Illuminate\Database\Eloquent\Builder  $builder
	* @return void
	*/
	public function apply(Builder $builder)
	{
		$column = $builder->getModel()->getQualifiedPublishedColumn();

		$user = Auth::user();

		// Don't restrict unpublished content for admins
		if (! $user || ! $user->is_admin)
		{
			$builder->where($column, '=', 1);
		}
	}

	/**
	* Remove scope from the query.
	* 
	* @param  Builder $builder
	* @return void
	*/
	public function remove(Builder $builder)
	{
		$query = $builder->getQuery();

		$column = $builder->getModel()->getQualifiedPublishedColumn();

		$bindingKey = 0;

		foreach ((array) $query->wheres as $key => $where)
		{
			if ($this->isPublishedConstraint($where, $column))
			{
				$this->removeWhere($query, $key);
				$this->removeBinding($query, $bindingKey);
			}
		}
	}

	/**
	* Remove scope constraint from the query.
	* 
	* @param  \Illuminate\Database\Query\Builder  $builder
	* @param  int  $key
	* @return void
	*/
	protected function removeWhere(BaseBuilder $query, $key)
	{
		unset($query->wheres[$key]);

		$query->wheres = array_values($query->wheres);
	}

	/**
	* Remove scope constraint from the query.
	* 
	* @param  \Illuminate\Database\Query\Builder  $builder
	* @param  int  $key
	* @return void
	*/
	protected function removeBinding(BaseBuilder $query, $key)
	{
		$bindings = $query->getRawBindings()['where'];

		unset($bindings[$key]);

		$query->setBindings($bindings);
	}

	/**
	* Check if given where is the scope constraint.
	* 
	* @param  array   $where
	* @param  string  $column
	* @return boolean
	*/
	protected function isPublishedConstraint(array $where, $column)
	{
		return ($where['type'] == 'Basic' && $where['column'] == $column && $where['value'] == 1);
	}

}