<?php

class Model_User extends \Orm\Model
{
    protected static $_properties = array(
            'id',
            'username',
            'password',
            'group',
            'email',
            'last_login',
            'login_hash',
            'profile_fields',
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
    protected static $_table_name = 'users';

    /**
     * Валидация
     */
    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        
        // Если нужна валидация при создании пользователя, то валидируем еще и пароль
        if ($factory == 'create')
        {
            $val->add_field('username', 'Логин', 'required|max_length[255]|min_length[5]');    
            $val->add_field('email', 'E-Mail', 'required|max_length[255]'); 
        }
        
        if ($factory == 'create' or (trim(Input::post('password') != '')))
        {            
            $val->add_field('password', 'Пароль', 'required|max_length[255]|min_length[5]');
            $val->add_field('password2', 'Подтверждение пароля', 'match_field[password]');                   
        }

        return $val;
    }     
}
