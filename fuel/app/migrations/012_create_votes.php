<?php

namespace Fuel\Migrations;

class Create_votes
{
	public function up()
	{
		\DBUtil::create_table('votes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'question' => array('constraint' => 255, 'type' => 'varchar'),
			'answers_json' => array('type' => 'text'),
			'hash' => array('constraint' => 32, 'type' => 'varchar'),
			'enable' => array('constraint' => 1, 'type' => 'int', 'default' => '0'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('votes');
	}
}