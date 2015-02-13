<?php namespace LangLeap\Videos\FilterSystem;

/**
 * Defines the interface for a media type that can
 * be filtered.
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
interface Filterable {

	/**
	 * Returns an of attributes that can be
	 * filtered by the filtering system.
	 * @return array
	 */
	public function getFilterableAttributes();
	
}