<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Language Leap</title>

		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="/css/layout.css">

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		
		<script type='text/JavaScript'>
			$.widget.bridge('uitooltip', $.ui.tooltip); //Resolve name collision between jQuery UI and Twitter Bootstrap
		</script>
		
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/js/bootstrap.min.js"></script>

		@yield('javascript')

		@yield('head')
	</head>

	<body>
		<div id="navbar">
			<nav class="navbar navbar-default">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-buttons">
						</button>
						<a class="navbar-brand" href="/" style="text-decoration: none;">@lang('navbar.brand')</a>
					</div>
					<div class="collapse navbar-collapse" id="navbar-buttons">
						<ul class="nav navbar-nav navbar-right">
							@if (Auth::check())
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="text-decoration: none;">
										@lang('navbar.buttons.quiz-reminder.name')
										<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li class="text-center" id="quiz-link">@lang('navbar.buttons.quiz-reminder.none')</li>
									</ul>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="text-decoration: none;">
									<span class="account glyphicon glyphicon-user"></span>
										@lang('navbar.buttons.account.name')
									<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#" role="menu-item">@lang('navbar.buttons.account.profile')</a></li>
										<li><a href="#" role="menu-item">@lang('navbar.buttons.account.settings')</a></li>
										<li><a href="{{ URL::to('user/wordBank') }}" role="menu-item">@lang('navbar.buttons.account.review')</a></li>
										<li class="divider"></li>
										<li><a href="{{ URL::to('logout') }}" role="menu-item">Logout</a></li>
									</ul>
								</li>
							@else
								<li class="sign-up">
									<a href="{{ URL::to('register') }}" role="button" aria-expanded="false" style="text-decoration: none;">
									Sign Up
									</a>
								</li>
								<li class="login">
									<a href="{{ URL::to('login') }}" role="button" aria-expanded="false" style="text-decoration: none;">
									Login
									</a>
								</li>
							@endif
						</ul>
					</div> <!-- / .navbar-collapse -->
				</div> <!-- / .container-fluid -->
			</nav>
		</div>
		@yield('content')
		<script>
			function loadQuizReminder() {
				$.ajax({
					type: "GET",
					url: "/api/quiz/reminder",
					success: function(data) {
						var quiz_id = data.data.quiz_id;

						if(quiz_id > 0)
						{
							// Store data in the HTML5 Storage schema
							localStorage.setItem("quizPrerequisites", JSON.stringify({'quiz_id': data.data.quiz_id}));
								
							$("#quiz-link").html('<a href="quiz"><span class="glyphicon glyphicon-pencil" aria-hidden="true">@lang("navbar.buttons.quiz-reminder.attempt")</span></a>');
						}
					},
				});
			}

			$(function() {
				@if (Auth::check())
					loadQuizReminder();
				@endif
			});
		</script>
	</body>
</html>
