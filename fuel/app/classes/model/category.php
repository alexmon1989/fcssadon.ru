<?php
use Orm\Model;

class Model_Category extends Model
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
                    'events' => array('before_save'),
                    'mysql_timestamp' => false,
            ),
    );
    
    // Связь с таблицей articles
    protected static $_has_many = array(
        'articles' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Article',
            'key_to' => 'category_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );

    public static function validate($factory)
    {
            $val = Validation::forge($factory);
            $val->add_field('value', 'Название', 'required|max_length[255]');

            return $val;
    }   
    
    /**
     * Получение массива категорий статей 
     * для дальнейшего использования в input type="select"
     * 
     * @return array
     */
    public static function get_categories_for_select()
    {
        $types = self::find('all', array('order_by' => array('value' => 'asc')));
        $arr = array('' => '');
        foreach ($types as $value)
        {
            $arr[$value->id] = $value->value;
        }
        return $arr;
    }
}
