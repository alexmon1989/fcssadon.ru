<?php

namespace Fuel\Migrations;

class Create_matches_events
{
	public function up()
	{
		\DBUtil::create_table('matches_events', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'match_id' => array('constraint' => 11, 'type' => 'int'),
			'event_id' => array('constraint' => 11, 'type' => 'int'),
			'player' => array('constraint' => 255, 'type' => 'varchar'),
			'time' => array('constraint' => 11, 'type' => 'int'),
			'team_id' => array('constraint' => 11, 'type' => 'int'),
			'comment' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('matches_events');
	}
}