 <?php
 
use LangLeap\Quizzes\VideoQuestion;
 
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
		
		return $this->apiResponse(
			'success',
			$tutorialData,
			200
		);
	}
 }
