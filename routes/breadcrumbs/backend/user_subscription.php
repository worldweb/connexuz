<?php

Breadcrumbs::for ('admin.usersubscription.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push(__('labels.backend.user_subscriptions.management'), route('admin.usersubscription.index'));
});

Breadcrumbs::for ('admin.usersubscription.show', function ($trail, $id) {
	$trail->parent('admin.usersubscription.index');
	$trail->push(__('menus.backend.access.users.view'), route('admin.usersubscription.show', $id));
});