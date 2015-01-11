 <?php
 
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
 
class TutorialQuizContentController extends \BaseController
{	
	public function getIndex()
	{
		$tutorialQuestions = Question::where('id', '<', 6)->get();
		$tutorialAnswers = Answer::where('id', '<', 21)->get();
		
		$tutorialData = [$tutorialQuestions, $tutorialAnswers];
		
		if(!$tutorialQuestions)
		{
			return $this->apiResponse(
				'error',
				"One or more questions do not exist.",
				404
			);
		}
		
		if(!$tutorialAnswers)
		{
			return $this->apiResponse(
				'error',
				"One or more questions do not exist.",
				404
			);
		}
		
		return $this->apiResponse(
			'success',
			$tutorialData,
			200
		);
	}
 }
