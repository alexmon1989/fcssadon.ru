<?php
/**
 * The development database settings. These get merged with the global settings.
 */

// Локалхост
/*return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=localhost;dbname=shahter',
			'username'   => 'root',
			'password'   => '',
		),
                'profiling' => true,
	),
);*/

// На хостинге
return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=localhost;dbname=fcssadon',
			'username'   => 'root',
			'password'   => '',
		),
                'profiling' => true,
	),
);
