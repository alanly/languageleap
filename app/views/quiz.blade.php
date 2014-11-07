@extends('master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="quiz-container">
				<div id="quiz-carousel" class="carousel slide" data-ride="carousel">

					<!-- Slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<h3>What is the definition of <em>hello</em>?</h3>

							<form>
								<label for="hello-0">
									<input type="radio" id="hello-0" name="hello" value="0">
									a common greeting
								</label><br>
								<label for="hello-1">
									<input type="radio" id="hello-1" name="hello" value="1">
									a type of spice native to South America and used in southern cuisine
								</label><br>
								<label for="hello-2">
									<input type="radio" id="hello-2" name="hello" value="2">
									an anthropomorphic, ape-like animal that legendarily lives in the rural woods
								</label><br>
								<label for="hello-3">
									<input type="radio" id="hello-3" name="hello" value="3">
									a colour commonly associated with the sun
								</label><br>
								<a href="#quiz-carousel" class="btn btn-primary" role="button" data-slide="next">Next</a>
							</form>
						</div>

						<div class="item">
							<h3>What is the definition of <em>chello</em>?</h3>

							<form>
								<label for="chello-0">
									<input type="radio" id="chello-0" name="hello" value="0">
									a common greeting
								</label><br>
								<label for="chello-1">
									<input type="radio" id="chello-1" name="hello" value="1">
									a stringed musical instrument
								</label><br>
								<label for="chello-2">
									<input type="radio" id="chello-2" name="hello" value="2">
									a weapon of mass destruction
								</label><br>
								<label for="chello-3">
									<input type="radio" id="chello-3" name="hello" value="3">
									a disease which causes profuse bleeding through the rectal area
								</label><br>
								<a href="#quiz-carousel" class="btn btn-primary" role="button" data-slide="next">Next</a>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$('#quiz-carousel').carousel({
	interval: false
});
</script>
@stop