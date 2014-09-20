<?php

namespace Fuel\Migrations;

class Add_created_at_updated_at_to_staff
{
	public function up()
	{
		\DBUtil::add_fields('staff', array(
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('staff', array(
			'created_at'
,			'updated_at'

		));
	}
}