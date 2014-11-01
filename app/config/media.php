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
		 * Configuration associated with the X-Sendfile implementation of the
		 * deploying web server.
		 */
		'xsendfile' => array(

			/**
			 * The web server being used with the application.
			 * Choices available are:
			 *
			 * 	Apache   -> apache
			 * 	Lighttpd -> lighttpd
			 * 	Nginx    -> nginx
			 * 	Disable  -> null
			 * 	
			 */
			'server' => null,

			/**
			 * 
			 * Map to the internal location stanzas in the Nginx configuration for
			 * Nginx's X-Sendfile functionality (they call it X-Accel). This location
			 * should alias to the parent directory of the individual 'videos' from
			 * above.
			 *
			 * For example,
			 * 	'commercials' => __DIR__.'/../storage/media/videos/commercials'
			 *
			 * The internal location in Nginx should alias to:
			 * 	__DIR__.'/../storage/media/videos
			 *
			 * Refer to Nginx official documentation,
			 * - http://wiki.nginx.org/X-accel
			 * - http://wiki.nginx.org/XSendfile
			 */
			'videos' => '/internal/videos',

		),
	),

	'test' => __DIR__.'/../storage/media/tests',

);	
