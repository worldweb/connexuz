<?php

return [

	/*
		    |--------------------------------------------------------------------------
		    | Alert Language Lines
		    |--------------------------------------------------------------------------
		    |
		    | The following language lines contain alert messages for various scenarios
		    | during CRUD operations. You are free to modify these language lines
		    | according to your application's requirements.
		    |
	*/

	'backend' => [
		'roles' => [
			'created' => 'The role was successfully created.',
			'deleted' => 'The role was successfully deleted.',
			'updated' => 'The role was successfully updated.',
		],

		'users' => [
			'cant_resend_confirmation' => 'The application is currently set to manually approve users.',
			'confirmation_email' => 'A new confirmation e-mail has been sent to the address on file.',
			'confirmed' => 'The user was successfully confirmed.',
			'created' => 'The user was successfully created.',
			'deleted' => 'The user was successfully deleted.',
			'deleted_permanently' => 'The user was deleted permanently.',
			'restored' => 'The user was successfully restored.',
			'session_cleared' => "The user's session was successfully cleared.",
			'social_deleted' => 'Social Account Successfully Removed',
			'unconfirmed' => 'The user was successfully un-confirmed',
			'updated' => 'The user was successfully updated.',
			'updated_password' => "The user's password was successfully updated.",
		],

		'posts' => [
			'created' => 'The post was successfully created.',
			'deleted' => 'The post was successfully deleted.',
			'updated' => 'The post was successfully updated.',
		],
                'comments' => [
			'created' => 'The Comment was successfully created.',
			'deleted' => 'The Comment was successfully deleted.',
			'updated' => 'The Comment was successfully updated.',
		],
		'settings' => [
			'updated' => 'The settings updated successfully.',
		],

		'groups' => [
			'created' => 'The Group was successfully created.',
			'deleted' => 'The Group was successfully deleted.',
			'updated' => 'The Group was successfully updated.',
		],

		'invites' => [
			'created' => 'The Invite was successfully created.',
			'deleted' => 'The Invite was successfully deleted.',
			'updated' => 'The Invite was successfully updated.',
		],

		'faqs' => [
			'created' => 'The Faq was successfully created.',
			'deleted' => 'The Faq was successfully deleted.',
			'updated' => 'The Faq was successfully updated.',
		],

		'subscriptions' => [
			'created' => 'The Subscription was successfully created.',
			'deleted' => 'The Subscription was successfully deleted.',
			'updated' => 'The Subscription was successfully updated.',
		],
	],

	'frontend' => [
		'contact' => [
			'sent' => 'Your information was successfully sent. We will respond back to the e-mail provided as soon as we can.',
		],
	],
];
