<?php

namespace Fuel\Migrations;

class Create_sliders
{
	public function up()
	{
		\DBUtil::create_table('sliders', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'img_path' => array('constraint' => 255, 'type' => 'varchar'),
			'uri' => array('constraint' => 255, 'type' => 'varchar'),
			'position' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('sliders');
	}
}