<?php
use Orm\Model;

class Model_Media_Photos_Category extends Model
{
	protected static $_properties = array(
		'id',
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
        
        // Связь с таблицей media_photos
        protected static $_has_many = array(
            'photos' => array(
                'key_from' => 'id',
                'model_to' => 'Model_Media_Photo',
                'key_to' => 'category_id',
                'cascade_save' => true,
                'cascade_delete' => true,
            )
        );

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Название', 'required|max_length[255]');

		return $val;
	}

}
