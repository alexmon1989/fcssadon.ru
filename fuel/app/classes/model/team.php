<?php
use Orm\Model;

class Model_Team extends Model
{
	protected static $_properties = array(
		'id',
		'value',
		'logo_uri',
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
        
        protected static $_has_many = array(
            // Отношение с таблицей `matches_events`
            'matches_events' => array(
                'key_from' => 'id',
                'model_to' => 'Model_Matches_Events',
                'key_to' => 'team_id',
                'cascade_save' => true,
                'cascade_delete' => true,
            ),
            // Отношение с таблицей `matches`
            'matches_1' => array(
                'key_from' => 'id',
                'model_to' => 'Model_Matches_Events',
                'key_to' => 'team_id_1',
                'cascade_save' => true,
                'cascade_delete' => true,
            ),
            'matches_2' => array(
                'key_from' => 'id',
                'model_to' => 'Model_Matches_Events',
                'key_to' => 'team_id_2',
                'cascade_save' => true,
                'cascade_delete' => true,
            )
        );
        
        // Связь многие-ко-многим с таблицей `seasons`
        protected static $_many_many = array(
            'seasons' => array(
                'key_from' => 'id',
                'key_through_from' => 'team_id', 
                'table_through' => 'seasons_teams', 
                'key_through_to' => 'season_id', 
                'model_to' => 'Model_Season',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            )
        );

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('value', 'Название', 'required|max_length[255]');

		return $val;
	}
        
        /**
         * Получение команд для элемента select
         * 
         * @return array
         */
        public static function get_teams_for_select()
        {
            $res = self::find('all', array('order_by' => array('value' => 'ASC')));
            
            $teams = array();
            
            foreach ($res as $item)
            {
                $teams[$item->id] = $item->value;
            }
            
            return $teams;
        }

}
