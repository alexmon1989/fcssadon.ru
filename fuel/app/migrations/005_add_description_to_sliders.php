<?php

namespace Fuel\Migrations;

class Add_description_to_sliders
{
	public function up()
	{
		\DBUtil::add_fields('sliders', array(
			'description' => array('constraint' => 60, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('sliders', array(
			'description'

		));
	}
}