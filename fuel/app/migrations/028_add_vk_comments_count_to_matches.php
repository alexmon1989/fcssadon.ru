<?php

namespace Fuel\Migrations;

class Add_vk_comments_count_to_matches
{
	public function up()
	{
		\DBUtil::add_fields('matches', array(
			'vk_comments_count' => array('constraint' => 11, 'type' => 'int', 'default' => '0'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('matches', array(
			'vk_comments_count'

		));
	}
}