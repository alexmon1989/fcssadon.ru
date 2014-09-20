<?php
use Orm\Model;

class Model_Match extends Model
{
	protected static $_properties = array(
		'id',
		'team_1_id',
		'team_2_id',
		'status_id',
		'season_id',
		'date',
		'name',
		'team_1_goals',
		'team_2_goals',
		'team_1_lineup',
		'team_2_lineup',
		'add_data',
		'created_at',
		'updated_at',
                'vk_comments_count',
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
                
        protected static $_belongs_to = array(
            // Отношение с таблицей `teams`
            'team_1' => array(
                'key_from' => 'team_1_id',
                'model_to' => 'Model_Team',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            ),
            // Отношение с таблицей `teams`
            'team_2' => array(
                'key_from' => 'team_2_id',
                'model_to' => 'Model_Team',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            ),
            // Отношение с таблицей `statuses`
            'status' => array(
                'key_from' => 'status_id',
                'model_to' => 'Model_Status',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            ),
            // Отношение с таблицей `seasons`
            'season' => array(
                'key_from' => 'season_id',
                'model_to' => 'Model_Season',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            ),
        );
        
        protected static $_has_many = array(
            // Отношение с таблицей `matches_events`
            'matches_events' => array(
                'key_from' => 'id',
                'model_to' => 'Model_Matches_Events',
                'key_to' => 'match_id',
                'cascade_save' => true,
                'cascade_delete' => true,
            )
        );
        

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
                if ($factory == 'create')
                {
                    $val->add_field('team_1_id', 'Команда 1', 'required|valid_string[numeric]');
                    $val->add_field('team_2_id', 'Команда 2', 'required|valid_string[numeric]');
                    $val->add_field('season_id', 'Сезон (соревнование)', 'required|valid_string[numeric]');
                    $val->add_field('name', 'Название матча', 'required|max_length[255]');
                }
		$val->add_field('status_id', 'Статус', 'valid_string[numeric]');
		
		$val->add_field('team_1_goals', 'Голов забила команда 1', 'valid_string[numeric]');
		$val->add_field('team_2_goals', 'Голов забила команда 2', 'valid_string[numeric]');

		return $val;
	}

}
