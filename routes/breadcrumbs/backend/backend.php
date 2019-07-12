<?php

Breadcrumbs::for ('admin.dashboard', function ($trail) {
	$trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

require __DIR__ . '/auth.php';
require __DIR__ . '/log-viewer.php';
require __DIR__ . '/post.php';
require __DIR__ . '/setting.php';
require __DIR__ . '/comment.php';
require __DIR__ . '/group.php';
require __DIR__ . '/invite.php';
require __DIR__ . '/faq.php';
require __DIR__ . '/subscription.php';
require __DIR__ . '/user_subscription.php';
