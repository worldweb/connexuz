<?php

Breadcrumbs::for ('admin.faq.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push(__('labels.backend.faqs.management'), route('admin.faq.index'));
});

Breadcrumbs::for ('admin.faq.deleted', function ($trail) {
	$trail->parent('admin.auth.user.index');
	$trail->push(__('menus.backend.access.users.deleted'), route('admin.auth.user.deleted'));
});

Breadcrumbs::for ('admin.faq.create', function ($trail) {
	$trail->parent('admin.faq.index');
	$trail->push(__('labels.backend.faqs.create'), route('admin.faq.create'));
});

Breadcrumbs::for ('admin.faq.show', function ($trail, $id) {
	$trail->parent('admin.faq.index');
	$trail->push(__('menus.backend.access.users.view'), route('admin.faq.show', $id));
});

Breadcrumbs::for ('admin.faq.edit', function ($trail, $id) {
	$trail->parent('admin.faq.index');
	$trail->push(__('menus.backend.faqs.edit'), route('admin.faq.edit', $id));
});
