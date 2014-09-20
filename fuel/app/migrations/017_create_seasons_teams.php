<?php

namespace Fuel\Migrations;

class Create_seasons_teams
{
	public function up()
	{
		\DBUtil::create_table('seasons_teams', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'season_id' => array('constraint' => 11, 'type' => 'int'),
			'team_id' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('seasons_teams');
	}
}