@extends('admin.master')

@section('javascript')
<script type="text/javascript">
	$(document).ready(function(){
		loadUserInformation(); //testing
	});


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
						+ "<th>Active</th>"
						+ "</tr></thead>";

				$.each(data.data, function(index,value){
					//If the user is active or not.
					var checked = value.is_active == 1 ? "checked" : "";

					table += "<tr>"
						+ "<td>" + value.id + "</td>"
						+ "<td>" + value.username + "</td>"
						+ "<td>" + value.email + "</td>"
						+ "<td><input type='checkbox' "+ checked + "/></td>"
						+ "</tr>";
				});

				table += "</table>";
				$(".content").html(table);
			},
			error : function(data)
			{

			}
		});
	}

</script>
@stop

@section('content')
	<div class="content">

	</div>
@stop