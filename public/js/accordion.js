function commercialsClick()
{
	disableExtraTabs();
	accordion.next();
	setTabName("firstTab", "commercials");
	setTabName("secondTab", "Select Commercial");

	$("#secondTab").removeClass("disabled");

	fetchCommercials();
}

function moviesClick()
{
	disableExtraTabs();
	accordion.next();
	setTabName("firstTab", "movies");
	setTabName("secondTab", "Select Movie");

	$("#secondTab").removeClass("disabled");

	fetchMovies();
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

function fetchCommercials()
{
	$.getJSON( "/api/metadata/commercials", function(data) 
	{
		var json = data.data;
		var content = "";
		$.each(json, function(index, value)
		{ 
			var name = getString(value.name);
			var description = getString(value.description);

			content += '<li ';
			content += 'id="' + value.id +  '" ';
			content += '>';

			content += '<strong>' + name + '</strong>';

			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';

			content += '<span>Description: <i>' + description + '</i></span>';
			content += '</li>';
		});

		$("#container").html(content);
	});
}

function fetchMovies()
{
	$.getJSON( "/api/metadata/movies", function(data) 
	{
		var json = data.data;
		var content = "";
		$.each(json, function(index, value)
		{ 
			var name = getString(value.name);
			var genre = getString(value.genre);
			var actor = getString(value.actor);
			var director = getString(value.director);
			var description = getString(value.description);

			content += createLiData(value.id, genre, actor, director);

			content += '<strong>' + name + '</strong>';

			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';

			content += createSpanData(description, genre, actor, director);

			content += '</li>';
		});

		$("#container").html(content);
	});
}

function fetchSeries()
{
	$.getJSON( "/api/metadata/shows", function(data) 
	{
		var json = data.data;
		var content = "";
		$.each(json, function(index, value)
		{ 
			var name = getString(value.name);
			var genre = getString(value.genre);
			var actor = getString(value.actor);
			var director = getString(value.director);
			var description = getString(value.description);

			content += createLiData(value.id, genre, actor, director);

			content += '<strong>' + name + '</strong>';

			content += '<img id="' + value.id + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';

			content += createSpanData(description, genre, actor, director);

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

function createLiData(id, genre, actor, director)
{
	var data = '<li ';
	data += 'id="' + id +  '" ';
	data += 'data-genre="' + genre + '" ';
	data += 'data-main-actors="' + actor + '" ';
	data += 'data-director="' + director + '" ';
	data += '>';

	return data;
}

function createSpanData(description, genre, actor, director)
{
	
	var data = '<span>Description: <i>' + description + '</i></span>';
	data += '<span>Genre: <i>' + genre + '</i></span>';
	data += '<span>Actors: <i>' + actor + '</i></span>';
	data += '<span>Director: <i>' + director + '</i></span>';

	return data;
}