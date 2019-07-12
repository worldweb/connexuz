<?php

Breadcrumbs::for ('admin.subscription.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push(__('labels.backend.subscriptions.management'), route('admin.subscription.index'));
});

Breadcrumbs::for ('admin.subscription.deleted', function ($trail) {
	$trail->parent('admin.auth.user.index');
	$trail->push(__('menus.backend.access.users.deleted'), route('admin.auth.user.deleted'));
});

Breadcrumbs::for ('admin.subscription.create', function ($trail) {
	$trail->parent('admin.subscription.index');
	$trail->push(__('labels.backend.subscriptions.create'), route('admin.subscription.create'));
});

Breadcrumbs::for ('admin.subscription.show', function ($trail, $id) {
	$trail->parent('admin.subscription.index');
	$trail->push(__('menus.backend.access.users.view'), route('admin.subscription.show', $id));
});

Breadcrumbs::for ('admin.subscription.edit', function ($trail, $id) {
	$trail->parent('admin.subscription.index');
	$trail->push(__('menus.backend.subscriptions.edit'), route('admin.subscription.edit', $id));
});
