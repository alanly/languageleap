var mouse_down = false;

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

		videoPlayer.on('timeupdate', function()
		{			
			var seconds = Math.round(videoPlayer.get(0).currentTime);

			var time = parseInt(seconds / 60, 10) + ":" + ((parseInt(seconds % 60, 10) < 10) ? "0" : "") + parseInt(seconds % 60, 10);

			$('.current').text(time);
		});

		videoPlayer.on('loadedmetadata', function()
		{
			var seconds = Math.round(videoPlayer.get(0).duration);

			var time = parseInt(seconds / 60, 10) + ":" + ((parseInt(seconds % 60, 10) < 10) ? "0" : "") + parseInt(seconds % 60, 10);

			$('.duration').text(time);
		});

		videoPlayer.on('timeupdate', function()
		{		
			if(Math.round(videoPlayer.get(0).currentTime) == Math.round(videoPlayer.get(0).duration))
			{
				$( '.glyphicon-pause' ).attr( 'class', 'glyphicon glyphicon-play' );
			}
		});

		videoPlayer.on('timeupdate', function()
		{
			var progressBar = $( '.progress-bar' );

			var completionPercent = Math.floor(($( '.progress' ).width() / videoPlayer.get(0).duration) * videoPlayer.get(0).currentTime);

			progressBar.width(completionPercent);
			
			var slider = $( '#slider-bar' );

			if(!(slider.is(":hover") && mouse_down))
			{
				slider.val((100 / videoPlayer.get(0).duration) * videoPlayer.get(0).currentTime);
			}

			console.log($( '#slider-bar' ).val());
		});

		$( '.speed' ).click( function()
		{
			if(videoPlayer.get(0).playbackRate == 1)
			{
				videoPlayer.get(0).playbackRate += 0.5;

				$( '.glyphicon-fast-forward' ).attr( 'class', 'glyphicon glyphicon-step-forward' );
			}
			else
			{
				videoPlayer.get(0).playbackRate -= 0.5;

				$( '.glyphicon-step-forward' ).attr( 'class', 'glyphicon glyphicon-fast-forward' );
			}
		});

		$( '.slider' ).change( function()
		{
			videoPlayer.get(0).currentTime = $( '#slider-bar' ).val();
		});


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

		$( '.full-screen' ).on( 'click', function()
		{
			videoPlayer.get(0).webkitEnterFullscreen();
			videoPlayer.get(0).mozRequestFullScreen();
			return false;
		});
	});