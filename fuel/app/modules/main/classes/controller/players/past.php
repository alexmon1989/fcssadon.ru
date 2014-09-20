<?php
/**
 * Контроллер для отображения игроков команды
 */
namespace Main;

class Controller_Players_Past extends Controller_Base
{
    /**
     * Действие для отображения списка игроков
     */
    public function action_index()
    {
        $data['players'] = \Model_Position::find('all', array(
                'related' => 'players',
                'where' => array(array('players.is_core_player', '=', 0)), // выборка основных игроков
                'order_by' => array('id' => 'ASC', 'players.player_name' => 'ASC')
            )
        );
        
        $this->template->page_title = 'Команда :: Все игроки';
        $this->template->content = \View::forge('players/past/index', $data, FALSE);
    }
    
    /**
     * Действие для просмотра игрока
     * 
     * @param int $id
     */
    public function action_view($id)
    {
        is_null($id) and \Response::redirect('');

        // Получаем новость
        $data['player'] = \Model_Staff::query()
                                ->related('position')
                                ->where('id', $id)
                                ->where('is_core_player', 0) // выборка основных игроков
                                ->get_one();
        // Если такой статьи нет, то отображаем страницу 404
        if (is_null($data['player']))
            throw new \HttpNotFoundException;

        // Передаем данные в вид 
        $this->template->page_title = 'Команда :: Все игроки :: ' . $data['player']->player_name;
        $this->template->content = \View::forge('players/past/view', $data, FALSE);
    }
}
