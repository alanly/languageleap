@extends('admin.master')

@section('javascript')
<script type="text/javascript">

	function loadUserInformation()
	{
		$.ajax({
			type : "GET",
			url : "/api/users",
			success : function(data)
			{
				
				$('.content').html($('<table/>', {	class: 'table table-hover users' }));

				//Table headers
				var headers = "<thead><tr>"
						+ "<th>ID</th>"
						+ "<th>Username</th>"
						+ "<th>Email</th>"
						+ "<th>First name</th>"
						+ "<th>Last name</th>"
						+ "<th>Active</th>"
						+ "</tr></thead>";

				$(".movies").append(headers);

				$.each(data.data, function(index,value){
					//If the user is active or not.
					addUserRow(value);
				});
			}
		});
	}

	function addUserRow(user)
	{

			var checked = user.is_active == 1 ? "checked" : "";

			var user_item = "<tr>"
						+ "<td>" + user.id + "</td>"
						+ "<td>" + user.username + "</td>"
						+ "<td>" + user.email + "</td>"
						+ "<td>" + user.first_name + "</td>"
						+ "<td>" + user.last_name + "</td>"
						+ "<td><input type='checkbox' onclick='toggleActiveStatus(" + user.id + ")' "+ checked + "/></td>"
						+ "</tr>";
			$(".users").append(user_item);
	}

	function loadMovies()
	{
		$.ajax({
			type : "GET",
			url : "/api/metadata/movies",
			success : function(data)
			{

				$('.content').html($('<table/>', {	class: 'table table-hover movies' }));

				//Table headers
				var header = "<thead><tr>"
						+ "<th>ID</th>"
						+ "<th>Actions</th>"
						+ "<th>Name</th>"
						+ "<th>Publish</th>"
						+ "</tr></thead>";

				$(".movies").append(header);

				$.each(data.data, function(index,value){
					addMovieRow(value);
				});	
			}
		});
	}

	function addMovieRow(movie)
	{
		//If the movie is active or not.
		var checked = movie.is_published == 1 ? "checked" : "";

		var row = "<tr id='" + movie.id + "-movie''>"
				+ "<td>" + movie.id + "</td>"
				+ "<td><a href='#' onclick='loadMovieInformation(" + movie.id + ");'><i class='fa fa-edit fa-fw'></i></a><a href='#'><i class='fa fa-trash fa-fw'></i></a></td>"
				+ "<td>" + movie.name + "</td>"
				+ "<td><input id='" + movie.id + "-movie-publish'type='checkbox' onclick='publishMovie(" + movie.id + ")'" + checked + " /></td>"
				+ "</tr>";

		$(".movies").append(row);	
	}

	function publishMovie(movie_id)
	{
		$.ajax({
			type : "PUT",
			url : "/api/metadata/movies/" + movie_id,
			data : {
				'is_published' : ($("#"+movie_id+"-movie-publish").is(":checked") ? 1 : 0)
			}
		});	
	}

	function toggleActiveStatus(user_id)
	{
		$.ajax({
			type : "POST",
			url : "/admin/user",
			data : {
				'user_id' : user_id
			}
		});
	}

	function loadMovieInformation(movie_id)
	{	
		$.ajax({
			type : "GET",
			url : "/api/metadata/movies/" + movie_id,
			dataType : "JSON",
			success : function(data)
			{
				$("#" + movie_id + "-movie").after("<div><p>TEST</p></div>")
			}
		});	
	}
</script>
@stop

@section('content')
	<div class="content"></div>
@stop