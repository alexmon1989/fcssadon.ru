<?php
/**
 * Контроллер для отображения фотогалереи
 */
namespace Main;

class Controller_Media_Photos_Categories extends Controller_Base
{
    public function before() 
    {
        parent::before();
        \View::set_global('subnav', array('photos'=> 'active'));
    }


    /**
     * Действие для отображения списка фотогалерей
     */
    public function action_index()
    {
        // Пагинация
        $config = array(
            'pagination_url' => \URI::create('media/photos/categories/index'),
            'total_items'    => \Model_Media_Photos_Category::count(),
            'per_page'       => 6,
            'uri_segment'    => 5,
        );
        $pagination = \Pagination::forge('categories_pagination', $config);
        $data['pagination'] = $pagination->render();
        
        $data['сategories'] = \Model_Media_Photos_Category::find('all', array(
            'related' => 'photos',
            'order_by' => array('created_at' => 'DESC'),
            'offset' => $pagination->offset,
            'limit' => $pagination->per_page,
        ));
        
        $this->template->page_title = 'Медиа :: Фото';
        $this->template->content = \View::forge('media/photos/categories/index', $data, FALSE);
    }
    
    /**
     * Отображение списка фотографий категории
     * 
     * @param int $id
     */
    public function action_view($id = null)
    {
        is_null($id) and \Response::redirect('media/photos/categories');
        
        // Пагинация
        $config = array(
            'pagination_url' => \URI::create('media/photos/categories/view/'.$id),
            'total_items'    => \Model_Media_Photo::count(array('where' => array(array('category_id', '=', $id)))),
            'per_page'       => 6,
            'uri_segment'    => 6,
        );
        $pagination = \Pagination::forge('photos_pagination', $config);
        $data['pagination'] = $pagination->render();
        
        // Извлекаем данные категории
        $data['photos'] = \Model_Media_Photo::find('all', array(
            'related' => 'category',
            'where' => array(array('category_id', '=', $id)),
            'order_by' => array('created_at' => 'DESC'),
            'offset' => $pagination->offset,
            'limit' => $pagination->per_page,
        ));
        
        $this->template->css = array('lightbox.css');
        $this->template->js = array('lightbox.min.js');
        
        $this->template->page_title = 'Медиа :: Фото :: ' . current($data['photos'])->category->title;
        $this->template->content = \View::forge('media/photos/categories/view', $data, FALSE);
    }
}
