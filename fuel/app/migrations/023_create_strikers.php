<?php

namespace Fuel\Migrations;

class Create_strikers
{
	public function up()
	{
		\DBUtil::create_table('strikers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'season_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'show' => array('constraint' => 11, 'type' => 'int', 'default' => '0'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('strikers');
	}
}