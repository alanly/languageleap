/*
	toggles the add new media pulldown
*/
$("#button-add-new").click(function()
{
  $("#slidedown-add-new").slideToggle("slow", function()
	{
  });
});

/*
	step by step logic for uploading a new media file
*/
var step = 0;
$('#button-add-new-back').on("click", function()
{
	step--;
	refreshContent();
});
$('#button-add-new-next').on("click", function()
{
	step++;
	refreshContent();
});

function refreshContent()
{
	if (step == 0)
	{
		$('#add-new-header').empty().append("<h2>Media Info</h2>");
		
		// hide and show relevant panes
		$('#add-new-body-info').css("display", "block");
		$('#add-new-body-script').css("display", "none");
		
		// hide back button
		$('#button-add-new-back').css("display", "none");
	}
	else if (step == 1)
	{
		$('#add-new-header').empty().append("<h2>Edit Script</h2>");
		$('#button-add-new-next').empty().append("Next");
				
		// hide and show relevant panes
		$('#add-new-body-info').css("display", "none");
		$('#add-new-body-script').css("display", "block");
		$('#add-new-body-media').css("display", "none");

		// show back button
		$('#button-add-new-back').css("display", "block");
	}
	else if (step == 2)
	{
		$('#add-new-header').empty().append("<h2>Upload Media</h2>");
		$('#button-add-new-next').empty().append("Upload");
		
		// hide and show relevant panes
		$('#add-new-body-script').css("display", "none");
		$('#add-new-body-media').css("display", "block");
		
		// show submit button, hide next button
		//$('#button-add-new-next').css("display", "none");
		//$('#button-add-new-submit').css("display", "block");
	}
	else if (step >= 3)
	{
		if ($('#file').val() != '')
		{
		  var p = '';
		  //p = $('#text').text();
		  p =	document.getElementById('add-script').innerHTML,
		  p = "<input type='text' name='text' value='" + p + "'/>";

			// append script to form for post
		  $('#new-media-form').append(p);
		  document.getElementById("new-media-form").submit();

			// add loading bar here
			$('#add-new-header').empty().append("<h2>Uploading...</h2>");
			$('#button-add-new-next').attr('disabled', 'disabled');
		
			// hide and show relevant panes
			$('#add-new-body-media').css("display", "none");
			$('#add-new-body-upload').css("display", "block");
		}
	}
	return false;
}

/*
	show/hide form based on which media type is checked
*/
$('#info-commercial-radio').on("click", function()
{
	$('#info-extra-tab').css("display", "none");
});

$('#info-tvshow-radio').on("click", function()
{
	$('#info-extra-tab').css("display", "block");
});

$('#info-movie-radio').on("click", function()
{
	$('#info-extra-tab').css("display", "block");
});

/*
	shows media based on selected category
*/
var currentType;
$("#select-movies").click(function()
{
	currentType = "movies";
	$.getJSON("/api/metadata/movies/", function(data)
	{
		buildList(data);
	});
});
$("#select-commercials").click(function()
{
	currentType = "commercials";
	$.getJSON("/api/metadata/commercials/", function(data)
	{
		buildList(data);
	});
});
$("#select-shows").click(function()
{
	currentType = "shows";
	$.getJSON("/api/metadata/shows/", function(data)
	{
		buildList(data);
	});
});

function buildList(data)
{
	var s = "";
	
  $.each(data.data, function(key, val)
	{
		var id = val.id;
		var name = val.name;
		//console.log(key + " " + id + " " + name);
		s += '<span class="media" db-id="' + id + '">' + name + '</span>';
  });
	
	$('#content').empty().append(s);
	//s.detach();
}

/*
	when a media title is clicked in the browser, refresh all values in the forms to reflect the clicked media
*/
var id;
$('#content').on('click', 'span.media', function(event)
{
	id = $(this).attr('db-id');
	var name;
	var description;
	var director;
	var actor;
	var thumb = "";
	
	// get metadata for specified media
	$.getJSON("/api/metadata/" + currentType + "/" + id, function(data)
	{
		//info view
		name = data.data.name;
		description = data.data.description;
		director = data.data.director;
		actor = data.data.actor;
		
		$('.edit-media-title').empty().append(name);
		$('.modal-image').attr("src", thumb);
		$('.modal-id').empty().append(id);
		$('#edit-media-info-name').val(name);
		$('#edit-media-info-description').val(description);
		$('#edit-media-info-director').val(director);
		$('#edit-media-info-actor').val(actor);
		
		$('#media-modal').modal('show');
		
		//script view
		script = data.data.videos[0].script.text;
		$('#edit-script').empty().append(script);
		$('#footer-info').trigger( "click" );
	});
});

/*
	save edited info
*/
$('#button-edit-info-save').on("click", function()
{
	$('#button-edit-info-save').prop("disabled", true);
	$('#button-edit-info-save').html("Saving...");
	
	$.ajax(
	{
		type: "POST",
		url: "/api/metadata/" + currentType + "/" + id,
		data:
		{
			name: $('#edit-media-info-name').val(),
			description: $('#edit-media-info-description').val(),
			director: $('#edit-media-info-director').val(),
			actor: $('#edit-media-info-actor').val(),
			level: $('#edit-media-info-level').val(),
			_method: "PATCH"
		},
		success: function(data)
		{
			console.log(data);
			$('#edit-script').prop("disabled", false);
			$('#button-edit-info-save').prop("disabled", false);
			$('#button-edit-info-save').html("Save");
		}
	});
});

/*
	save edited script
*/
$('#button-edit-script-save').on("click", function()
{
	$('#edit-script').css("opacity", 0.5);
	$('#button-edit-script-save').prop("disabled", true);
	$('#button-edit-script-save').html("Saving...");
	
	$.ajax(
	{
		type: "POST",
		url: "/api/metadata/" + currentType + "/update-script/" + id,
		data:
		{
			text: document.getElementById('edit-script').innerHTML,
			_method: "PATCH"
		},
		success: function(data)
		{
			console.log(data);
			$('#edit-script').css("opacity", 1);
			$('#button-edit-script-save').prop("disabled", false);
			$('#button-edit-script-save').html("Save");
		}
	});
});

/*
	footer tab was clicked, switch tabs
*/
$('.modal-footer').on('click', 'span', function(event)
{
	var id = $(this).attr('id');
	$('#media-modal .modal-body').attr("aria-hidden", true);
	$('#media-modal .modal-body').css("display", "none");
	
	if (id == "footer-info")
	{
		$('.modal-body.info').attr("aria-hidden", false);
		$('.modal-body.info').css("display", "block");
	}
	else if (id == "footer-script")
	{
		$('.modal-body.script').attr("aria-hidden", false);
		$('.modal-body.script').css("display", "block");
	}
});
