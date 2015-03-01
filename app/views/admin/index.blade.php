@extends('admin.master')

@section('javascript')
<script type="text/javascript">

	function fillShowTable(showArray) {
		$('.content').html($('<table/>', {	class: 'table table-hover shows' }));

		addShowTableHeader();

		$.each(showArray, function(i, v) {
			addShowTableRow(v);
		});
	}

	function addShowTableHeader() {
		var header =	'<thead>' +
							'<tr>' +
								'<th>ID</th>' +
								'<th>Action</th>' +
								'<th>Name</th>' +
								'<th>Publish</th>' +
							'</tr>' +
						'</thead>';

		$('table.shows').append(header);
	}

	function addShowTableRow(show) {
		var row =	'<tr>' +
						'<td>' + show.id + '</td>' +
						'<td><a href="#"><i class="fa fa-edit fa-fw"></i></a><a href="#"><i class="fa fa-trash fa-fw"></i></a></td>' +
						'<td>' + show.name + '</td>' +
						'<td><input type="checkbox" checked /></td>' +
					'</tr>';

		$('table.shows').append(row);
	}

	function loadShowData() {
		$.ajax({
			type: 'GET',
			url: '/api/metadata/shows',
			success: function(data) {
				fillShowTable(data.data);
			}
		});
	}

	function loadUserInformation()
	{
		$.ajax({
			type : "GET",
			url : "/api/users",
			success : function(data)
			{
				
				var table = "<table class='table table-hover'>";
				//Table headers
				table += "<thead><tr>"
						+ "<th>ID</th>"
						+ "<th>Username</th>"
						+ "<th>Email</th>"
						+ "<th>First name</th>"
						+ "<th>Last name</th>"
						+ "<th>Active</th>"
						+ "</tr></thead>";

				$.each(data.data, function(index,value){
					//If the user is active or not.
					var checked = value.is_active == 1 ? "checked" : "";

					table += "<tr>"
						+ "<td>" + value.id + "</td>"
						+ "<td>" + value.username + "</td>"
						+ "<td>" + value.email + "</td>"
						+ "<td>" + value.first_name + "</td>"
						+ "<td>" + value.last_name + "</td>"
						+ "<td><input type='checkbox' onclick='toggleActiveStatus(" + value.id + ")' "+ checked + "/></td>"
						+ "</tr>";
				});

				table += "</table>";
				$(".content").html(table);
			}
		});
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
				'is_published' : $("#"+movie_id+"-movie-publish").is(":checked")
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

	$(function() {
		// Register click handlers
		$('.manage-shows').on('click', loadShowData);
	});
</script>
@stop

@section('content')
	<div class="content"></div>
@stop