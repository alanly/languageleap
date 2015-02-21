<?php namespace LangLeap\Words;

use Eloquent;
use LangLeap\Accounts\User;
use LangLeap\Core\Language;
use LangLeap\DictionaryUtilities\DictionaryFactory;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class WordBank extends Eloquent {

	public $timestamps	= false;

	protected $fillable	= ['user_id', 'media_id', 'media_type', 'word'];
	protected $table	= "word_bank";


	public function user()
	{
		return $this->belongsTo('LangLeap\Accounts\User');
	}

	public function media()
	{
		return $this->morphTo();
	}	

	public function definition()
	{
		return Definition::where('word', '=', $this->word)->first();
	}

	public function toResponseArray()
	{
		$definition = $this->definition();
		$dictionary = $this->getDictionary();
		
		if(!$definition)
		{
			$definition = $dictionary->getDefinition($this->word);
			$definition->word = $this->word;
		}
		else
		{
			$definition->audio_url = $dictionary->getAudio($definition->word, $dictionary->instantiateConnection());
		}
		
		return array(
			'id' 		=> $this->id,
			'media_id'	=> $this->media_id,
			'media_type'	=> $this->media_type,
			'definition' 	=> $definition->toResponseArray(),
		);
	}
	
	private function getDictionary()
	{
		$user = User::find($this->user_id);
		
		$language = Language::find($user->language_id);
		if(!$language)
		{
			return null;
		}
		
		$language = strtoupper($language->code);
		return DictionaryFactory::getInstance()->getDictionary($language);
	}
}
