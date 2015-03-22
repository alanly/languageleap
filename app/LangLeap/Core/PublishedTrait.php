<?php namespace LangLeap\Core;

/**
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
trait PublishedTrait {

	/**
	* Boot the scope.
	* 
	* @return void
	*/
	public static function bootPublishedTrait()
	{
		static::addGlobalScope(new PublishedScope);
	}

	/**
	* Get the fully qualified column name for applying the scope.
	* 
	* @return string
	*/
	public function getQualifiedPublishedColumn()
	{
		return $this->getTable() . '.is_published';
	}

}