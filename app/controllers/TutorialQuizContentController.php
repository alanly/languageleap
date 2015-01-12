 <?php
 
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Core\Collection;

class TutorialQuizContentController extends \BaseController
{	
	public function getIndex()
	{
		$tutorialQuestions = [];
		$tutorialAnswers = [];
		
		$vqs = VideoQuestion::join('videos', 'videos.id', '=', 'videoquestions.video_id')->where('videos.path', '=', '/path/to/tutorial/video.mkv')->get();
		foreach($vqs as $vq)
		{
			array_push($tutorialQuestions, $vq->question);
			foreach($vq->question->answers as $ans)
			{
				array_push($tutorialAnswers, $ans);
			}
		}
		
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
		
		return $this->generateResponse($tutorialQuestions);

		/*return $this->apiResponse(
			'success',
			$tutorialData,
			200
		);*/
	}

	/**
	 * @param  Collection of LangLeap\Quizzes\Questions   $question
	 * @return Illuminate\Http\JsonResponse
	 */
	protected function generateResponse($questions)
	{
		$code = 200;
		$question_array = [];
		foreach ($questions as $question) {
			$answers = [];
			foreach($question->answers as $ans){
				array_push($answers, [
						'id' => $ans->id,
						'answer' => $ans->answer
					]);
			}

			array_push($question_array, [
					'id' => $question->id,
					'question' => $question->question,
					'answers' => $answers
				]);
		}
		
		return $this->apiResponse('success', ["questions" => $question_array], $code);
	}
 }
