<?php

class Model_Slider extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'img_path',
		'uri',
		'position',
		'description',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('uri', 'Ссылка', 'required|max_length[255]');
		$val->add_field('description', 'Описание', 'required|max_length[60]');

		return $val;
	}

}
