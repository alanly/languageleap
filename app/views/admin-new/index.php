<!DOCTYPE html>
<html lang="en" ng-app="adminApp">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic|Raleway:200,500,600">
	<link rel="stylesheet" href="/css/admin-script.css">

	<script src="https://code.angularjs.org/1.3.0/angular.min.js"></script>
	<script src="https://code.angularjs.org/1.3.0/angular-route.min.js"></script>
	<script src="https://code.angularjs.org/1.3.0/angular-resource.min.js"></script>

	<!-- adminApp Angular Imports -->
	<script src="/js/admin/app.js"></script>
	<script src="/js/admin/routes.js"></script>
	<script src="/js/admin/directives/common.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.11.2/ui-bootstrap-tpls.min.js"></script>
	<script src="/js/admin/controllers/commercial/CommercialController.js"></script>
	<script src="/js/admin/controllers/movie/MovieController.js"></script>
	<script src="/js/admin/controllers/show/ShowController.js"></script>
	<script src="/js/admin/controllers/user/UserController.js"></script>

	<link rel="stylesheet" href="/css/main.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<title>LanguageLeap - Admin</title>
</head>
<body>
	<!-- Navbar Container -->
	<nav class="navbar navbar-static-top navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars fa-fw"></i>
				</button>

				<span class="navbar-brand"><i class="fa fa-language"></i></span>
			</div>

			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav">
						<li>
							<a href="javascript:;" data-target="#m-media-types" data-toggle="collapse" data-parent="#m-media-types"><i class="fa fa-film fa-fw"></i> <?php echo Lang::get('admin.index.menu.videos'); ?></a>
							<div class="collapse list-group-submenu list-group-submenu-1" id="m-media-types">
								<a href="#/movies" class="list-group-item"> <?php echo Lang::get('admin.media.movie.name'); ?></a>
								<a href="#/commercials" class="list-group-item"> <?php echo Lang::get('admin.media.commercial.name'); ?></a>
								<a href="#/shows" class="list-group-item manage-shows"> <?php echo Lang::get('admin.media.show.name'); ?></a>
							</div>
						</li>
						<li><a href="#"><i class="fa fa-file-text-o fa-fw"></i> <?php echo Lang::get('admin.index.menu.scripts'); ?></a></li>
						<li><a href="#/users"><i class="fa fa-users fa-fw"></i> <?php echo Lang::get('admin.index.menu.users'); ?></a></li>
						<li><a href="/"><i class="fa fa-road fa-fw"></i> <?php echo Lang::get('admin.index.menu.client'); ?></a></li>
						<li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> <?php echo Lang::get('admin.index.menu.logout'); ?></a></li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Primary App Container -->
	<div class="container-fluid">
		<div class="row">
			<!-- Sidebar -->
			<nav class="col-sm-3 col-md-2 sidebar">
				<!-- Sidebar Branding -->
				<div class="brand-sidebar">
					<i class="fa fa-language"></i>
				</div>

				<!-- Navigation Menu -->
				<ul class="nav nav-sidebar">
					<li class="active"><a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
				</ul>

				<ul class="nav nav-sidebar">
					<li>
						<a href="javascript:;" data-target="#media-types" data-toggle="collapse" data-parent="#media-types"><i class="fa fa-film fa-fw"></i> <?php echo Lang::get('admin.index.menu.videos'); ?></a>
						<div class="collapse list-group-submenu list-group-submenu-1" id="media-types">
							<a href="#/movies" class="list-group-item"> <?php echo Lang::get('admin.media.movie.name'); ?></a>
							<a href="#/commercials" class="list-group-item"> <?php echo Lang::get('admin.media.commercial.name'); ?></a>
							<a href="#/shows" class="list-group-item manage-shows"> <?php echo Lang::get('admin.media.show.name'); ?></a>
						</div>
					</li>

					<li><a href="#"><i class="fa fa-file-text-o fa-fw"></i> <?php echo Lang::get('admin.index.menu.scripts'); ?></a></li>
					<li><a href="#/users"><i class="fa fa-users fa-fw"></i> <?php echo Lang::get('admin.index.menu.users'); ?></a></li>
				</ul>

				<ul class="nav nav-sidebar">
					<li><a href="/"><i class="fa fa-road fa-fw"></i> <?php echo Lang::get('admin.index.menu.client'); ?></a></li>
					<li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> <?php echo Lang::get('admin.index.menu.logout'); ?></a></li>
				</ul>
			</nav>

			<!-- Page Container -->
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<div ng-view></div>
			</div>
		</div>
	</div>
</body>
</html>
