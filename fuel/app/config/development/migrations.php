<?php
return array(
	'version' => 
	array(
		'app' => 
		array(
			'default' => 
			array(
				0 => '001_create_articles',
				1 => '002_create_categories',
				2 => '003_create_sliders',
				3 => '004_add_created_at_updated_at_to_sliders',
				4 => '005_add_description_to_sliders',
				5 => '006_create_videos',
				6 => '007_create_media_photos_categories',
				7 => '008_create_media_photos',
				8 => '009_create_media_videos',
				9 => '010_create_players',
				10 => '011_create_positions',
				11 => '012_create_votes',
				12 => '013_add_preview_to_articles',
				13 => '014_create_teams',
				14 => '015_create_seasons',
				15 => '016_add_has_table_to_seasons',
				16 => '017_create_seasons_teams',
				17 => '018_create_tables',
				18 => '019_create_matches',
				19 => '020_create_matches_events',
				20 => '021_create_events',
				21 => '022_create_statuses',
				22 => '023_create_strikers',
				23 => '024_add_is_core_player_to_players',
				24 => '025_create_staff',
				25 => '026_add_created_at_updated_at_to_staff',
				26 => '027_add_vk_comments_count_to_articles',
				27 => '028_add_vk_comments_count_to_matches',
				28 => '029_add_on_main_page_to_articles',
			),
		),
		'module' => 
		array(
		),
		'package' => 
		array(
			'auth' => 
			array(
				0 => '001_auth_create_usertables',
				1 => '002_auth_create_grouptables',
				2 => '003_auth_create_roletables',
				3 => '004_auth_create_permissiontables',
				4 => '005_auth_create_authdefaults',
				5 => '006_auth_add_authactions',
				6 => '007_auth_add_permissionsfilter',
				7 => '008_auth_create_providers',
				8 => '009_auth_create_oauth2tables',
				9 => '010_auth_fix_jointables',
			),
		),
	),
	'folder' => 'migrations/',
	'table' => 'migration',
);
