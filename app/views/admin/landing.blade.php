@extends('admin.master')

@section('content')
<!DOCTYPE html>
    
    <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
      	<div class="container-fluid">
        	<div class="navbar-header">
          		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            		<span class="sr-only">Toggle navigation</span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
          		</button>
          	<a class="navbar-brand" href="#">Language Leap</a>
        	</div>

        	<div id="navbar" class="navbar-collapse collapse">
          		<ul class="nav navbar-nav navbar-right">
            		<li><a href="#">Dashboard</a></li>
            		<li><a href="#">Settings</a></li>
            		<li><a href="#">Profile</a></li>
            		<li><a href="#">Help</a></li>
          		</ul>
         		<form class="navbar-form navbar-right">
            		<input type="text" class="form-control" placeholder="Search...">
          		</form>
        	</div>
      	</div>
    </nav>

    <div class="notMainNavBar" style="padding-top: 70px;">
	    <div class="col-md-2 padded">
	          <ul class="nav nav-pills nav-stacked">
	            <li class="active"><a href="#">Home</a></li>
	            <li class="dropdown">
	              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menu 1 <span class="caret"></span></a>
	              <ul class="dropdown-menu">
	                <li><a href="#">Submenu 1-1</a></li>
	                <li><a href="#">Submenu 1-2</a></li>
	                <li><a href="#">Submenu 1-3</a></li>                        
	              </ul>
	            </li>
	            <li><a href="#">Menu 2</a></li>
	            <li><a href="#">Menu 3</a></li>
	        </ul>
	    </div>

	    <div class="container padded">
	      	<div class="jumbotron">
	        	<h1>Welcome to the Dashboard!</h1>      
	        	<p>This is just a placeholder. There will be real content here soon.</p>      
	        	<a href="#" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-search"></span> Search</a>
	      	</div>
	    </div>
	</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  

<div id="global-zeroclipboard-html-bridge" class="global-zeroclipboard-container" style="position: absolute; left: 0px; top: -9999px; width: 15px; height: 15px; z-index: 999999999;" title="" data-original-title="Copy to clipboard">      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="global-zeroclipboard-flash-bridge" width="100%" height="100%">         <param name="movie" value="/assets/flash/ZeroClipboard.swf?noCache=1417722534887">         <param name="allowScriptAccess" value="sameDomain">         <param name="scale" value="exactfit">         <param name="loop" value="false">         <param name="menu" value="false">         <param name="quality" value="best">         <param name="bgcolor" value="#ffffff">         <param name="wmode" value="transparent">         <param name="flashvars" value="trustedOrigins=getbootstrap.com%2C%2F%2Fgetbootstrap.com%2Chttp%3A%2F%2Fgetbootstrap.com">         <embed src="/assets/flash/ZeroClipboard.swf?noCache=1417722534887" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="100%" height="100%" name="global-zeroclipboard-flash-bridge" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="trustedOrigins=getbootstrap.com%2C%2F%2Fgetbootstrap.com%2Chttp%3A%2F%2Fgetbootstrap.com" scale="exactfit">                </object></div><script id="hiddenlpsubmitdiv" style="display: none;"></script><script>try{for(var lastpass_iter=0; lastpass_iter < document.forms.length; lastpass_iter++){ var lastpass_f = document.forms[lastpass_iter]; if(typeof(lastpass_f.lpsubmitorig2)=="undefined"){ lastpass_f.lpsubmitorig2 = lastpass_f.submit; lastpass_f.submit = function(){ var form=this; var customEvent = document.createEvent("Event"); customEvent.initEvent("lpCustomEvent", true, true); var d = document.getElementById("hiddenlpsubmitdiv"); if (d) {for(var i = 0; i < document.forms.length; i++){ if(document.forms[i]==form){ d.innerText=i; } } d.dispatchEvent(customEvent); }form.lpsubmitorig2(); } } }}catch(e){}</script><svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200" preserveAspectRatio="none" style="visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs></defs><text x="0" y="10" style="font-weight:bold;font-size:10pt;font-family:Arial, Helvetica, Open Sans, sans-serif;dominant-baseline:middle">200x200</text></svg>
@stop
