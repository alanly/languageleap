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

	protected $fillable	= ['user_id', 'media_id', 'media_type', 'definition_id'];
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
		return $this->belongsTo('LangLeap\Words\Definition');
	}

	public function toResponseArray()
	{
		$definition = Definition::find($this->definition_id);
		$definition->audio_url = $this->getAudioUrl($definition->word);
		
		return array(
			'id' 		=> $this->id,
			'media_id'	=> $this->media_id,
			'media_type'	=> $this->media_type,
			'definition' 	=> $definition->toResponseArray(),
		);
	}

	private function getAudioUrl($word)
	{
		$user = User::find($this->user_id);

		$language = Language::find($user->language_id);
		if(!$language)
		{
			return null;
		}

		$language = strtoupper($language->code);
		$dictionary = DictionaryFactory::getInstance()->getDictionary($language);
		return $dictionary->getAudio($word, $dictionary->instantiateConnection());
	}
}
