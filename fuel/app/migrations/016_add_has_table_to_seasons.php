<?php

namespace Fuel\Migrations;

class Add_has_table_to_seasons
{
	public function up()
	{
		\DBUtil::add_fields('seasons', array(
			'has_table' => array('constraint' => 11, 'type' => 'int', 'default' => '0'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('seasons', array(
			'has_table'

		));
	}
}