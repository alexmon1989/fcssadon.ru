<?php
/**
 * Контроллер для отображения матчей
 */
namespace Main;

class Controller_Calendar extends Controller_Base
{
    /**
     * Действие для отображения списка сезонов
     */
    public function action_index()
    {
        $data['seasons'] = \Model_Season::find('all', array('order_by' => array('id' => 'desc')));
        
        $this->template->page_title = 'Команда :: Календарь матчей';
        $this->template->content = \View::forge('calendar/index', $data, FALSE);
    }
    
    /**
     * Просмотр календаря матча конкретного сезона
     * 
     * @param int $season_id id сезона
     */
    public function action_view($season_id = NULL)
    {
        is_null($season_id) and \Response::redirect('');
        
        $matches = \Model_Match::find('all', array(
            'related' => array('team_1', 'team_2', 'season'),
            'where' => array(array('season_id', '=', $season_id)),
            'order_by' => array('date' => 'ASC')
        ));
        
        if ($matches)
        {        
            $name = '';
            $res = array();
            foreach ($matches as $item)
            {
                if ($item->name != $name)
                {
                    $res[] = array('name' => $item->name, 'matches' => array());
                    $name = $item->name;
                }
                $res[count($res)-1]['matches'][] = $item;
                
                if (!isset($season))
                    $season = $item->season->value;
            }
            
            $this->template->page_title = 'Команда :: Календарь матчей :: ' . $season;
            $this->template->content = \View::forge('calendar/view', array('matches' => $res), FALSE);
        }
        else
            \Response::redirect('');
    }
}