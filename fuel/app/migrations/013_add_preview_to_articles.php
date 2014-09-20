<?php

namespace Fuel\Migrations;

class Add_preview_to_articles
{
	public function up()
	{
		\DBUtil::add_fields('articles', array(
			'preview' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('articles', array(
			'preview'

		));
	}
}