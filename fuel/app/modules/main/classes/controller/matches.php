<?php
/**
 * Контроллер для отображения деталей матча
 */
namespace Main;

class Controller_Matches extends Controller_Base
{
    /**
     * Действие для отображения деталей матча
     */
    public function action_index($match_id)
    {
        is_null($match_id) and \Response::redirect('');
        
        $data['match'] = \Model_Match::find($match_id, array(
            'related' => array('team_1', 'team_2', 'season', 'matches_events'),
            'where' => array(array('status_id', '=', 2)),
        ));
        if ($data['match'])
        {        
            $this->template->page_title = 'Команда :: Календарь матчей :: ' . $data['match']->season->value . ' :: ' . $data['match']->name;
            $this->template->content = \View::forge('matches/index', $data, FALSE);
        }
        else
        {
            \Response::redirect('');
        }
    }
    
    /**
     * Дейсвтие-обработчик ПОСТ-запроса на изменения кол-ва комментов ВК
     */
    public function action_change_comments_num()
    {
        if (\Input::method() == 'POST')
        {
            $id = (int) \Input::post('id');
            $num = (int) \Input::post('num');
            
            if ($id != 0)
            {
                $match = \Model_Match::find($id);
                if ($match)
                {
                    $match->vk_comments_count = $num;
                    $match->save();
					
					return \View::forge('empty', array());
                }
            }
        }
    }
}