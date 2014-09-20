<?php
/**
 * Контроллер для отображения страницы контактов
 */
namespace Main;

class Controller_Contacts extends Controller_Base
{
    /**
     * Действие для отображения главной страницы
     */
    public function action_index()
    {
        // Три последних новости
        $data['contacts'] = \Model_Article::query()
                ->where('category_id', '=', 2)
                ->order_by('id', 'DESC')
                ->limit(1)
                ->get_one();
        
        $this->template->page_title = 'Контакты';
        $this->template->content = \View::forge('contacts/index', $data, FALSE);
    }
}
