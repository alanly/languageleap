<h1><?= Lang::get('admin.media.show.manage') ?></h1>

<table class="table table-hover shows">
	<thead>
		<tr>
			<th><?= Lang::get('admin.media.show.table.id') ?></th>
			<th><?= Lang::get('admin.media.show.action') ?></th>
			<th><?= Lang::get('admin.media.show.table.name') ?></th>
			<th><?= Lang::get('admin.media.show.publish') ?></th>
		</tr>
	</thead>
	<tbody ng-repeat="show in shows" ng-class="showRowClicked ? 'show-selected' : ''" ng-init="showRowClicked = false">
		<tr>
			<td class="id">{{ show.id }}</td>
			<td><a href="javascript:;" ng-click="openShowEditModal(show);"><i class="fa fa-edit fa-fw"></i></a><a href="javascript:;" ng-confirm-message="<?php echo Lang::get('admin.delete.confirm'); ?>" ng-confirm-click="onDeleteShowClick($event, show)"><i class="fa fa-trash fa-fw"></i></a></td>
			<td><a href="javascript:;" ng-click="showRowClicked = !showRowClicked; loadSeasons(show);">{{ show.name }}</a></td>
			<td><input class="publish" type="checkbox" ng-model="show.is_published" ng-checked="show.is_published" ng-click="onPublishShowClick($event, show)"></td>
		</tr>
		<tr class="show-{{ show.id }}" ng-repeat-start="season in show.seasons">
			<td>{{ season.id }}</td>
			<td><a href="javascript:;" ng-click="openSeasonEditModal(show, season);"><i class="fa fa-edit fa-fw"></i></a><a href="javascript:;" ng-confirm-message="<?php echo Lang::get('admin.delete.confirm'); ?>" ng-confirm-click="onDeleteSeasonClick($event, show, season)"><i class="fa fa-trash fa-fw"></i></a></td>
			<td><a class="season-name" href="javascript:;" ng-click="loadEpisodes(show, season);"><?= Lang::get('admin.media.season.name') ?> {{ season.number }}</a></td>
			<td><input class="publish" type="checkbox" ng-model="season.is_published" ng-checked="season.is_published" ng-click="onPublishSeasonClick($event, show, season)"></td>
		</tr>
		<tr class="season-{{ season.id }}" ng-repeat-end ng-repeat="episode in season.episodes">
			<td>{{ episode.id }}</td>
			<td><a href="javascript:;" ng-click="openEpisodeEditModal(show, season, episode);"><i class="fa fa-edit fa-fw"></i></a><a href="javascript:;" ng-confirm-message="<?php echo Lang::get('admin.delete.confirm'); ?>" ng-confirm-click="onDeleteEpisodeClick($event, show, season, episode)"><i class="fa fa-trash fa-fw"></i></a></td>
			<td><span class="episode-name"><?= Lang::get('admin.media.episode.name') ?> {{ episode.number }} - {{ episode.name }}</span></td>
			<td><input class="publish" type="checkbox" ng-model="episode.is_published" ng-checked="episode.is_published" ng-click="onPublishEpisodeClick($event, show, season, episode)"></td>
		</tr>
	</tbody>
</table>