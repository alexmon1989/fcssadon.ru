<?php
use Orm\Model;

class Model_Season extends Model
{
	protected static $_properties = array(
		'id',
		'value',
		'has_table',
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
        
        // Связь многие-ко-многим с таблицей `teams`
        protected static $_many_many = array(
            'teams' => array(
                'key_from' => 'id',
                'key_through_from' => 'season_id', 
                'table_through' => 'seasons_teams', 
                'key_through_to' => 'team_id', 
                'model_to' => 'Model_Team',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            )
        );
        
        protected static $_has_one = array(
            'table' => array(
                'key_from' => 'id',
                'model_to' => 'Model_Table',
                'key_to' => 'season_id',
                'cascade_save' => true,
                'cascade_delete' => true,
            )
        );
        
        protected static $_has_many = array(
            // Отношение с таблицей `matches`
            'matches' => array(
                'key_from' => 'id',
                'model_to' => 'Model_Match',
                'key_to' => 'season_id',
                'cascade_save' => true,
                'cascade_delete' => true,
            )
        );

	public static function validate($factory)
	{
            $val = Validation::forge($factory);
            $val->add_field('value', 'Название', 'required|max_length[255]');
            $val->add_field('teams', 'Команды', 'required');
            $val->add_field('has_table', 'Создать таблицу', 'valid_string[numeric]');

            return $val;
	}
        
        public static function get_seasons_for_select()
        {
            $res = self::find('all', array('order_by' => array('id' => 'DESC')));
            
            $seasons = array();
            
            foreach ($res as $item)
            {
                $seasons[$item->id] = $item->value;
            }
            
            return $seasons;
        }

}
