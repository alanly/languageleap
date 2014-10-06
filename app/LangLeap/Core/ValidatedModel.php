<?php namespace LangLeap\Core;

use LangLeap\Exceptions\MissingValidationRuleException;
use LangLeap\Exceptions\MissingValidatorInstanceException;
use Eloquent, Validator;

abstract class ValidatedModel extends Eloquent {

	/**
	 * An array of validation rules for the model attributes.
	 * 
	 * @var array
	 */
	protected $rules;

	/**
	 * An instance of the Validator.
	 *
	 * @var Illuminate\Validation\Validator
	 */
	protected $validator;

	public function save(array $attributes = [])
	{
		if (! $this->isValid()) return false;

		return parent::save($attributes);
	}

	public function getErrors()
	{
		if (! $this->validator) throw new MissingValidatorInstanceException();

		return $this->validator->errors();
	}

	public function isValid()
	{
		if (! $this->rules) throw new MissingValidationRuleException();

		return $this->validateInstance();
	}

	protected function getParsedRules()
	{
		$parsedRules = [];

		foreach ($this->rules as $field => $rule)
		{
			// Replace '<id>' with existing ID
			if (str_contains($rule, '<id>'))
			{
				$id = $this->exists ? $this->getAttribute($this->primaryKey) : '';
				$rule = str_replace('<id>', $id, $rule);
			}

			$parsedRules[$field] = $rule;
		}

		return $parsedRules;
	}

	private function validateInstance()
	{
		$this->validator = Validator::make(
			$this->getAttributes(),
			$this->getParsedRules()
		);

		return $this->validator->passes();
	}
	
}
