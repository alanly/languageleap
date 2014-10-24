<?php 

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
 */
return array(

	'paths' => array(
		'uploads' => __DIR__.'/../storage/media/uploads',

		'videos' => array(
			'commercials' => __DIR__.'/../storage/media/videos/commercials',
			'movies'      => __DIR__.'/../storage/media/videos/movies',
			'shows'       => __DIR__.'/../storage/media/videos/shows',
		),

		'img' => __DIR__.'/../storage/media/img',

		/**
		 * Map to the internal location stanzas in the Nginx configuration for
		 * Nginx's XSendfile functionality (they call it X-Accel).
		 * 
		 * Refer to Nginx official documentation,
		 * - http://wiki.nginx.org/X-accel
		 * - http://wiki.nginx.org/XSendfile
		 */
		'xsendfile' => array(

			/**
			 * Map internal for videos. This location should alias to the parent
			 * directory of the individual 'videos' from above.
			 *
			 * For example,
			 * 	'commercials' => __DIR__.'/../storage/media/videos/commercials'
			 *
			 * The internal location in Nginx should alias to:
			 * 	__DIR__.'/../storage/media/videos
			 */
			'videos' => '/internal/videos',

		),
	),

	'test' => __DIR__.'/../storage/media/tests',

);	
