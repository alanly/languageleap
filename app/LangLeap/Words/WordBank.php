<?php namespace LangLeap\Words;

use Eloquent;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class WordBank extends Eloquent {

	public $timestamps	= false;

	protected $fillable	= ['user_id', 'media_id', 'media_type','definition_id'];
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
		$definition = Definition::find($this->definition_id)->first();
		
		return array(
			'id' 			=> $this->id,
			'definition' 	=> [
				'id' 			=> $definition->id,
				'word' 			=> $definition->word,
				'pronunciation' => $definition->pronunciation,
				'definition' 	=> $definition->definition,
			]
		);
	}

}
