<?php

class Model_Position extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'value',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'positions';
        
        // Связь с таблицей players
        protected static $_has_many = array(
            'players' => array(
                'key_from' => 'id',
                'model_to' => 'Model_Player',
                'key_to' => 'position_id',
                'cascade_save' => true,
                'cascade_delete' => true,
            )
        );

}
