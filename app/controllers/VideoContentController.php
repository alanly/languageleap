<?php

use LangLeap\Accounts\User;
use LangLeap\Accounts\ViewingHistory;
use LangLeap\Core\FileInfoFactory;
use LangLeap\Videos\Video;

/**
 * @author  Alan Ly <hello@alan.ly>
 */
class VideoContentController extends \BaseController {

	protected $videos;
	protected $fileInfoFactory;
	protected $viewingHistories;


	public function __construct(Video $videos, FileInfoFactory $fileInfoFactory, ViewingHistory $viewingHistories)
	{
		// Get reference for the database repository instance.
		$this->videos = $videos;

		// Get a reference to the FileInfo factory.
		$this->fileInfoFactory = $fileInfoFactory;

		// Get a reference to the viewing history repository.
		$this->viewingHistories = $viewingHistories;
	}


	/**
	 * Stream the video resource.
	 * 
	 * @param  int $id
	 * @return Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function getVideo($id)
	{
		$video = $this->videos->find($id);

		if (! $video)
		{
			return $this->apiResponse('error', "Video {$id} not found.", 404);
		}

		// Get an instance of SplFileInfo from the factory.
		$file = $this->fileInfoFactory->makeInstance($video->path);

		if (! ($file->isFile() && $file->isReadable()))
		{
			return $this->apiResponse('error', "An error occurred while reading video {$id}.", 500);
		}

		// Create the Sendfile headers for this file.
		$headers = $this->getSendfileHeadersForFile($file);

		// Insert a viewing history record for the logged in user.
		if (Auth::check())
		{
			$this->addViewingHistoryRecord(Auth::user(), $video);
		}

		return Response::download($file, null, $headers, 'inline');
	}

	
	/**
	 * Inserts the viewing history record for the given video to the given user.
	 * @param  User  $user  The user that's viewing the video
	 * @param  Video $video The video that's being viewed
	 * @return ViewingHistory
	 * @author Thomas Rahn <thomas@rahn.ca>
	 */
	protected function addViewingHistoryRecord(User $user, Video $video)
	{
		$history = $this->viewingHistories->where('user_id', $user->id)
		                                  ->where('video_id', $video->id)
		                                  ->get()
		                                  ->first();

		if ($history) return $history;

		return $this->viewingHistories->create([
			'user_id'      => $user->id,
			'video_id'     => $video->id,
			'is_finished'  => false,
			'current_time' => 0
		]);
	}


	/**
	 * Based on the given file, this returns an array containing the appropriate
	 * XSendfile header-fields for Apache, Lighttpd, and Nginx.
	 * 
	 * @param  SplFileInfo $file
	 * @return array
	 */
	protected function getSendfileHeadersForFile(SplFileInfo $file)
	{
		$server = Config::get('media.paths.xsendfile.server');

		if (! $server) return [];

		$parentDirName = basename(dirname($file->getRealPath())).'/';

		$sendfileHeader = [
			'apache'   => ['X-Sendfile'           => $file->getRealPath()],
			'lighttpd' => ['X-LIGHTTPD-send-file' => $file->getRealPath()],
			'nginx'    => ['X-Accel-Redirect'     => Config::get('media.paths.xsendfile.videos').'/'.$parentDirName.$file->getFilename()],
		];

		return $sendfileHeader[$server];
	}

}
