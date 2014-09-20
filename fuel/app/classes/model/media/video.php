<?php
use Orm\Model;

class Model_Media_Video extends Model
{
	protected static $_properties = array(
		'id',
		'videoid',
		'title',
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
		$val->add_field('videoid', 'ID видео на Youtube', 'required|max_length[20]');
		$val->add_field('title', 'Название', 'required|max_length[255]');

		return $val;
	}

}
