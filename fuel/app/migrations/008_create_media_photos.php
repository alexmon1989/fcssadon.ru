<?php

namespace Fuel\Migrations;

class Create_media_photos
{
	public function up()
	{
		\DBUtil::create_table('media_photos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'image_path' => array('constraint' => 255, 'type' => 'varchar'),
			'category_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('media_photos');
	}
}