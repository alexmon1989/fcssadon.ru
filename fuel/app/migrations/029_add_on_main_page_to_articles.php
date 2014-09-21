<?php

namespace Fuel\Migrations;

class Add_on_main_page_to_articles
{
	public function up()
	{
		\DBUtil::add_fields('articles', array(
			'on_main_page' => array('constraint' => 1, 'type' => 'int', 'default' => '0'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('articles', array(
			'on_main_page'

		));
	}
}