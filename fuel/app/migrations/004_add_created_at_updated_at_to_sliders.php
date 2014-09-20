<?php

namespace Fuel\Migrations;

class Add_created_at_updated_at_to_sliders
{
	public function up()
	{
		\DBUtil::add_fields('sliders', array(
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('sliders', array(
			'created_at'
,			'updated_at'

		));
	}
}