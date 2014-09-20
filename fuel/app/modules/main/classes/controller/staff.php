<?php
/**
 * Контроллер для отображения игроков команды
 */
namespace Main;

class Controller_Staff extends Controller_Base
{
    /**
     * Действие для отображения списка игроков
     */
    public function action_index()
    {
        $data['staff'] = \Model_Staff::find('all', array(
                'order_by' => array('staff_name' => 'ASC')
            )
        );
        
        $this->template->page_title = 'Команда :: Персонал';
        $this->template->content = \View::forge('staff/index', $data, FALSE);
    }
    
    /**
     * Действие для просмотра игрока
     * 
     * @param int $id
     */
    public function action_view($id)
    {
        is_null($id) and \Response::redirect('');

        // Получаем запись
        $data['staff'] = \Model_Staff::query()
                                ->where('id', $id)
                                ->get_one();
        // Если такой статьи нет, то отображаем страницу 404
        if (is_null($data['staff']))
            throw new \HttpNotFoundException;

        // Передаем данные в вид 
        $this->template->page_title = 'Команда :: Персонал :: ' . $data['staff']->staff_name;
        $this->template->content = \View::forge('staff/view', $data, FALSE);
    }
}
