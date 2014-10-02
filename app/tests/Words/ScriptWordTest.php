<?php namespace LangLeap\Words;

use LangLeap\TestCase;
use App;

class ScriptWordTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testScriptRelation()
	{
		$word = $this->getWordInstance();
		$script = $this->getScriptInstance();
		$script_word = $this->getScriptWordInstance();
		$script_word->word_id = $word->id;
		$script_word->script_id = $script->id;
		$script_word->position = 1;
		$script_word->save();

		
		$this->assertCount(1, $script_word->script()->get());
	
	}
	public function testWordRelation()
        {
                $word = $this->getWordInstance();
                $script = $this->getScriptInstance();
                $script_word = $this->getScriptWordInstance();
                $script_word->word_id = $word->id;
                $script_word->script_id = $script->id;	
		$script_word->position = 1;
                $script_word->save();


                $this->assertCount(1, $script_word->word()->get());

        }

	protected function getWordInstance()
	{
		$word = App::make('LangLeap\Words\Word');
		$word->word = '';
		$word->definition = '';
		$word->full_definition = '';
		$word->save();
		return $word;

	}
	protected function getScriptInstance()
	{
		$script = App::make('LangLeap\Words\Script');
		$script->text ='';		
		$script->video_id = 1;
		$script->save();
		return $script;
	}
	protected function getScriptWordInstance()
        {
                return App::make('LangLeap\Words\Script_Word');
        }

	

}
