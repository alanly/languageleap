@extends('master')

@section('javascript')
	<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.slick/1.3.15/slick.min.js"></script>
@stop

@section('css')
	<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/jquery.slick/1.3.15/slick.css"/>

	<style>
		.element {
			padding: 15px;
		}

		.cover {
			height: 240px;
			width: 180px;
			vertical-align: center;

			-webkit-box-shadow: 0px 0px 5px 6px rgba(209,209,209,1);
			-moz-box-shadow: 0px 0px 5px 6px rgba(209,209,209,1);
			box-shadow: 0px 0px 5px 6px rgba(209,209,209,1);
		}

		.element:hover {
		  opacity: 0.4;
		}

		.clear {
			clear:both;
		}

		.prev, .next {
			color: #CFCFCF;
			font-size: 40px;
			margin-top: -20px;
			padding: 0;
			position: absolute;
			top: 50%;
		}

		.next {
			right: -45px;
		}

		.prev {
			left: -45px;
		}

		.grid {
			padding: 25px 0 0 0;
		}

		.fluid-container{
			max-width: 70% !important;
			margin: 0 auto;
		}
	</style>
@stop

@section('content')
	<div class="fluid-container">
		<div class="row">
			<div class="grid">
				<div class="section movies">
					<h2 class="section-title">Movies</h2>
					<hr>
					<div class="elements">
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="section shows">
					<h2 class="section-title">TV Shows</h2>
					<hr>
					<div class="elements">
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
					</div>
				</div>

				<div class="section commercials">
					<h2 class="section-title">Commercials</h2>
					<hr>
					<div class="elements">
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://upload.wikimedia.org/wikipedia/en/c/cb/From-justin-to-kelly.jpg"/><br/>
						</div>
						<div class="element">
							<img class="cover" src="http://parkthatcar.net/wp-content/uploads/2013/02/himym.jpeg"/><br/>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

		$(document).ready(function() {
			$('.elements').slick({
				centerMode: true,
				infinite: true,
				variableWidth: true,
				slidesToShow: 7,
				arrows: true,
				prevArrow : "<span class='button prev glyphicon glyphicon-chevron-left'></span>",
				nextArrow : "<span class='button next glyphicon glyphicon-chevron-right'></span>"
			});
		});
			
	</script>
@stop