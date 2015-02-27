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