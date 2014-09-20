<?php

namespace Fuel\Migrations;

class Add_is_core_player_to_players
{
	public function up()
	{
		\DBUtil::add_fields('players', array(
			'is_core_player' => array('constraint' => 1, 'type' => 'int', 'default' => '0'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('players', array(
			'is_core_player'

		));
	}
}