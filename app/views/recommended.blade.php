@extends('master')

@section('css')
	<link rel="stylesheet" href="/css/recommended.css">
@stop

@section('content')
	<h2>Recommended Videos</h2>
	<hr>
	<div id="recommended-scroller" class="carousel slide" data-ride="carousel">
		<!-- Wrapper for slides -->
		<div class="carousel-inner text-center" role="listbox">
			<div class="item active">
				<div class="col-sm-12 no-videos hide">
					<h3>No videos to show</h3>
				</div>
			</div>
		</div>

		<!-- Controls -->
		<a class="left carousel-control" href="#recommended-scroller" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">@lang('pagination.previous')</span>
		</a>
		<a class="right carousel-control" href="#recommended-scroller" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">@lang('pagination.next')</span>
		</a>
	</div>

	<script>
		function fillCarousel(data) {
			if (data.length == 0) {
				$('#recommended-scroller .no-videos').removeClass('hide');
			} else {
				$('#recommended-scroller .carousel-inner').html('');

				$.each(data, function(i) {
					if ((i % 3) == 0) {
						$('#recommended-scroller .carousel-inner')
						.append('<div class="item' + ((i == 0) ? ' active' : '') + '"></div>');
					}

					$('#recommended-scroller .item:last')
					.append('<div class="col-sm-4">' +
								'{{ HTML::image("img/auth/airport2_bg@2x.jpg") }}' +
								'<br>' +
								'<span>' + data[i].name + '</span>' +
							'</div>');
				});
			}
		}

		function loadRecommendations() {
			var url = '/api/metadata/recommended';
			$.ajax({
				type : 'GET',
				url : url,
				success : function(data) {
					fillCarousel(data.data);
				},
				error : function(data) {
					$('#recommended-scroller .no-videos').removeClass('hide');
				}
			});
		}

		$(function() {
			loadRecommendations();
		});
	</script>
@stop