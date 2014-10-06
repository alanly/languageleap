function commercialsClick()
{
	disableExtraTabs();
	accordion.next();
	setTabName("firstTab", "commercials");
	setTabName("secondTab", "Select Commercial");

	$("#secondTab").removeClass("disabled");
}

function moviesClick()
{
	disableExtraTabs();
	accordion.next();
	setTabName("firstTab", "movies");
	setTabName("secondTab", "Select Movie");

	$("#secondTab").removeClass("disabled");
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