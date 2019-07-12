<?php

Breadcrumbs::for('admin.post.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.posts.management'), route('admin.post.index'));
});

Breadcrumbs::for('admin.post.deleted', function ($trail) {
    $trail->parent('admin.auth.user.index');
    $trail->push(__('menus.backend.access.users.deleted'), route('admin.auth.user.deleted'));
});

Breadcrumbs::for('admin.post.create', function ($trail) {
    $trail->parent('admin.post.index');
    $trail->push(__('labels.backend.posts.create'), route('admin.post.create'));
});

Breadcrumbs::for('admin.post.show', function ($trail, $id) {
    $trail->parent('admin.post.index');
    $trail->push(__('menus.backend.access.users.view'), route('admin.post.show', $id));
});

Breadcrumbs::for('admin.post.edit', function ($trail, $id) {
    $trail->parent('admin.post.index');
    $trail->push(__('menus.backend.posts.edit'), route('admin.post.edit', $id));
});