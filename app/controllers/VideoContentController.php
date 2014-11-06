<?php

use LangLeap\Core\FileInfoFactory;
use LangLeap\Videos\Video;

/**
 * @author  Alan Ly <hello@alan.ly>
 */
class VideoContentController extends \BaseController {

	protected $videos;
	protected $fileInfoFactory;


	public function __construct(Video $videos, FileInfoFactory $fileInfoFactory)
	{
		// Get reference for the database repository instance.
		$this->videos = $videos;

		// Get a reference to the FileInfo factory.
		$this->fileInfoFactory = $fileInfoFactory;
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

		return Response::download($file, null, $headers);
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

		$headers = [
			'apache'   => ['X-Sendfile'           => $file->getRealPath()],
			'lighttpd' => ['X-LIGHTTPD-send-file' => $file->getRealPath()],
			'nginx'    => ['X-Accel-Redirect'     => Config::get('media.paths.xsendfile.videos').'/'.$parentDirName.$file->getFilename()],
		];

		return $headers[$server];
	}

}
