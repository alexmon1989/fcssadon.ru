<?php

class Model_Event extends \Orm\Model
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
	protected static $_table_name = 'events';
        
        protected static $_has_many = array(
            // Отношение с таблицей `matches_events`
            'matches_events' => array(
                'key_from' => 'id',
                'model_to' => 'Model_Matches_Events',
                'key_to' => 'event_id',
                'cascade_save' => true,
                'cascade_delete' => true,
            )
        );

    /**
    * Получение массива событий
    * для дальнейшего использования в input type="select"
    * 
    * @return array
    */
    public static function get_events_for_select()
    {
        $events = self::find('all', array('order_by' => array('value' => 'asc')));
        $arr = array();
        foreach ($events as $value)
        {
            $arr[$value->id] = $value->value;
        }
        return $arr;
    }
}
