<?php
/**
 * Контроллер для отображения видеогалереи
 */
namespace Main;

class Controller_Media_Videos extends Controller_Base
{
    public function before() 
    {
        parent::before();
        \View::set_global('subnav', array('videos'=> 'active' ));
    }


    /**
     * Действие для отображения списка видеозаписей
     */
    public function action_index()
    {
        // Пагинация
        $config = array(
            'pagination_url' => \URI::create('media/videos'),
            'total_items'    => \Model_Media_Video::count(),
            'per_page'       => 4,
            'uri_segment'    => 3,
        );
        $pagination = \Pagination::forge('videos_pagination', $config);
        $data['pagination'] = $pagination->render();
        
        // Получаем список видеозаписей
        $data['videos'] = \Model_Media_Video::find('all', array(
            'order_by' => array('created_at' => 'DESC'),
            'offset' => $pagination->offset,
            'limit' => $pagination->per_page,
        ));
        
        $this->template->page_title = 'Медиа :: Видео';
        $this->template->content = \View::forge('media/videos/index', $data, FALSE);
    }
}
