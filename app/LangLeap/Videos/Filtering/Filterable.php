<?php namespace LangLeap\Videos\Filtering;

/**
 * Defines the interface for a media type that can
 * be filtered.
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
interface Filterable {

	/**
	 * Returns a collection of filtered content.
	 * @param   array       A dictionary of query data
	 * @param   int         $take    The number of matches to retrieve
	 * @param   int         $skip    The starting index of where to start retrieving
	 * @return  Collection  A collection of filtered results
	 */
	public static function filterBy($input, $take, $skip = 0);
	
}