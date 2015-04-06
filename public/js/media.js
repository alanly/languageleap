function getVideoScore(video)
{
	if(video.score != null)
	{
		var stars = '';
		var numStars = video.score/20;
		for(var i = 0; i < numStars; i++)
		{
			stars += '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
		}
		
		return '<span hidden="hidden">' + video.score + '</span>' + stars;
	}
	else
	{
		return '';
	}
}