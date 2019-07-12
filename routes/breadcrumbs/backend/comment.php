<?php

Breadcrumbs::for('admin.comment.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.comments.management'), route('admin.comment.index'));
});

Breadcrumbs::for('admin.comment.deleted', function ($trail) {
    $trail->parent('admin.auth.user.index');
    $trail->push(__('menus.backend.access.users.deleted'), route('admin.auth.user.deleted'));
});

Breadcrumbs::for('admin.comment.create', function ($trail) {
    $trail->parent('admin.comment.index');
    $trail->push(__('labels.backend.comments.create'), route('admin.comment.create'));
});

Breadcrumbs::for('admin.comment.show', function ($trail, $id) {
    $trail->parent('admin.comment.index');
    $trail->push(__('menus.backend.access.users.view'), route('admin.comment.show', $id));
});

Breadcrumbs::for('admin.comment.edit', function ($trail, $id) {
    $trail->parent('admin.comment.index');
    $trail->push(__('menus.backend.comments.edit'), route('admin.comment.edit', $id));
});