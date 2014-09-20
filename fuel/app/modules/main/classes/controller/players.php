<?php
/**
 * Контроллер для отображения игроков команды
 */
namespace Main;

class Controller_Players extends Controller_Base
{
    /**
     * Действие для отображения списка игроков
     */
    public function action_index()
    {
        $data['players'] = \Model_Position::find('all', array(
                'related' => 'players',
                'order_by' => array('id' => 'ASC', 'players.player_name' => 'ASC')
            )
        );
        
        $this->template->content = \View::forge('players/index', $data, FALSE);
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
        $data['player'] = \Model_Player::query()
                                ->related('position')
                                ->where('id', $id)
                                ->get_one();
        // Если такой статьи нет, то отображаем страницу 404
        if (is_null($data['player']))
            throw new \HttpNotFoundException;

        // Передаем данные в вид 
        $this->template->content = \View::forge('players/view', $data, FALSE);
    }
}
