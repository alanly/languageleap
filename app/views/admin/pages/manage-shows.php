<h1><?= Lang::get('admin.media.show.manage') ?></h1>

<a ng-click="openNewShowModal();" class="btn btn-primary pull-right">+</a>

<table class="table table-hover shows">
	<thead ng-init="orderByReverse = false; orderByPredicate = 'name';">
		<tr>
			<th class="col-md-1"><?= Lang::get('admin.media.show.table.id') ?></th>
			<th class="col-md-2"><?= Lang::get('admin.media.show.action') ?></th>
			<th class="col-md-8"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'name'"><?= Lang::get('admin.media.show.table.name') ?><i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'name'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
			<th class="col-md-1"><span class="sortable" ng-click="orderByReverse = !orderByReverse; orderByPredicate = 'is_published'"><?= Lang::get('admin.media.show.publish') ?><i ng-class="{ 'fa fa-caret-up fa-fw': (orderByPredicate == 'is_published'), 'fa-flip-vertical': !orderByReverse }"></i></span></th>
		</tr>
	</thead>
	<tbody ng-repeat="show in shows | orderBy:orderByPredicate:orderByReverse" ng-class="{ 'show-selected': expandShow }" ng-init="expandShow = false">
		<tr>
			<td class="id">{{ show.id }}</td>
			<td>
				<a href="javascript:;" ng-click="openEditShowModal(show);"><i class="fa fa-edit fa-fw"></i></a>
				<a href="javascript:;" ng-confirm-message="<?= Lang::get('admin.delete.confirm') ?>" ng-confirm-click="onDeleteShowClick($event, show)"><i class="fa fa-trash fa-fw"></i></a>
				<a href="javascript:;" ng-click="openNewSeasonModal(show);"><i class="fa fa-plus fa-fw"></i></a>
			</td>
			<td><a href="javascript:;" ng-click="expandShow = !expandShow; loadSeasons(show);">{{ show.name }}</a></td>
			<td><input class="publish" type="checkbox" ng-model="show.is_published" ng-checked="show.is_published" ng-click="onPublishShowClick($event, show)"></td>
		</tr>
		<tr class="show-{{ show.id }}" ng-hide="!expandShow" ng-repeat-start="season in show.seasons | orderBy:'number'" ng-init="expandSeason = false">
			<td>{{ season.id }}</td>
			<td>
				<a href="javascript:;" ng-click="openEditSeasonModal(show, season);"><i class="fa fa-edit fa-fw"></i></a>
				<a href="javascript:;" ng-confirm-message="<?= Lang::get('admin.delete.confirm') ?>" ng-confirm-click="onDeleteSeasonClick($event, show, season)"><i class="fa fa-trash fa-fw"></i></a>
				<a href="javascript:;" ng-click="openNewEpisodeModal(show, season);"><i class="fa fa-plus fa-fw"></i></a>
			</td>
			<td><a class="season-name" href="javascript:;" ng-click="expandSeason = !expandSeason; loadEpisodes(show, season);"><?= Lang::get('admin.media.season.name') ?> {{ season.number }}</a></td>
			<td><input class="publish" type="checkbox" ng-model="season.is_published" ng-checked="season.is_published" ng-click="onPublishSeasonClick($event, show, season)"></td>
		</tr>
		<tr class="season-{{ season.id }}" ng-hide="!expandShow || !expandSeason" ng-repeat-end ng-repeat="episode in season.episodes | orderBy:'number'">
			<td>{{ episode.id }}</td>
			<td>
				<a href="javascript:;" ng-click="openEditEpisodeModal(show, season, episode);"><i class="fa fa-edit fa-fw"></i></a>
				<a href="javascript:;" ng-confirm-message="<?= Lang::get('admin.delete.confirm') ?>" ng-confirm-click="onDeleteEpisodeClick($event, show, season, episode)"><i class="fa fa-trash fa-fw"></i></a>
				<a ng-click="manageMedia(show, season, episode);"><i class="fa fa-film fa-fw"></i></a>
			</td>
			<td><span class="episode-name"><?= Lang::get('admin.media.episode.name') ?> {{ episode.number }} - {{ episode.name }}</span></td>
			<td><input class="publish" type="checkbox" ng-model="episode.is_published" ng-checked="episode.is_published" ng-click="onPublishEpisodeClick($event, show, season, episode)"></td>
		</tr>
	</tbody>
</table>

<div ng-if="shows.length === 0">
	<?php echo Lang::get('admin.terms.empty'); ?>
</div>

<div class="manage-media" ng-include="show_media">

</div>