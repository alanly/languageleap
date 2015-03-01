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

	function loadMovieInformation()
	{
		$.ajax({
			type : "GET",
			url : "/api/metadata/movies",
			success : function(data)
			{
				var table = "<table class='table table-hover'>";
				//Table headers
				table += "<thead><tr>"
						+ "<th>ID</th>"
						+ "<th>Actions</th>"
						+ "<th>Name</th>"
						+ "<th>Publish</th>"
						+ "</tr></thead>";

				$.each(data.data, function(index,value){
					//If the user is active or not.
					var checked = value.is_published == 1 ? "checked" : "";

					table += "<tr>"
						+ "<td>" + value.id + "</td>"
						+ "<td><a href='#'><i class='fa fa-edit fa-fw'></i></a><a href='#'><i class='fa fa-trash fa-fw'></i></a></td>"
						+ "<td>" + value.name + "</td>"
						+ "<td><input id='" + value.id + "-movie-publish'type='checkbox' onclick='publishMovie(" + value.id + ")'" + checked + " /></td>"
						+ "</tr>";
				});

				table += "</table>";
				$(".content").html(table);	
			}
		});
	}

	function publishMovie(movie_id)
	{
		var publish = 0;
		
		if($("#"+movie_id+"-movie-publish").is(":checked"))
		{
			publish = 1;
		}

		$.ajax({
			type : "PUT",
			url : "/api/metadata/movies/" + movie_id,
			data : {
				'is_published' : publish
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
</script>
@stop

@section('content')
	<div class="content"></div>
@stop