var mouse_down = false;

//Get if the mouse is down
$(document).mousedown(function() 
{
    mouse_down = true;

}).mouseup(function() 
{
    mouse_down = false;  
});

$( document ).ready( function() 
{
	var videoPlayer = $('#video-player');

	$(function () {
  		$('[data-toggle="tooltip"]').tooltip();
	});

	//Toggle Play/Pause and corresponding icon
	$( '.play-pause' ).click( function()
	{
		if(videoPlayer.get(0).paused)
		{
			videoPlayer.get(0).play();

			$( '.glyphicon-play' ).attr( 'class', 'glyphicon glyphicon-pause' );
		}
		else
		{
			videoPlayer.get(0).pause();

			$( '.glyphicon-pause' ).attr( 'class', 'glyphicon glyphicon-play' );
		}

		return false;
	});

	//Udpate the current time of the video
	videoPlayer.on('timeupdate', function()
	{			
		var seconds = Math.round(videoPlayer.get(0).currentTime);

		var time = parseInt(seconds / 60, 10) + ":" + ((parseInt(seconds % 60, 10) < 10) ? "0" : "") + parseInt(seconds % 60, 10);

		$('.current').text(time);
	});

	//Load the total length of the video
	videoPlayer.on('loadedmetadata', function()
	{
		var seconds = Math.round(videoPlayer.get(0).duration);

		var time = parseInt(seconds / 60, 10) + ":" + ((parseInt(seconds % 60, 10) < 10) ? "0" : "") + parseInt(seconds % 60, 10);

		$('.duration').text(time);
	});

	//Change Play icon to Pause when the video is done
	videoPlayer.on('timeupdate', function()
	{		
		if(Math.round(videoPlayer.get(0).currentTime) == Math.round(videoPlayer.get(0).duration))
		{
			$( '.glyphicon-pause' ).attr( 'class', 'glyphicon glyphicon-play' );
		}
	});

	//Update the Seek Bar (slider) to match the current time of the video
	videoPlayer.on('timeupdate', function()
	{
		var slider = $( '#slider-bar' );

		if(!(slider.is(":hover") && mouse_down))
		{
			slider.val((100 / videoPlayer.get(0).duration) * videoPlayer.get(0).currentTime);
		}
	});

	//Toggle play speed and corresponding icon
	$( '.speed' ).click( function()
	{
		if(videoPlayer.get(0).playbackRate == 1)
		{
			videoPlayer.get(0).playbackRate = 1.7;

			$( '.glyphicon-fast-forward' ).attr( 'class', 'glyphicon glyphicon-step-backward' );

			$( '.speed' ).attr('data-original-title', 'Playing at 1.7x speed.')
		}
		else if(videoPlayer.get(0).playbackRate == 1.7)
		{
			videoPlayer.get(0).playbackRate = 0.7;

			$( '.glyphicon-step-backward' ).attr( 'class', 'glyphicon glyphicon-step-forward' );

			$( '.speed' ).attr('data-original-title', 'Playing at 0.7x speed.')
		}
		else
		{
			videoPlayer.get(0).playbackRate = 1;

			$( '.glyphicon-step-forward' ).attr( 'class', 'glyphicon glyphicon-fast-forward' );

			$( '.speed' ).attr('data-original-title', 'Playing at 1x speed.')
		}
	});

	//Update current time of the video when the slider is manipulated
	$( '.slider' ).change( function()
	{
		videoPlayer.get(0).currentTime = $( '#slider-bar' ).val();
	});

	//Toggle Mute and the corresponding icon
	$( '.mute' ).click(function()
	{
		if( !videoPlayer.get(0).muted )
		{
			videoPlayer.get(0).muted = true;

			$('.glyphicon-volume-up').attr( 'class' , 'glyphicon glyphicon-volume-off');
		}
		else
		{
			videoPlayer.get(0).muted = false;

			$('.glyphicon-volume-off').attr( 'class' , 'glyphicon glyphicon-volume-up');
		}
	});

	//Enter fullscreen mode
	$( '.full-screen' ).on( 'click', function()
	{
		videoPlayer.get(0).webkitEnterFullscreen();
		videoPlayer.get(0).mozRequestFullScreen();
		return false;
	});
});
