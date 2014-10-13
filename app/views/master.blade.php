<!doctype html>
<html lang='en'>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Language Leap</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="//cdn.jsdelivr.net/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.0.3/css/bootstrap.min.css">
		<link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.min.css">	
        <link rel="stylesheet" href="/css/style.css">
		
		<!--jPlayer stuff are all here-->
		<script type="text/javascript" src="libraries/jplayer/js/jquery-2.1.1.js"></script>
		<script type="text/javascript" src="libraries/jplayer/js/jquery.jplayer.min.js"></script>
		<link rel="stylesheet" href="libraries/jplayer/css/style.css">
		<script>  
			$(document).ready(function(){  
				$("#jquery_jplayer_1").jPlayer({  
					ready: function () {  
						$(this).jPlayer("setMedia", {  
							m4v: "videos/TestVideo.mp4",  
							ogv: "",  
							poster: "videos/TestVideo.png"  
						});  
					},  
					swfPath: "libraries/jplayer/js/Jplayer.swf",  
					supplied: "m4v,ogv"
				});  
			});  
		</script>  
		
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="/css/admin.css">
	</head>
	<body>
		@yield('content')
	</body>
</html>
