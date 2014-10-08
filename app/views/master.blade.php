<!doctype html>
<html lang='en'>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Language Leap</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
		<script src="//cdn.jsdelivr.net/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.0.3/css/bootstrap.min.css">

		<link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.min.css">	
        <link rel="stylesheet" href="/css/style.css">
		
		<!--jPlayer stuff are all here-->
		<script type="text/javascript" src="/jplayer/js/jquery.jplayer.min.js"></script>
		<link rel="stylesheet" href="/jplayer/css/style.css">
		<script>  
			$(document).ready(function(){  
				$("#jquery_jplayer_1").jPlayer({  
					ready: function () {  
						$(this).jPlayer("setMedia", {  
							m4v: "app/TestVideo.mp4",  
							ogv: "",  
							poster: "app/TestVideo.jpg"  
						});  
					},  
					swfPath: "/jplayer/js",  
					supplied: "m4v,ogv"  
				});  
			});  
		</script>  
		
	</head>
	<body>
		@yield('content')
	</body>
</html>
