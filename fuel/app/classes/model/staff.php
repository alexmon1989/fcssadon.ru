<?php
use Orm\Model;

class Model_Staff extends Model
{
    protected static $_properties = array(
            'id',
            'staff_name',
            'birthdate',
            'data',
            'image_uri',
            'created_at',
            'updated_at',
    );
    
    protected static $_table_name = 'staff';
    
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
            $val->add_field('staff_name', 'Имя', 'required|max_length[255]');
            $val->add_field('birthdate', 'Дата рождения', 'required');

            return $val;
    }

}
