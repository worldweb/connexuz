<?php

Breadcrumbs::for ('admin.group.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push(__('labels.backend.groups.management'), route('admin.group.index'));
});

Breadcrumbs::for ('admin.group.deleted', function ($trail) {
	$trail->parent('admin.auth.user.index');
	$trail->push(__('menus.backend.access.users.deleted'), route('admin.auth.user.deleted'));
});

Breadcrumbs::for ('admin.group.create', function ($trail) {
	$trail->parent('admin.group.index');
	$trail->push(__('labels.backend.groups.create'), route('admin.group.create'));
});

Breadcrumbs::for ('admin.group.show', function ($trail, $id) {
	$trail->parent('admin.group.index');
	$trail->push(__('menus.backend.access.users.view'), route('admin.group.show', $id));
});

Breadcrumbs::for ('admin.group.edit', function ($trail, $id) {
	$trail->parent('admin.group.index');
	$trail->push(__('menus.backend.groups.edit'), route('admin.group.edit', $id));
});
