<?php
class Model_Article extends \Orm\Model
{
    protected static $_properties = array(
            'id',
            'title',
            'full_text',
            'preview',
            'category_id',
            'created_at',
            'updated_at',
            'vk_comments_count',
            'on_main_page'
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

    // Связь с таблицей categories
    protected static $_belongs_to = array(
        'category' => array(
            'key_from' => 'category_id',
            'model_to' => 'Model_Category',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );

    public static function validate($factory)
    {
            $val = Validation::forge($factory);
            $val->add_field('title', 'Название', 'required|max_length[255]');
            $val->add_field('full_text', 'Текст', 'required');
            $val->add_field('category_id', 'Категория', 'required|valid_string[numeric]');
            $val->add_field('on_main_page', 'На главной', 'valid_string[numeric]');

            return $val;
    }

    /**
     * Извлечение кол-ва статей
     * 
     * @param string $title
     * @param int $category_id
     */
    public static function get_articles_count($title = NULL, $category_id = NULL)
    {
        $q = self::query();     

        if ($category_id != NULL)
        {
            $q->related('category');
            $q->where('category_id', $category_id);
        }

        if ($title != NULL and $title != '')
        {
            $q->where('title', ' LIKE ', '%'.$title.'%');
        }

        return $q->count();
    }

    /**
     * Получение статей определенного типа и языка
     * 
     * @param string $type тип статей
     * @param string $language код языка
     * @param int $limit
     * @param int $offset
     * 
     * @return object
     */
    public static function get_articles($title = '', $category_id = NULL, $limit = 999, $offset = 0, $order_by = 'id', $order_method = 'DESC')
    {
        $q = self::query()
                ->related('category')
                ->where('title', 'LIKE', '%'.$title.'%')
                ->order_by($order_by, $order_method)
                ->rows_limit($limit)
                ->rows_offset($offset);
        
        if ($category_id)
        {
            $q->where('category_id', '=', $category_id);
        }
        
        return $q->get();
    }
}
