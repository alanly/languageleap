function commercialsClick()
{
	disableExtraTabs();
	accordion.next();
	setTabName("firstTab", "commercials");
	setTabName("secondTab", "Select Commercial");

	$("#secondTab").removeClass("disabled");

	fetchMedia();
}

function moviesClick()
{
	disableExtraTabs();
	accordion.next();
	setTabName("firstTab", "movies");
	setTabName("secondTab", "Select Movie");

	$("#secondTab").removeClass("disabled");

	fetchMedia();
}

function seriesClick()
{
	enableExtraTabs();
	accordion.next();
	setTabName("firstTab", "series");
	setTabName("secondTab", "Select Series");
	setTabName("thirdTab", "Select Season");
	setTabName("fourthTab", "Select Episode");

	accordion.bindClicker(1);
	$("#secondTab").removeClass("disabled");

	fetchSeries();
}

function fetchMedia()
{

}

function fetchSeries()
{
	$.getJSON( "/api/metadata/shows", function(data) 
	{
		var json = data.data;
		var content = "";
		$.each(json, function(index, value)
		{ 
			var genre = getString(value.genre);
			var actors = getString(value.actor);
			var director = getString(value.director);
			var altImage = getString(value.description);

			content += '<li ';
			content += 'id="' + value.id +  '" ';
			content += 'data-genre="' + genre + '" ';
			content += 'data-main-actors="' + actors + '" ';
			content += 'data-director="' + director + '" ';
			content += '>';

			content += '<strong>' + value.name + '</strong>';

			content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + altImage + '">';

			content += '<span>Genre: <i>' + genre + '</i></span>';
			content += '<span>Actors: <i>' + actors + '</i></span>';
			content += '<span>Director: <i>' + director + '</i></span>';
			content += '</li>';
		});

		$("#container").html(content);
	});
}

function disableExtraTabs()
{
	$("#thirdTab").addClass("disabled");
	$("#fourthTab").addClass("disabled");

	setTabName("thirdTab", "");
	setTabName("fourthTab", "");

	disableClickableTabs();
}

function enableExtraTabs()
{
	$("#thirdTab").removeClass("disabled");
	$("#fourthTab").removeClass("disabled");

	enableClickableTabs();

}

function setTabName(tabId, name)
{
	$("#" + tabId).html();
	$("#" + tabId).text(name);
}

function disableAllTabs()
{
	$("#secondTab").addClass("disabled");
	$("#thirdTab").addClass("disabled");
	$("#fourthTab").addClass("disabled");

	accordion.unbindClicker(1);
	accordion.unbindClicker(2);
	accordion.unbindClicker(3);
}

function enableClickableTabs()
{
	accordion.bindClicker(2);
	accordion.bindClicker(3);
}

function disableClickableTabs()
{
	accordion.unbindClicker(2);
	accordion.unbindClicker(3);
}

function toTitleCase(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

function getString(str)
{
	if(str == null)
	{
		return "N/A";
	}

	return toTitleCase(str);
}