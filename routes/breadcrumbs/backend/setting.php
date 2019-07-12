<?php

Breadcrumbs::for('admin.setting.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.settings.management'), route('admin.setting.index'));
});
