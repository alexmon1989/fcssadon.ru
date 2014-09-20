<?php

namespace Fuel\Migrations;

class Create_matches
{
	public function up()
	{
		\DBUtil::create_table('matches', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'team_1_id' => array('constraint' => 11, 'type' => 'int'),
			'team_2_id' => array('constraint' => 11, 'type' => 'int'),
			'status_id' => array('constraint' => 11, 'type' => 'int', 'default' => '1'),
			'season_id' => array('constraint' => 11, 'type' => 'int'),
			'date' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'team_1_goals' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'team_2_goals' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'team_1_lineup' => array('type' => 'text', 'null' => true),
			'team_2_lineup' => array('type' => 'text', 'null' => true),
			'add_data' => array('type' => 'text', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('matches');
	}
}