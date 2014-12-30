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
		  p = document.getElementById('script').innerHTML;
		  p = "<input type='text' name='script-text' value='" + p + "'/>";

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
$("#select-movies").click(function()
{
	$.getJSON("/api/metadata/movies/", function(data)
	{
			var s = "";
			
		  $.each(data.data, function(key, val)
			{
				var id = val.id;
				var name = val.name;
				console.log(key + " " + id + " " + name);
				s += '<span class="media" db-id="' + id + '">' + name + '</span>';
		  });
			
			$('#content').empty().append(s);
			//s.detach();
	});
});

$('#content').on('click', 'span.media', function(event)
{
	var id = $(this).attr('db-id');
	var name;
	var description;
	var director;
	var actor;
	var thumb = "http://ia.media-imdb.com/images/M/MV5BMTY5NTAzNTc1NF5BMl5BanBnXkFtZTYwNDY4MDc3._V1_SX640_SY720_.jpg";
	
	$.getJSON("/api/metadata/movies/" + id, function(data)
	{
		name = data.data.name;
		description = data.data.description;
		director = data.data.director;
		actor = data.data.actor;
		
		$('.modal-title').empty().append(name);
		$('.modal-image').attr("src", thumb);
		$('.modal-id').empty().append(id);
		$('.modal-name').empty().append(name);
		$('.modal-desc').empty().append(description);
		$('.modal-director').empty().append(director);
		$('.modal-actor').empty().append(actor);
		
		$('#media-modal').modal('show');
	});
});

$('.modal-footer').on('click', '.span2', function(event)
{
	var id = $(this).attr('id');
	$('.modal-body').attr("aria-hidden", true);
	$('.modal-body').css("display", "none");
	
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