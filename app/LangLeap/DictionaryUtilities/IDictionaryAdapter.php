<?php namespace LangLeap\DictionaryUtilities;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
interface IDictionaryAdapter
{
	/**
	 * Queries the API and returns the definition of the word
	 *
	 * @param $word
	 * @return definition object with the definition of the word
	 */
	public function getDefinition($word);

	/**
	 * Queries the API and returns the audio pronounciation of the word
	 *
	 * @param $word
	 * @return string URL to the audio
	 */
	public function getAudio($word);

	/**
	 * Queries the API and returns the word with hypens
	 *
	 * @param $word
	 * @return string
	 */
	public function getHyphenatedWord($word);
}

