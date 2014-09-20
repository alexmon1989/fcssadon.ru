<?php

namespace Fuel\Migrations;

class Add_vk_comments_count_to_articles
{
	public function up()
	{
		\DBUtil::add_fields('articles', array(
			'vk_comments_count' => array('constraint' => 11, 'type' => 'int', 'default' => '0'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('articles', array(
			'vk_comments_count'

		));
	}
}