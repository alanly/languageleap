@extends('admin.master')
@section('head')
<link rel="stylesheet" href="/css/admin.css">
@stop
@section('content')
<div class="container-fluid">
	<div id="slidedown-add-new" class="clearfix" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			{{ Form::open(array('url'=>'admin/add-new-form-submit', 'files'=>true, 'id' => 'new-media-form')) }}
			<div id="add-new-content" class="modal-content">
	      <div id="add-new-header" class="modal-header">
        	<h2>Media Info</h2>
				</div>
				<div id="add-new-body-info" class="modal-body clearfix" aria-hidden="false" style="display: block;">
					<!-- <form id="new-form" role="form"> -->
						<div class="form-group">
							<label>Media type: </label>
							<div class="radio">
								<label>
									<input type="radio" name="info-radio" id="info-commercial-radio" value="commercial" checked /> Commercial
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="info-radio" id="info-tvshow-radio" value="show" /> TV Show
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="info-radio" id="info-movie-radio" value="movie" /> Movie
								</label>
							</div>
						</div>
						
						<div id="info-default-form" style="width: 500px;">
							
							<div id="info-default-form-name" class="form-group">
								<label>Name</label>
								<input id="info-commercial-form-name-input" name="name" type="text" class="form-control" placeholder="" />
							</div>
							<div id="info-default-form-description" class="form-group">
								<label>Description</label>
								<input id="info-default-form-description-input" name="description" type="text" class="form-control" placeholder="" />
							</div>
						</div>

						<div id="info-extra-tab" aria-hidden="true" style="display: none;">
							
							<div id="info-tvshow-form" style="width: 500px;">
								<div id="info-tvshow-form-director" class="form-group">
									<label>Director</label>
									<input name="director" type="text" class="form-control" placeholder="" />
								</div>
								<div id="info-tvshow-form-actor" class="form-group">
									<label>Actor</label>
									<input name="actor" type="text" class="form-control" placeholder="" />
								</div>
								<div id="info-tvshow-form-genre" class="form-group">
									<label>Genre</label>
									<input name="genre" type="text" class="form-control" placeholder="" />
								</div>
							</div>
						</div>
					<!-- </form> -->

				</div>
				<div id="add-new-body-script" class="modal-body clearfix" aria-hidden="true" style="display: none;">
					@include('admin.script.script')
				</div>
				<div id="add-new-body-media" class="modal-body clearfix" aria-hidden="true" style="display: none;">
				  {{ Form::label('file', 'File', array('id'=>'', 'class'=>'')) }}
				  {{ Form::file('file', '', array('id'=>'', 'class'=>'')) }}
				</div>
				<div id="add-new-body-upload" class="modal-body clearfix" aria-hidden="true" style="display: none;">
					upload progress ajax stuff goes here
				</div>
				<div class="modal-footer">
					<button id="button-add-new-back" type="button" class="btn btn-primary" style="display: none;">Back</button>
					<button id="button-add-new-next" type="button" class="btn btn-primary">Next</button>
				</div>
			</div>
		  {{ Form::close() }}
		</div>
	</div>
	
	<div id="button-add-new" class="pull-right">
		<button type="button" class="btn btn-success center-block">Add Media</button>
	</div>
	
	<div id="search" class="container">
		<input class="rounded" style="margin-right: 5px;" /><i class="fa fa-search fa-lg"></i>
	</div>
	<div id="select" class="container">
		<span id="select-movies">Movies</span> <span id="select-commercials">Commercials</span> <span id="select-commercials">TV Shows</span>
	</div>
	<div id="content" class="container">
	</div>
	<div id="add" class="container">
	</div>
</div>

<div id="media-modal" class="modal fade" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title"></h2>
      </div>
			
      <div class="modal-body info" aria-hidden="false" style="display: block;">
		    <div class="row">
		        <div class="col-xs-4">
		        	<img class="modal-image" src="" />
		        </div>
		        <div class="col-xs-8">
							<div class="info-row">ID: <span class="modal-id"></span></div>
		        	<div class="info-row">Name: <span class="modal-name"></span></div>
							<div class="info-row">Description: <span class="modal-desc"></span></div>
							<div class="info-row">Director: <span class="modal-director"></span></div>
							<div class="info-row">Actor: <span class="modal-actor"></span></div>
		        </div>
		    </div>
      </div>
			
      <div class="modal-body media" aria-hidden="true" style="display: none;">
				Media goes here
      </div>
			
      <div class="modal-body script clearfix" aria-hidden="true" style="display: none;">
				<?php
					// change route and function to whatever you need
					echo Form::open(array('url' => 'foo/bar', 'class'=>'form-script'));
					//echo Form::model($script, array('route' => array('script.create', $script->id)));
					echo Form::label('text', 'Script');
					echo Form::textarea('text');
					echo Form::submit('Submit');
					echo Form::close();
				?>
      </div>
			
      <div class="modal-body flash" aria-hidden="true" style="display: none;">
				Flashcards go here
      </div>
			
      <div class="modal-footer">
		    <div class="row-fluid">
					<div id="footer-info" class="span2 text-center">
						Info
					</div>
					<div id="footer-media" class="span2 text-center">
						Media
					</div>
					<div id="footer-script" class="span2 text-center">
						Script
					</div>
					<div id="footer-flash" class="span2 text-center">
						Flashcards
					</div>
					<div id="" class="span2 text-center">
						Aaaaaa
					</div>
					<div id="" class="span2 text-center">
						Bbbbbb
					</div>
				</div>				
      </div>
		</div>
	</div>
</div>

<script type="text/javascript" src="/js/admin.js"></script>
@stop