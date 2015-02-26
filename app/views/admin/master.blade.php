<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic|Raleway:200,500,600">
    <link rel="stylesheet" href="css/main.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('javascript')

	@yield('head')
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
            <li class="active"><a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bullhorn fa-fw"></i> Manage</a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-film fa-fw"></i> Manage Videos</a></li>
                <li><a href="#"><i class="fa fa-file-text-o fa-fw"></i> Manage Scripts</a></li>
                <li><a href="#"><i class="fa fa-users fa-fw"></i> Manage Users</a></li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-road fa-fw"></i> Client Side</a></li>
            <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Sign Out</a></li>
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
            <li><a href="#"><i class="fa fa-film fa-fw"></i>@lang('admin.index.menu.videos')</a></li>
            <li><a href="#"><i class="fa fa-file-text-o fa-fw"></i> @lang('admin.index.menu.scripts')</a></li>
            <li><a href="#"><i class="fa fa-users fa-fw"></i> @lang('admin.index.menu.users')</a></li>
          </ul>

          <ul class="nav nav-sidebar">
            <li><a href="#"><i class="fa fa-road fa-fw"></i> @lang('admin.index.menu.client')</a></li>
            <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> @lang('admin.index.menu.logout')</a></li>
          </ul>
        </nav>

        <!-- Page Container -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">@lang('admin.index.menu.dashboard')</h1>
          <p>Here can be stats relevant to the administrator. (i.e. number of new users, active accounts, etc.)</p>

          @yield('content')
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </body>
</html>