<?php
/**
 * Контроллер для отображения главной страницы
 */
namespace Main;

class Controller_Main extends Controller_Base
{
    public function before() 
    {
        parent::before();
        
        \View::set_global('page_title', 'Главная');
    }
    
    /**
     * Действие для отображения главной страницы
     */
    public function action_index()
    {
        // Статьи на главной
        $data['news'] = \Model_Article::query()
                //->where('category_id', '=', 1)
                ->where('on_main_page', '=', 1)
                ->order_by('id', 'DESC')
                ->limit(6)
                ->get();
        
        $this->template->content = \View::forge('main/index', $data, FALSE);
    }
}