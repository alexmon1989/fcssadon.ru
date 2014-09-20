<?php
use Orm\Model;

class Model_Player extends Model
{
    protected static $_properties = array(
            'id',
            'player_name',
            'position_id',
            'birthdate',
            'data',
            'image_uri',
            'is_core_player',
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
        
    // Связь с таблицей positions
    protected static $_belongs_to = array(
        'position' => array(
            'key_from' => 'position_id',
            'model_to' => 'Model_Position',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );

    public static function validate($factory)
    {
            $val = Validation::forge($factory);
            $val->add_field('player_name', 'Имя игрока', 'required|max_length[255]');
            $val->add_field('position_id', 'Позиция на поле', 'required|valid_string[numeric]');
            $val->add_field('birthdate', 'Дата рождения', 'required');

            return $val;
    }

}
