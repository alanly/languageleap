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

function showShowsFooterTabs()
{
	$('#footer-seasons').attr("aria-hidden", false);
	$('#footer-seasons').css("display", "inline-block");
}

function hideShowsFooterTabs()
{
	$('#footer-seasons').attr("aria-hidden", true);
	$('#footer-seasons').css("display", "none");
}


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
//Adding cut at intervals
var cutAtDurations = [];
var segmentsCount = 0;
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
		if (currentType != "shows")
		{
			script = data.data.videos[0].script.text;
			$('#edit-script').empty().append(script);
			$('#footer-info').trigger( "click" );
		}
	});
	
	// if tvshow, populate seasons
	if (currentType == "shows")
	{
		populateSeasons();
	}

	resetCutVideos();
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
			console.log(data);
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
			console.log(data);
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
var videoSegments = [];
$('.modal-footer').on('click', 'span', function(event)
{
	var tagID = $(this).attr('id');
	$('#media-modal .modal-body').attr("aria-hidden", true);
	$('#media-modal .modal-body').css("display", "none");
	
	if (tagID == "footer-info")
	{
		$('.modal-body.info').attr("aria-hidden", false);
		$('.modal-body.info').css("display", "block");
	}
	else if (tagID == "footer-video-split")
	{
		$('.modal-body.video-split').attr("aria-hidden", false);
		$('.modal-body.video-split').css("display", "block");
	}
	else if (tagID == "footer-script")
	{
		$('.modal-body.script').attr("aria-hidden", false);
		$('.modal-body.script').css("display", "block");

		$.ajax(
		{
			type: "GET",
			url: '/api/metadata/movies/' + id,
			dataType: "json",
			success: function(data)
			{	
				for(var i = 0; i < data.data.videos.length; i++)
				{ 
					if(data.data.videos[i] != null)
					{
						console.log("Hello?");
						videoSegments.push(data.data.videos[i]);
						var li = $("<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"#\"></a></li>").text(" Video Segment " + (i+1));

						$('#video-segment-list').append(li);
					}
				}					
			}
		});
	}
	else if (tagID == "footer-seasons")
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

$('#button-edit-info-add').on("click", function()
{
	if($('#user_role_cut_at').is(':checked'))
	{
		var inputText = " From " 	+ pad($('#from-min').val(), 3) + ":"
									+ pad($('#from-sec').val(), 2) + " To "
					  				+ pad($('#to-min').val(), 3) + ":"
									+ pad($('#to-sec').val(), 2);

		var fromTime = ($('#from-min').val() != "") ? parseInt($('#from-min').val()) * 60 : 0;
		fromTime += ($('#from-sec').val() != "") ? parseInt($('#from-sec').val()) : 0;
		var toTime = ($('#to-min').val() != "") ? parseInt($('#to-min').val()) * 60 : 0;
		toTime += ($('#to-sec').val() != "") ? parseInt($('#to-sec').val()) : 0;
		var length = toTime - fromTime;

		if(length > 0)
		{
			var label = $("<label>").text(inputText);
			var minus = $("<span class=\"glyphicon glyphicon-minus remove-interval\" name=\""+ (segmentsCount+1) +"\"></span>");

			$('#segment-intervals').append(label);
			$('#segment-intervals').append(minus);
			$('#segment-intervals').append($("<br/>"));

			cutAtDurations.push({start: fromTime, duration: length});
			segmentsCount++;

			$('#from-min').val("");
			$('#from-sec').val("");
			$('#to-min').val("");
			$('#to-sec').val("");
		}
		else
			alert("Please enter a valid interval!");
	}
});

function pad(num, size) {
    var s = num+"";
    while (s.length < size) s = "0" + s;
    return s;
}

//Negative values not allowed while cutting
$('.time-field').attr("min", "0");

//Maximum number of 59 seconds and 999 minutes
var maxSeconds = 59;
var maxMinutes = 999;

$('#from-min').attr("max", maxMinutes);
$('#to-min').attr("max", maxMinutes);
$('#from-sec').attr("max", maxSeconds);
$('#to-sec').attr("max", maxSeconds);

//Removing intervals by clicking the minus
$(document).on('click', '.remove-interval', function() {
	cutAtDurations[parseInt($(this).attr("name")) - 1] = null;
    $(this).prev().remove();
    $(this).next().remove();
    $(this).remove();
});

function resetCutVideos()
{
	cutAtDurations = [];
	segmentsCount = 0;
	$('#from-min').val("");
	$('#from-sec').val("");
	$('#to-min').val("");
	$('#to-sec').val("");
	$('#segment-intervals').html("");
}

//Submitting video splitting info
$('#button-edit-info-done').on("click", function()
{
	var cutForm = $('#cut-form');
	var cutoffTimes = [];

	if($('#user_role_cut_by').is(':checked'))
	{
		var videoDuration = Math.round(videoPlayer.get(0).duration);
		var numberOfSegments = parseInt($('#segment-amount').val());
		var secondsPerSegment = videoDuration / numberOfSegments;

		var currentTime = 0;

		if(secondsPerSegment > 0)
		{
			while(currentTime < videoDuration)
			{
				cutoffTimes.push({start: currentTime, duration: secondsPerSegment});
				currentTime += secondsPerSegment;
			}		
		}
	}
	else if($('#user_role_cut_at').is(':checked'))
	{
		for(var i = 0; i < cutAtDurations.length; i++)
		{
			if(cutAtDurations[i] != null)
			{
				cutoffTimes.push(cutAtDurations[i]);
			}
		}
	}

	$.ajax(
	{
		type: "POST",
		url: '/api/videos/cut/segments',
		dataType: "json",
		data:
		{
			'video_id': id,
			'segments': cutoffTimes
		},
		success: function(data)
		{		
			resetCutVideos();
		}
	});
});