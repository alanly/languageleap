function getWordInformation(wordId)
{
	$.getJSON( "/api/metadata/words/" + wordId, function(data) 
	{
		var json = data.data;

		$.each(json, function(index, value)
		{ 
			var word = getString(value.name);
			var pronouciation = getString(value.pronouciation);
			var fullDefinition = getString(value.full_definition);
		});
	});
}

function getString(str)
{
	return str.substring(0,1).toUpperCase() + str.substring(1,str.length);
}