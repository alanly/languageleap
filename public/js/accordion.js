var player = "/video/play/";

function commercialsClick()
{
	disableExtraTabs();
	clearTabs();
	accordion.next();
	setTabName("firstTab", dictionary.commercials);
	setTabName("secondTab", dictionary.selectCommercials);
	setTabName("thirdTab", dictionary.selectVideos);

	$("#secondTab").removeClass("disabled");
	$("#thirdTab").removeClass("disabled");

	accordion.bindClicker(1);
	accordion.bindClicker(2);

	fetchCommercials();
}

function moviesClick()
{
	disableExtraTabs();
	clearTabs();
	accordion.next();
	setTabName("firstTab", dictionary.movies);
	setTabName("secondTab", dictionary.selectMovies);
	setTabName("thirdTab", dictionary.selectVideos);

	$("#secondTab").removeClass("disabled");
	$("#thirdTab").removeClass("disabled");

	accordion.bindClicker(1);
	accordion.bindClicker(2);

	fetchMovies();
}

function showsClick()
{
	enableExtraTabs();
	clearTabs();
	accordion.next();
	setTabName("firstTab", dictionary.shows);
	setTabName("secondTab", dictionary.selectShows);
	setTabName("thirdTab", dictionary.selectSeason);
	setTabName("fourthTab", dictionary.selectEpisode);
	setTabName("fifthTab", dictionary.selectVideos);

	accordion.bindClicker(1);
	$("#secondTab").removeClass("disabled");

	fetchShows();
}

function fetchCommercials()
{
	fetchBegin("container");

	$.getJSON( "/api/metadata/commercials", function(data) 
	{
		var json = data.data;
		var content = "";
		var listOfData = [];

		$.each(json, function(index, value)
		{ 
			var name = getString(value.name);
			var description = getStringCapitalise(value.description);

			content += '<li ';
			content += 'id="' + value.id +  '" ';
			content += '>';

			content += '<div class="media-title">'
			content += '<strong>' + trimName(name) + '</strong>';
			content += '</div>'

			content += '<a class="tooltiptext">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id="commercials' + value.id + '" src="" alt="' + name + '">';
			content += '</a>';

			content += '</li>';

			listOfData.push([value.id, name, "Description: " + description]);
		});

		$("#container").html(content);

		for(var i = 0; i < listOfData.length; i++)
		{
   			displayMoreInfo("commercials"+ listOfData[i][0], listOfData[i][1], listOfData[i][2]);
   			$("#commercials" + listOfData[i][0]).click({commercialId: listOfData[i][0], commercialName: listOfData[i][1]}, fetchCommercialVideos);
		}
	});
}

function fetchCommercialVideos(event)
{
	fetchBegin("seasonContainer");
	setTabName("secondTab", event.data.commercialName);
	accordion.next();

	$.getJSON( "/api/metadata/commercials/" + event.data.commercialId, function(data) 
	{
		var json = data.data;
		var content = "";
		var listOfData = [];
		var counter = 1;

		$.each(json.videos, function(index, value)
		{ 
			content += '<li>';

			content += '<strong>Video ' + counter + '</strong>';

			content += '<a class="tooltiptext" href="'+ player + value.id+'">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id="commercialVideos' + value.id + '" src="" alt="Video ' + counter + '">';
			content += '</a>';

			content += '</li>';

			counter++;
		});

		$("#seasonContainer").html(content);
	});
}


function fetchMovies()
{
	fetchBegin("container");

	$.getJSON( "/api/metadata/movies", function(data) 
	{
		var json = data.data;
		var content = "";
		var listOfData = [];

		$.each(json, function(index, value)
		{ 
			var name = getString(value.name);
			var genre = getStringCapitalise(value.genre);
			var actor = getString(value.actor);
			var director = getString(value.director);
			var description = getStringCapitalise(value.description);

			content += createLiData(value.id, genre, actor, director);

			content += '<div class="media-title">'
			content += '<strong>' + trimName(name) + '</strong>';
			content += "</div>"

			content += '<a class="tooltiptext">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id="movies' + value.id + '" src="" alt="' + name + '">';
			content += '</a>';

			content += '</li>';

			listOfData.push([value.id, name, createHoverData(description, genre, actor, director)]);
		});

		$("#container").html(content);

		for(var i = 0; i < listOfData.length; i++)
		{
   			displayMoreInfo("movies"+ listOfData[i][0], listOfData[i][1], listOfData[i][2]);
   			$("#movies" + listOfData[i][0]).click({movieId: listOfData[i][0], movieName: listOfData[i][1]}, fetchMovieVideos);
		}
	});
}

function fetchMovieVideos(event)
{
	fetchBegin("seasonContainer");
	setTabName("secondTab", event.data.movieName);
	accordion.next();

	$.getJSON( "/api/metadata/movies/" + event.data.movieId, function(data) 
	{
		var json = data.data;
		var content = "";
		var listOfData = [];
		var counter = 1;

		$.each(json.videos, function(index, value)
		{ 
			content += '<li>';

			content += '<strong>Video ' + counter + '</strong>';

			content += '<a class="tooltiptext" href="'+ player + value.id+'">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id="movieVideos' + value.id + '" src="" alt="Video ' + counter + '">';
			content += '</a>';

			content += '</li>';

			counter++;
		});

		$("#seasonContainer").html(content);
	});
}

function fetchShows()
{
	fetchBegin("container");

	$.getJSON( "/api/metadata/shows", function(data) 
	{
		var json = data.data;
		var content = "";
		var listOfData = [];

		$.each(json, function(index, value)
		{ 
			var name = getString(value.name);
			var genre = getStringCapitalise(value.genre);
			var actor = getString(value.actor);
			var director = getString(value.director);
			var description = getStringCapitalise(value.description);

			content += createLiData(value.id, genre, actor, director);

			content += '<div class="media-title">'
			content += '<strong>' + trimName(name) + '</strong>';
			content += '</div>'

			content += '<a class="tooltiptext">';
			content += '<img id="shows' + value.id + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + name + '">';
			content += '</a>';

			content += '</li>';

			listOfData.push([value.id, createHoverData(description, genre, actor, director), name]);
		});

		$("#container").html(content);

		for(var i = 0; i < listOfData.length; i++)
		{
			$("#shows" + listOfData[i][0]).click({showId: listOfData[i][0], name: listOfData[i][2]}, fetchShowsSeason);
   			displayMoreInfo("shows"+ listOfData[i][0], listOfData[i][2], listOfData[i][1]);
		}
	});
}

function fetchShowsSeason(event)
{
	setTabName("secondTab", event.data.name);
	accordion.next();
	fetchBegin("seasonContainer");

	$.getJSON( "/api/metadata/shows/" + event.data.showId + "/seasons/", function(data) 
	{
		var json = data.data;
		var content = "";
		var listOfData = [];

		$.each(json.seasons, function(index, value)
		{ 
			var name = getString(value.name);

			content += '<li>';

			content += '<strong>Season ' + value.number + '</strong>';

			content += '<a class="tooltiptext">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id="seasons' + value.id + '" src="" alt="Season ' + value.number + '">';
			content += '</a>';

			content += '</li>';

			listOfData.push([value.id, value.number, event.data.showId]);
		});

		$("#seasonContainer").html(content);

		for(var i = 0; i < listOfData.length; i++)
		{
			$("#seasons" + listOfData[i][0]).click({seasonId: listOfData[i][0], number: listOfData[i][1], showId: listOfData[i][2]}, fetchSeasonsEpisode);
		}
	});
}


function fetchSeasonsEpisode(event)
{
	setTabName("thirdTab", "Season " + event.data.number);
	accordion.next();
	fetchBegin("episodeContainer");


	$.getJSON( "/api/metadata/shows/" + event.data.showId + "/seasons/" + event.data.seasonId + "/episodes/", function(data) 
	{
		var json = data.data;
		var content = "";
		var listOfData = [];

		$.each(json.episodes, function(index, value)
		{ 
			var name = getString(value.name);
			var description = getStringCapitalise(value.description)

			content += '<li>';

			content += '<strong>Episode ' + value.number + '</strong>';

			content += '<a class="tooltiptext">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id="episodes' + value.id + '" src="" alt="Episode ' + value.number + '">';
			content += '</a>';

			content += '</li>';

			listOfData.push([value.id, value.number, event.data.showId, event.data.seasonId, name, description]);
		});

		$("#episodeContainer").html(content);


		for(var i = 0; i < listOfData.length; i++)
		{
			$("#episodes" + listOfData[i][0]).click({episodeId: listOfData[i][0], episodeNumber: listOfData[i][1], showId: listOfData[i][2], seasonId: listOfData[i][3]}, fetchEpisodeVideos);
			displayMoreInfo("episodes"+ listOfData[i][0], listOfData[i][4], listOfData[i][5]);
		}
	});
}

function fetchEpisodeVideos(event)
{
	fetchBegin("videoContainer");
	setTabName("fourthTab", "Episode " + event.data.episodeNumber);
	accordion.next();

	$.getJSON( "/api/metadata/shows/" + event.data.showId + "/seasons/" + event.data.seasonId + "/episodes/" + event.data.episodeId, function(data) 
	{
		var json = data.data;
		var content = "";
		var listOfData = [];
		var counter = 1;

		$.each(json.videos, function(index, value)
		{ 
			content += '<li>';

			content += '<strong>Video ' + counter + '</strong>';

			content += '<a class="tooltiptext" href="' + player + value.id+'">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id="episodeVideos' + value.id + '" src="" alt="Video ' + counter + '">';
			content += '</a>';

			content += '</li>';

			counter++;
		});

		$("#videoContainer").html(content);
	});
}

function fetchBegin(loadingContainer)
{	
	$.get("libraries/loading/html/loading.html", function(data){
    $("#" + loadingContainer).html(data);
});
}

function fetchEnd()
{

}

function disableExtraTabs()
{
	$("#thirdTab").addClass("disabled");
	$("#fourthTab").addClass("disabled");
	$("#fifthTab").addClass("disabled");

	setTabName("thirdTab", "");
	setTabName("fourthTab", "");
	setTabName("fifthTab", "");

	disableClickableTabs();
}

function displayMoreInfo(id, titleMessge, message)
{
	$("#" + id).qtip({
		content: {
		title: titleMessge,
		text: message
		},
		style: {
        classes: 'qtip-dark'
    	},
    	position: {
        my: 'left center',  
        at: 'right center' 
    	},
    	hide: {
        event: 'mouseleave'
    	}
	});
}

function enableExtraTabs()
{
	$("#thirdTab").removeClass("disabled");
	$("#fourthTab").removeClass("disabled");
	$("#fifthTab").removeClass("disabled");

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
	$("#fifthTab").addClass("disabled");

	accordion.unbindClicker(1);
	accordion.unbindClicker(2);
	accordion.unbindClicker(3);
	accordion.unbindClicker(4);
}

function enableClickableTabs()
{
	accordion.bindClicker(2);
	accordion.bindClicker(3);
	accordion.bindClicker(4);
}

function disableClickableTabs()
{
	accordion.unbindClicker(2);
	accordion.unbindClicker(3);
	accordion.unbindClicker(4);
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

function getStringCapitalise(str)
{
	if(str == null)
	{
		return "N/A";
	}
	str = str.toLowerCase();
	return  str.substring(0,1).toUpperCase() + str.substring(1,str.length);
}

function createLiData(id, genre, actor, director)
{
	var data = '<li ';
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

function createHoverData(description, genre, actor, director)
{
	
	var data = "Description: " + description + "<br />";
	data += ' Genre: ' + genre + "<br />";
	data += ' Actors: ' + actor + "<br />";
	data += ' Director: ' + director;

	return data;
}

function clearTabs()
{
	$("#seasonContainer").html("");
	$("#episodeContainer").html("");
	$("#videoContainer").html("");
}

function trimName(str)
{
	if(str.length < 25)
	{
		return str;
	}

	return str.substring(0, 25) + "...";
}