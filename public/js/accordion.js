function commercialsClick()
{
	disableExtraTabs();
	accordion.next();
	setTabName("firstTab", "commercials");
	setTabName("secondTab", "Select Commercial");

	$("#secondTab").removeClass("disabled");

	accordion.bindClicker(1);

	fetchCommercials();
}

function moviesClick()
{
	disableExtraTabs();
	accordion.next();
	setTabName("firstTab", "movies");
	setTabName("secondTab", "Select Movie");

	$("#secondTab").removeClass("disabled");

	accordion.bindClicker(1);

	fetchMovies();
}

function showsClick()
{
	enableExtraTabs();
	accordion.next();
	setTabName("firstTab", "shows");
	setTabName("secondTab", "Select Shows");
	setTabName("thirdTab", "Select Season");
	setTabName("fourthTab", "Select Episode");

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
			var description = getString(value.description);

			content += '<li ';
			content += 'id="' + value.id +  '" ';
			content += '>';

			content += '<strong>' + name + '</strong>';

			content += '<a class="tooltiptext">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id=commercials"' + value.id + '" src="" alt="' + description + '">';
			content += '</a>';

			content += '</li>';

			listOfData.push([value.id, "Description: " + description]);
		});

		$("#container").html(content);

		for(var i = 0; i < listOfData.length; i++)
		{
   			displayMoreInfo("commercials"+ listOfData[i][0], name, listOfData[i][1]);
		}
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
			var genre = getString(value.genre);
			var actor = getString(value.actor);
			var director = getString(value.director);
			var description = getString(value.description);

			content += createLiData(value.id, genre, actor, director);

			content += '<strong>' + name + '</strong>';

			content += '<a class="tooltiptext">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id=movies"' + value.id + '" src="" alt="' + description + '">';
			content += '</a>';

			content += '</li>';

			listOfData.push([value.id, createHoverData(description, genre, actor, director)]);
		});

		$("#container").html(content);

		for(var i = 0; i < listOfData.length; i++)
		{
   			displayMoreInfo("movies"+ listOfData[i][0], name, listOfData[i][1]);
		}
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
			var genre = getString(value.genre);
			var actor = getString(value.actor);
			var director = getString(value.director);
			var description = getString(value.description);

			content += createLiData(value.id, genre, actor, director);

			content += '<strong>' + name + '</strong>';

			content += '<a class="tooltiptext">';
			content += '<img id="shows' + value.id + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + name + '">';
			content += '</a>';

			content += '</li>';

			listOfData.push([value.id, createHoverData(description, genre, actor, director)]);
		});

		$("#container").html(content);

		for(var i = 0; i < listOfData.length; i++)
		{
			$("#shows" + listOfData[i][0]).click({id: listOfData[i][0]}, fetchShowsSeason);
   			displayMoreInfo("shows"+ listOfData[i][0], name, listOfData[i][1]);
		}
	});
}

function fetchShowsSeason(event)
{
	accordion.next();
	fetchBegin("seasonContainer");


	$.getJSON( "/api/metadata/shows/" + event.data.id + "/seasons", function(data) 
	{
		var json = data.data;
		var content = "";
		var listOfData = [];

		$.each(json, function(index, value)
		{ 
			var name = getString(value.name);

			content += '<li ';
			content += 'id="' + value.id +  '" ';
			content += '>';

			content += '<strong>' + name + '</strong>';

			content += '<a class="tooltiptext">';
			//content += '<img id="' + value.name + '" src="' + ((value.image_path == null) ? '' : value.image_path) + '" alt="' + description + '">';
			content += '<img id=seasons"' + value.id + '" src="" alt="' + description + '">';
			content += '</a>';

			content += '</li>';
		});

		$("#container").html(content);
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

	setTabName("thirdTab", "");
	setTabName("fourthTab", "");

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

function createHoverData(description, genre, actor, director)
{
	
	var data = "Description: " + description + "<br />";
	data += ' Genre: ' + genre + "<br />";
	data += ' Actors: ' + actor + "<br />";
	data += ' Director: ' + director;

	return data;
}