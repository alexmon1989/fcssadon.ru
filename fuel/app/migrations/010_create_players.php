<?php

namespace Fuel\Migrations;

class Create_players
{
	public function up()
	{
		\DBUtil::create_table('players', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'player_name' => array('constraint' => 255, 'type' => 'varchar'),
			'position_id' => array('constraint' => 11, 'type' => 'int'),
			'birthdate' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'data' => array('type' => 'text'),
			'image_uri' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('players');
	}
}