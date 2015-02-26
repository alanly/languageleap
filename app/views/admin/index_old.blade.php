@extends('admin.master')

@section('head')
<link rel="stylesheet" href="/css/admin.css">
<link rel="stylesheet" href="/css/admin-script.css"/>
<script type="text/javascript" src="/js/admin-script.js"></script>
<meta name="csrf-token" content="<?= csrf_token() ?>">
@stop

@section('content')
<div class="container-fluid">
	<!-- pulldown modal for adding new media -->
	<div id="slidedown-add-new" class="clearfix" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<!-- {{ Form::open(array('url'=>'admin/add-new-form-submit', 'files'=>true, 'id' => 'new-media-form')) }} -->
			{{ Form::open(array('url'=>'api/videos', 'files'=>true, 'id' => 'new-media-form')) }}
			
			<div id="add-new-content" class="modal-content">
	      <div id="add-new-header" class="modal-header">
        	<h2>Media Info</h2>
				</div>
				<!-- step one -->
				<div id="add-new-body-info" class="modal-body clearfix" aria-hidden="false" style="display: block;">
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
							<input id="info-commercial-form-name-input" name="name" type="text" class="form-control" placeholder="" required aria-required=”true” />
						</div>
						<div id="info-default-form-description" class="form-group">
							<label>Description</label>
							<input id="info-default-form-description-input" name="description" type="text" class="form-control" placeholder="" required aria-required=”true” />
						</div>
						<div id="info-default-form-level" class="form-group">
							<label>Level</label>
							<select id="info-default-form-level-select" name="level_id" class="form-control">
								@foreach($levels as $level)
	  								<option value="{{ $level->id }}">{{ $level->description }}</option>
								@endforeach
							</select>
						</div>
						<div id="info-default-form-language" class="form-group">
							<label>Language</label>
							<select id="info-default-form-language-select" name="language_id" class="form-control">
								@foreach($languages as $language)
	  								<option value="{{ $language->id }}">{{ $language->description }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div id="info-extra-tab" aria-hidden="true" style="display: none;">
					
						<div id="info-tvshow-form" style="width: 500px;">
							<div id="info-tvshow-form-director" class="form-group">
								<label>Director</label>
								<input id="director-input" name="director" type="text" class="form-control" placeholder="" />
							</div>
							<div id="info-tvshow-form-actor" class="form-group">
								<label>Actor</label>
								<input id="actor-input" name="actor" type="text" class="form-control" placeholder="" />
							</div>
							<div id="info-tvshow-form-genre" class="form-group">
								<label>Genre</label>
								<input id="genre-input" name="genre" type="text" class="form-control" placeholder="" />
							</div>
						</div>
					</div>
				</div>
				<!-- /step one -->
				<!-- step two -->
				<div id="add-new-body-script" class="modal-body clearfix" aria-hidden="true" style="display: none;">
					<div id="edit-container">
						<div id="add-script" class="script-editor" contenteditable=true></div>
					</div>
				</div>
				<!-- /step two -->
				<!-- step three -->
				<div id="add-new-body-media" class="modal-body clearfix" aria-hidden="true" style="display: none;">
				  {{ Form::label('file', 'File', array('id'=>'', 'class'=>'')) }}
				  {{ Form::file('video', '', array('id'=>'file', 'class'=>'')) }}
				</div>
				<!-- /step three -->
				<div id="add-new-body-upload" class="modal-body text-center clearfix" aria-hidden="true" style="display: none;">
					Uploading media, please wait...
				</div>
				<div class="modal-footer">
					<button id="button-add-new-back" type="button" class="btn btn-primary" style="display: none;">Back</button>
					<button id="button-add-new-next" type="button" class="btn btn-primary">Next</button>
				</div>
			</div>
		  {{ Form::close() }}
		</div>

		<!-- modal for the script editor -->
		@include('admin.script.script')
		<!-- /modal for the script editor -->
	</div>
	<!-- /pulldown modal for adding new media -->
	
	<div id="button-add-new" class="pull-right">
		<button type="button" class="btn btn-success center-block">Add Media</button>
	</div>
	
	<!-- search -->
	<div id="search" class="container">
		<input class="rounded" style="margin-right: 5px;" /><i class="fa fa-search fa-lg"></i>
	</div>
	<!-- /search -->
		
	<!-- categories -->
	<div id="select" class="container">
		<span id="select-movies">Movies</span> <span id="select-commercials">Commercials</span> <span id="select-shows">TV Shows</span>
	</div>
	<div id="content" class="container">
	</div>
	<!-- /categories -->
</div>

<!-- media info modal -->
<div id="media-modal" class="modal fade" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="edit-media-title"></h2>
      </div>
			
			<!-- info -->
      <div class="modal-body info" aria-hidden="false" style="display: block;">
				{{ Form::open(array('url'=>'admin/edit-media-info', 'files'=>false, 'id' => 'edit-media-form')) }}
		    <div class="row">
		        <div class="col-xs-4">
		        	<img class="modal-image" src="" />
		        </div>
		        <div class="col-xs-8">
							<div class="info-row">ID: <span class="modal-id"></span></div>

							<div id="" class="form-group">
								<label>Name</label>
								<input id="edit-media-info-name" name="name" type="text" class="form-control" placeholder="" />

								<label>Description</label>
								<input id="edit-media-info-description" name="description" type="text" class="form-control" placeholder="" />

								<label>Director</label>
								<input id="edit-media-info-director" name="director" type="text" class="form-control" placeholder="" />
								
								<label>Actor</label>
								<input id="edit-media-info-actor" name="actor" type="text" class="form-control" placeholder="" />
							
								<label>Level</label>
								<select id="edit-media-info-level" name="level_id" class="form-control">
									@foreach($levels as $level)
		  								<option value="{{ $level->id }}">{{ $level->description }}</option>
									@endforeach
								</select>
								
								<label>Language</label>
								<select id="edit-media-info-language" name="language_id" class="form-control">
									@foreach($languages as $language)
		  								<option value="{{ $language->id }}">{{ $language->description }}</option>
									@endforeach
								</select>
							</div>
		        </div>
						<button id="button-edit-info-save" type="button" class="btn btn-primary pull-right">Save</button>
		    </div>
				{{ Form::close() }}
      </div>
			<!-- /info -->
			
			<!-- script -->
      <div class="modal-body script clearfix" aria-hidden="true" style="display: none;">
				<div class="row">
					<div id="edit-container">
						<div id="edit-script" class="script-editor" contenteditable=true></div>
					</div>
				
					@include('admin.script.script')
					<button id="button-edit-script-save" type="button" class="btn btn-primary pull-right">Save</button>
				</div>
      </div>
			<!-- /script -->
			
			<!-- seasons and episodes -->
      <div class="modal-body seasons clearfix" aria-hidden="true" style="display: none;">
				<div class="row">
					<div class="col-xs-3">
						<label>Season</label>
						<select id="edit-media-info-seasons" name="season_id" class="form-control">
						</select>
						<a href="#" id="popover-new-season-outer" rel="popover" data-original-title="">+</a>
					</div>
					<div class="col-xs-3">
						<label>&nbsp;</label>
						<div id="popover-new-season-inner" style="display: block;">
							<input id="add-new-season" name="new-season" type="text" class="form-control" placeholder="" style="display: inline-block; width: 50px;" />
							<button id="add-season" type="button" class="btn btn-primary">Add</button>
						</div>
					</div>
					
					<div class="col-xs-3">
						<label>Episode</label>
						<select id="edit-media-info-episodes" name="episode_id" class="form-control">
						</select>
						<a href="#" id="popover-new-episode-outer" rel="popover" data-original-title="">+</a>
					</div>
					<div class="col-xs-3">
						<label>&nbsp;</label>
						<div id="popover-new-episode-inner" style="display: block;">
							<input id="add-new-episode" name="new-episode" type="text" class="form-control" placeholder="" style="display: inline-block; width: 50px;" />
							<button id="add-episode" type="button" class="btn btn-primary" disabled="true">Add</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label>Name</label>
						<input id="edit-media-info-episode-name" name="ep_name" type="text" class="form-control" placeholder="" />
					</div>
				</div>
				<div class="row">		
					<div class="col-xs-4">
						<label>Description</label>
						<input id="edit-media-info-episode-description" name="ep_description" type="text" class="form-control" placeholder="" />
					</div>
				</div>
				<div class="row">	
					<button id="button-edit-episode-save" type="button" class="btn btn-primary pull-right">Save</button>
				</div>
      </div>
			<!-- /seasons and episodes -->
			
			{{ Form::open(array('url'=>'', 'id' => 'edit-timestamps-form')) }}			
      <div class="modal-body media" aria-hidden="true" style="display: none;">
				<div class="row">
					<div class="row">
						<div class="col-xs-4 col-xs-offset-4">
							Whoever did the player should prolly embed it here. <br /><br />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4 col-xs-offset-4">
						<h3>Timestamps</h3>
						<ul id="timestamp-list" class="list-inline">
						</ul>
						<i id="timestamp-add" class="fa fa-plus"></i>
					</div>
				</div>
				<div class="row">	
					<button id="button-edit-timestamp-save" type="button" class="btn btn-primary pull-right">Save</button>
				</div>
			</div>
			
      <div class="modal-footer">
		    <div class="row-fluid">
					<span id="footer-info">Info</span>
					<span id="footer-seasons" aria-hidden="true" style="display: none;">Seasons</span>
					<span id="footer-script">Script</span>
					<span id="footer-media">Media</span>
				</div>				
      </div>
		</div>
	  {{ Form::close() }}
	</div>
</div>

<script type="text/javascript" src="/js/admin.js"></script>
@stop