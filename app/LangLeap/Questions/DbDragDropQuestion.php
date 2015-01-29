<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DbDragDropQuestion extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['question' => 'string|required', 'definition_id' => 'integer|required'];

	public function question()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}

	public function definition()
	{
		return $this->hasOne('LangLeap\Words\Definition');
	}
}
