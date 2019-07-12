<?php

Breadcrumbs::for ('admin.invite.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push(__('labels.backend.invites.management'), route('admin.invite.index'));
});

Breadcrumbs::for ('admin.invite.deleted', function ($trail) {
	$trail->parent('admin.auth.user.index');
	$trail->push(__('menus.backend.access.users.deleted'), route('admin.auth.user.deleted'));
});

Breadcrumbs::for ('admin.invite.create', function ($trail) {
	$trail->parent('admin.invite.index');
	$trail->push(__('labels.backend.invites.create'), route('admin.invite.create'));
});

Breadcrumbs::for ('admin.invite.show', function ($trail, $id) {
	$trail->parent('admin.invite.index');
	$trail->push(__('menus.backend.access.users.view'), route('admin.invite.show', $id));
});

Breadcrumbs::for ('admin.invite.edit', function ($trail, $id) {
	$trail->parent('admin.invite.index');
	$trail->push(__('menus.backend.invites.edit'), route('admin.invite.edit', $id));
});
