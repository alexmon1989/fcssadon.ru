<?php

namespace Fuel\Migrations;

class Create_media_videos
{
	public function up()
	{
		\DBUtil::create_table('media_videos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'videoid' => array('constraint' => 20, 'type' => 'varchar'),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('media_videos');
	}
}