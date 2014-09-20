<?php

class Model_Matches_Events extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'match_id',
		'event_id',
		'player',
		'time',
		'team_id',
		'comment',
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
	protected static $_table_name = 'matches_events';
        
        // Отношения с таблицами matches, events
        protected static $_belongs_to = array(
            'match' => array(
                'key_from' => 'match_id',
                'model_to' => 'Model_Match',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            ),
            'event' => array(
                'key_from' => 'event_id',
                'model_to' => 'Model_Event',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            ),
            'team' => array(
                'key_from' => 'team_id',
                'model_to' => 'Model_Team',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            )
        );

}
