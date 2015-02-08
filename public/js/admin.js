/*
	toggles the add new media pulldown
*/
$("#button-add-new").click(function()
{
	$("#slidedown-add-new").slideToggle("slow");
});

/*
	step by step logic for uploading a new media file
*/
var step = 0;
$('#button-add-new-back').on("click", function()
{
	if (step >= 0)
	{
		step--;
		refreshContent();
	}
});
$('#button-add-new-next').on("click", function()
{
	if ($('#new-media-form')[0].checkValidity())
	{
		step++;
		refreshContent();
	}
	else
	{
		$('<input type="submit">').hide().appendTo('#new-media-form').click().remove();
	}

});

/*
 * refreshes content in add media pane
 */
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
			var p = "";
			p = getScriptText();
			p = "<input type='text' name='text' value='" + p + "' style='display: none;'/>";
			// append script to form for post
			$('#new-media-form').append(p);
			//document.getElementById("new-media-form").submit();
			
			var xhr = null;
			var form = $("#new-media-form");
      var formData = new FormData(form[0]);
      xhr = $.ajax({
          type: "POST",
          url: "/api/videos/",
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          xhr: function() {
              myXhr = $.ajaxSettings.xhr();
              if (myXhr.upload) myXhr.upload.addEventListener('progress', uploadProgressHandler, false);
              return myXhr;
          }
      }).done(function(data, status, xhr) {
          $("#add-new-body-upload").html(
						"Upload complete! Redirecting..."
          );
          ($("#new-media-form")[0]).reset();
					setTimeout("location.href = './admin';", 4000);
      }).fail(function(xhr, status, error) {
          $("#add-new-body-upload").html(
              "Upload failed, please try again. Reason: " + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>"
          );
					setTimeout("location.href = './admin';", 4000);
      });

			$('#add-new-header').empty().append("<h2>Uploading...</h2>");
			$('#button-add-new-back').attr('disabled', 'disabled');
			$('#button-add-new-next').attr('disabled', 'disabled');
		
			// hide and show relevant panes
			$('#add-new-body-media').css("display", "none");
			$('#add-new-body-upload').css("display", "block");
		}
	}
	return false;
}

/*
 * handles ajax file upload progress
 */
function uploadProgressHandler(e)
{
     if (! e.lengthComputable) return;
     var loaded          = e.loaded,
         total           = e.total,
         percentComplete = parseInt((loaded / total) * 100),
         cssWidth        = percentComplete + "%";
				 
     $("#add-new-body-upload").css("width", cssWidth);
     $("#add-new-body-upload").html(cssWidth);
 }

/*
	show/hide form based on which media type is checked
*/
$('#info-commercial-radio').on("click", function()
{
	$('#info-extra-tab').css("display", "none");
	$('#info-episodes-tab').css("display", "none");
});

$('#info-tvshow-radio').on("click", function()
{
	$('#info-extra-tab').css("display", "block");
	$('#info-episodes-tab').css("display", "block");
});

$('#info-movie-radio').on("click", function()
{
	$('#info-extra-tab').css("display", "block");
	$('#info-episodes-tab').css("display", "none");
});

/*
	shows media based on selected category
*/
var currentType;
$("#select-movies").click(function()
{
	currentType = "movies";
	hideShowsFooterTabs();
	
	$.getJSON("/api/metadata/movies/", function(data)
	{
		buildList(data);
	});
});

$("#select-commercials").click(function()
{
	currentType = "commercials";
	hideShowsFooterTabs();
	
	$.getJSON("/api/metadata/commercials/", function(data)
	{
		buildList(data);
	});
});

$("#select-shows").click(function()
{
	currentType = "shows";
	showShowsFooterTabs();
	
	$.getJSON("/api/metadata/shows/", function(data)
	{
		buildList(data);
	});
});

/*
 * shows the footer tabs
 */
function showShowsFooterTabs()
{
	$('#footer-seasons').attr("aria-hidden", false);
	$('#footer-seasons').css("display", "inline-block");
}

/*
 * hides the footer tabs
 */
function hideShowsFooterTabs()
{
	$('#footer-seasons').attr("aria-hidden", true);
	$('#footer-seasons').css("display", "none");
}

/*
 * builds a list of all media given a specific array of data
 */
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
		
		if (currentType != "shows")
		{
			//script view
			script = data.data.videos[0].script.text;
			$('#edit-script').empty().append(script);
			$('#footer-info').trigger( "click" );
						
			// timestamp view
			timestamps = data.data.videos[0].timestamps_json;
			timestamps = JSON.parse(timestamps);
			$('#timestamp-list').empty();
			for (i = 0; i < timestamps.length; i++)
			{
				s = '<li id="timestamp-row-' + i + '"><input type="text" pattern="([0-9]{1}):[0-5]{1}[0-9]{1}"  class="" placeholder="" style="width: 100px;" value="' + timestamps[i].from + '" required /> &#8594; <input type="text" pattern="([0-9]{1}):[0-5]{1}[0-9]{1}"  class="" placeholder="" style="width: 100px;" value="' + timestamps[i+1].to + '" required />';
				
				if (i > 0)
				{
					s += ' <i data-id="' + i + '" class="fa fa-times timestamp-close"></i></li>';
				}
				
				$('#timestamp-list').append(s);
			
				i++;
			}
		}		
		//console.log(timestamps);

		// should update the video being displayed here
	});
	
	// if tvshow, populate seasons
	if (currentType == "shows")
	{
		populateSeasons();
	}
	
});

/*
 * populate seasons dropdown
 */
function populateSeasons()
{
	$.getJSON("/api/metadata/" + currentType + "/" + id + "/seasons", function(data)
	{
		seasons = data.data.seasons;
	
		s = "<option disabled selected>Select a season...</option>";
		for (i = 0; i < seasons.length; i++)
		{
			s += '<option value="' + seasons[i].id + '">' + seasons[i].number + '</option>';
		}
	
		$('#edit-media-info-seasons').empty().append(s);

	});
}

/*
 * populate episodes dropdown
 */
function populateEpisodes()
{
	season_id = $('#edit-media-info-seasons').val();
		
	$.getJSON("/api/metadata/" + currentType + "/" + id + "/seasons/" + season_id + "/episodes", function(data)
	{
		episodes = data.data.episodes;
	
		s = "<option disabled selected>Select an episode...</option>";
		for (i = 0; i < episodes.length; i++)
		{
			s += '<option value="' + episodes[i].id + '">' + episodes[i].number + '</option>';
		}
	
		$('#edit-media-info-episodes').empty().append(s);

	});
}

/*
	onchange seasons dropdown
*/
$('#edit-media-info-seasons').change(function()
{
	$('#add-episode').prop("disabled", false);
	populateEpisodes();
	
});

/*
	onchange episodes dropdown
*/
var currentEpisode = -1;
$('#edit-media-info-episodes').change(function()
{
	
	episode_id = $('#edit-media-info-episodes').val();
	currentEpisode = episode_id;
	video_id = -1;
	$.getJSON("/api/metadata/" + currentType + "/" + id + "/seasons/" + season_id + "/episodes/" + episode_id, function(data)
	{
		name = data.data.episode.name;
		description = data.data.episode.description;
		video_id = data.data.videos[0].id;

		$('#edit-media-info-episode-name').val(name);
		$('#edit-media-info-episode-description').val(description);
		
		$.getJSON("/content/scripts/" + video_id, function(data)
		{
			script = data.data[0].text;
			$('#edit-script').empty().append(script);
		});
		
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
			//console.log(data);
			$('#edit-script').prop("disabled", false);
			$('#button-edit-info-save').prop("disabled", false);
			$('#button-edit-info-save').html("Save");
		}
	});
});

/*
	save edited episode info
*/
$('#button-edit-episode-save').on("click", function()
{
	$('#button-edit-episode-save').prop("disabled", true);
	$('#button-edit-episode-save').html("Saving...");
	
	$.ajax(
	{
		type: "POST",
		url: "/api/metadata/" + currentType + "/" + id + "/seasons/" + season_id + "/episodes/" + episode_id,
		data:
		{
			name: $('#edit-media-info-episode-name').val(),
			description: $('#edit-media-info-episode-description').val(),
			_method: "PATCH"
		},
		success: function(data)
		{
			//console.log(data);
			$('#edit-script').prop("disabled", false);
			$('#button-edit-episode-save').prop("disabled", false);
			$('#button-edit-episode-save').html("Save");
		}
	});
});

/*
	add new season
*/
$('#add-season').on("click", function()
{
	$.ajax(
	{
		type: "POST",
		url: "/api/metadata/shows/" + id + "/seasons/",
		beforeSend: function(request) {
			return request.setRequestHeader('X-CSRF-Token', $("meta[name='token']").attr('content'));
		},
		data:
		{
			number: $('#add-new-season').val(),
		},
		success: function(data)
		{
			populateSeasons();
		}
	});
});

/*
	add new episode
*/
$('#add-episode').on("click", function()
{
	season_id = $('#edit-media-info-seasons').val();
	
	$.ajax(
	{
		type: "POST",
		url: "/api/metadata/shows/" + id + "/seasons/" + season_id + "/episodes/",
		data:
		{
			number: $('#add-new-episode').val(),
			name: $('#edit-media-info-episode-name').val(),
			description: $('#edit-media-info-episode-description').val(),
			level: 19,
		},
		success: function(data)
		{
			populateEpisodes();
		},
		complete: function(data)
		{
			console.log(data);
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
			episode: currentEpisode,
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
	else if (id == "footer-media")
	{
		$('.modal-body.media').attr("aria-hidden", false);
		$('.modal-body.media').css("display", "block");
	}
	else if (id == "footer-seasons")
	{
		$('.modal-body.seasons').attr("aria-hidden", false);
		$('.modal-body.seasons').css("display", "block");
	}
});

/*
 * opt in for popovers
 */
$(function()
{
	$('[rel=popover]').popover(
	{ 
		html : true, 
		content: function()
		{
			return $('#popover-new-season-inner').html();
		}
	});
});

/*
 * set up csrf protection token
 */
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});


/*
	add and edit timestamps
*/
var timestamp_id = 2;
$('#timestamp-add').on("click", function()
{
	$('#timestamp-list').append('<li id="timestamp-row-' + timestamp_id + '"><input type="text" pattern="([0-9]{1}):[0-5]{1}[0-9]{1}" class="" placeholder="" style="width: 100px;" required /> &#8594; <input type="text" pattern="([0-9]{1}):[0-5]{1}[0-9]{1}" class="" placeholder="" style="width: 100px;" required /> <i data-id="' + timestamp_id + '" class="fa fa-times timestamp-close"></i></li>');
	
	timestamp_id++;
});

$(document).on("click", '.timestamp-close', function(event)
{
	var id = event.target.getAttribute('data-id');
	$('#timestamp-row-' + id).remove();
});

$(document).on("click", '#button-edit-timestamp-save', function(event)
{
	if ($('#edit-timestamps-form')[0].checkValidity())
		saveTimestamps();
});

/*
 * save timestamps
 */
function saveTimestamps()
{
	var spans = $('#timestamp-list input[type=text]');

	var json = '[';
	var i = 0;
	spans.each(function()
	{
		if (i % 2 == 0)
	    json += '{"from":"' + $(this).val() + '"},';
		else
			json += '{"to":"' + $(this).val() + '"},';
		
		i++;
	});
	json = json.substring(0, json.length - 1);
	json += ']';
	//console.log(JSON.parse(json));

	$.ajax(
	{
		type: 'POST',
		url: "/api/metadata/" + currentType + "/save-timestamps/" + id,
		data: {
			text: json,
			_method: "PATCH"
		},
		success: function(data)
		{
			if (data.status == 'success')
			{
				console.log('Timestamps saved.');
			}
		},error: function(data)
		{

				console.log(data);

		},
	});
	
}