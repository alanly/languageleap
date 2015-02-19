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
	 * @param $client
	 * @return string URL to the audio
	 */
	public function getAudio($word, $client);

	/**
	 * Queries the API and returns the word with hypens
	 *
	 * @param $word
	 * @param $client
	 * @return string
	 */
	public function getHyphenatedWord($word, $client);
}

