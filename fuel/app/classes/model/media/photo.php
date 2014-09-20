<?php
use Orm\Model;

class Model_Media_Photo extends Model
{
	protected static $_properties = array(
		'id',
		'image_path',
		'category_id',
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
        
        // Связь с таблицей media_photos_categories
        protected static $_belongs_to = array(
            'category' => array(
                'key_from' => 'category_id',
                'model_to' => 'Model_Media_Photos_Category',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            ),
        );

	public static function validate($factory)
	{
		$val = Validation::forge($factory);

		return $val;
	}

}
