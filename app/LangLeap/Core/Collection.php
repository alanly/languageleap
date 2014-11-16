<?php namespace LangLeap\Core;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class Collection extends EloquentCollection {

	/**
	 * Remove a model from the collection by key.
	 *
	 * @param  mixed  $key
	 * @return void
	 */
	public function forget($key)
	{
		$this->pull($key);
	}


	/**
	 * Pulls a model from the collection.
	 * 
	 * @param  mixed  $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	public function pull($key, $default = null)
	{
		if ($key instanceof Model)
		{
			$key = $key->getKey();
		}

		foreach ($this->items as $index => $model)
		{
			if ($model->getKey() == $key)
			{
				$needle = $model;
				unset($this->items[$index]);
				return $needle;
			}
		}

		return $default;
	}


	/**
	 * Pull one or more models randomly from the collection.
	 *
	 * @param  int  $amount
	 * @return mixed
	 */
	public function pullRandom($amount = 1)
	{
		if ($this->isEmpty()) return null;

		$keys = array_rand($this->items, $amount);
	
		$items = is_array($keys) ? array_intersect_key($this->items, array_flip($keys)) : $this->items[$keys];

		if (! is_array($keys)) $keys = [$keys];

		foreach ($keys as $key)
		{
			unset($this->items[$key]);
		}

		return $items;
	}
	
}
