<?php namespace LangLeap\Words;

use Eloquent;

/**
 * @author David Siekut <davidsiekut@gmail.com>
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class Definition extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['word', 'definition', 'full_definition', 'pronunciation'];
	
	public function toResponseArray()
	{
		return array(
			'id' => $this->id,
			'word' => $this->word,
			'definition' => $this->definition,
			'full_definition' => $this->full_definition,
			'pronunciation' => $this->pronunciation
		);
	}

}
