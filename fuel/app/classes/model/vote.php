<?php
use Orm\Model;

class Model_Vote extends Model
{
	protected static $_properties = array(
		'id',
		'question',
		'answers_json',
		'hash',
		'enable',
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
		$val->add_field('question', 'Вопрос', 'required|max_length[255]');
		$val->add_field('answer_1', 'Ответ 1', 'required|max_length[255]');
		$val->add_field('enable', 'Включено', 'valid_string[numeric]');

		return $val;
	}

}
