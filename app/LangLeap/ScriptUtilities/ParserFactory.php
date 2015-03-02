<?php namespace LangLeap\ScriptUtilities;

/**
* @author Michael Lavoie <lavoie6453@gmail.com>
*/
abstract class ParserFactory {

	/**
	* @param   int            $type  The factory type to get (refer to FactoryType)
	* @return  ParserFactory         A requested concrete factory
	*/         
	public static function getFactory($type)
	{
		switch ($type)
		{
			case FactoryType::SUBRIP:
				$factory = new SubRipParserFactory();
				break;
			// More types can be added here
		}

		return $factory;
	}

	/**
	* @return  Parser  A parsable type
	*/
	abstract public function getParser();

}