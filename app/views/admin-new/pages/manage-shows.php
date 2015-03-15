<h1>Manage TV Shows</h1>

<table class="table table-hover shows">
	<thead>
		<tr>
			<th>ID</th>
			<th>Action</th>
			<th>Name</th>
			<th>Publish</th>
		</tr>
	</thead>
	<tbody ng-repeat="show in shows" ng-class="showRowClicked ? 'show-selected' : ''" ng-init="showRowClicked = false">
		<tr>
			<td class="id">{{ show.id }}</td>
			<td><a href="javascript:;" ng-click="openEditModal(show);"><i class="fa fa-edit fa-fw"></i></a><a href="javascript:;" ng-confirm-message="<?php echo Lang::get('admin.delete.confirm'); ?>" ng-confirm-click="onDeleteShowClick($event, show)"><i class="fa fa-trash fa-fw"></i></a></td>
			<td><a href="javascript:;" ng-click="showRowClicked = !showRowClicked; loadSeasons(show);">{{ show.name }}</a></td>
			<td><input class="publish" type="checkbox" ng-model="show.is_published" ng-checked="show.is_published" ng-click="onPublishClick($event, show)"></td>
		</tr>
		<tr class="show-{{ show.id }}" ng-repeat-start="season in show.seasons">
			<td>{{ season.id }}</td>
			<td><a href="javascript:;"><i class="fa fa-edit fa-fw"></i></a><a href="javascript:;"><i class="fa fa-trash fa-fw"></i></a></td>
			<td><a class="season-name" href="javascript:;" ng-click="loadEpisodes(show, season);">Season {{ season.number }}</a></td>
			<td><input class="publish" type="checkbox"></td>
		</tr>
		<tr class="season-{{ season.id }}" ng-repeat-end ng-repeat="episode in season.episodes">
			<td>{{ episode.id }}</td>
			<td><a href="javascript:;"><i class="fa fa-edit fa-fw"></i></a><a href="javascript:;"><i class="fa fa-trash fa-fw"></i></a></td>
			<td><span class="episode-name">Episode {{ episode.number }}</span></td>
			<td><input class="publish" type="checkbox"></td>
		</tr>
	</tbody>
</table>