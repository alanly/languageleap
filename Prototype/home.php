<!DOCTYPE html>
<html>
<head>

	<!-- Slider -->
	<link rel="Stylesheet" type="text/css" href="Accordion/css/default/reset.css" /> 
    <link rel="Stylesheet" type="text/css" href="Accordion/css/evoslider.css" />
    <link rel="Stylesheet" type="text/css" href="Accordion/css/default/default.css" />

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- CSS -->
	<link rel="stylesheet" href="CSS/main.css">

	<!-- jQuery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="Accordion/js/jquery.browser.js" /></script>
	<script type="text/javascript" src="Accordion/js/jquery.evoslider.lite-1.1.0.js"></script>
	<script type="text/javascript" src="Accordion/js/jquery.easing.1.3.js"></script>

</head>
<body>

	<nav class="navbar navbar-default" role="navigation">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">LanguageLeap</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav nav-pills nav-justified">
	        <li class="active"><a href="#">My Videos</a></li>
	        <li><a href="#">My Account</a></li>
	        <li><a href="#">Help</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

    <div id="includedContent"></div>

    <button class="buttonUnder" id="nextStep" type="button" class="btn btn-default">Next</button>

</body>
</html>

<script>

var steps = ["select", "video", "script", "flashcard", "quiz", "done"];
var currentStep = 0;

$(document).ready(function(){
   loadStep(currentStep);
});


$("#nextStep").click(function() {
  loadStep(currentStep);
});

function loadStep(step)
{
	$(function(){
	  $("#includedContent").load(steps[currentStep] + ".php");
	  currentStep++; 
	});

	if(currentStep == 6)
	{
		$('#nextStep').attr("disabled", true);
	}
}



</script>