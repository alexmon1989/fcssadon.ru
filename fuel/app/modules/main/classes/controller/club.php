<?php
/**
 * Контроллер для отображения страницы меню "Клуб"
 */
namespace Main;

class Controller_Club extends Controller_Base
{
    /**
     * Действие для отображения определённой статьи из категории
     */
    public function action_view($id = NULL)
    {
        is_null($id) and \Response::redirect('');
        
        $data['article'] = \Model_Article::query()
                ->where('id', '=', $id)
                ->where('category_id', '=', 5)
                ->order_by('id', 'DESC')
                ->limit(1)
                ->get_one();
        
        $this->template->page_title = 'Клуб :: ' . $data['article']->title;
        $this->template->content = \View::forge('club/view', $data, FALSE);
    }
}
