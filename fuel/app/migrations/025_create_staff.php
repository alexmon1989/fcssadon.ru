<?php

namespace Fuel\Migrations;

class Create_staff
{
	public function up()
	{
		\DBUtil::create_table('staff', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'staff_name' => array('constraint' => 255, 'type' => 'varchar'),
			'birthdate' => array('constraint' => 11, 'type' => 'int'),
			'data' => array('type' => 'text'),
			'image_uri' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('staff');
	}
}