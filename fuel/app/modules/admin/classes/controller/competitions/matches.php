<?php

namespace Admin;

class Controller_Competitions_Matches extends Controller_Admin
{
    public function before()
    {
        parent::before();
        \View::set_global('subnav', array('competitions'=> 'active'));
        
        $this->template->title = "Матчи";
    }

    /**
     * Действие для отображения матчей
     */
    public function action_index()
    {            
        $data['matches'] = \Model_Match::find('all', array(
            'related' => array('team_1', 'team_2', 'status', 'season'),
            'order_by' => array('id' => 'desc'),
        ));
        
        $this->template->content = \View::forge('competitions/matches/index', $data);
    }

    /**
     * Действие для создания матча
     */
    public function action_create()
    {
        if (\Input::method() == 'POST')
        {
            $val = \Model_Match::validate('create');

            if ($val->run())
            {
                $match = \Model_Match::forge(array(
                    'team_1_id' => \Input::post('team_1_id'),
                    'team_2_id' => \Input::post('team_2_id'),
                    'status_id' => 1,
                    'season_id' => \Input::post('season_id'),
                    'date' => \Input::post('date') ? strtotime(\Input::post('date')) : NULL,
                    'name' => \Input::post('name'),
                    'vk_comments_count' => 0
                ));

                if ($match and $match->save())
                {
                    \Session::set_flash('success', 'Матч создано.');

                    \Response::redirect('admin/competitions/matches/edit/'.$match->id);
                }

                else
                {
                    \Session::set_flash('error', 'Could not save match.');
                }
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
        }
        
        // Сезоны для select
        \View::set_global('seasons', \Model_Season::get_seasons_for_select());
        
        $this->template->content = \View::forge('competitions/matches/create');

    }

    /**
     * Действие для редактирования матча
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/competitions/matches');

        if ( ! $match = \Model_Match::find($id, array(
            'related' => array('season', 
                'team_1', 
                'team_2', 
                'matches_events', 
                'matches_events.event'
            ))))
        {
            \Session::set_flash('error', 'Матч не найден.');
            \Response::redirect_back('admin/competitions/matches');
        }
        
        $val = \Model_Match::validate('edit');

        if ($val->run())
        {
            $match->status_id = \Input::post('status_id');
            $match->date = strtotime(\Input::post('date'));
            $match->name = \Input::post('name');
            $match->team_1_goals = \Input::post('team_1_goals');
            $match->team_2_goals = \Input::post('team_2_goals');
            $match->team_1_lineup = \Input::post('team_1_lineup');
            $match->team_2_lineup = \Input::post('team_2_lineup');
            $match->add_data = \Input::post('add_data');

            if ($match->save())
            {
                // Если нужно редактировать турнирную таблицу
                if (\Input::post('change_table'))
                {
                    \Model_Table::edit_table($match->season_id, 
                            $match->team_1_id, 
                            $match->team_2_id, 
                            $match->team_1_goals, 
                            $match->team_2_goals);
                }
                
                \Session::set_flash('success', 'Данные матча обновлены.');

                \Response::redirect_back('admin/competitions/matches/edit/'.$id);
            }

            else
            {
                Session::set_flash('error', 'Could not update match #' . $id);
            }
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                $match->status_id = $val->validated('status_id');
                $match->date = $val->validated('date');
                $match->name = $val->validated('name');
                $match->team_1_goals = $val->validated('team_1_goals');
                $match->team_2_goals = $val->validated('team_2_goals');
                $match->team_1_lineup = $val->validated('team_1_lineup');
                $match->team_2_lineup = $val->validated('team_2_lineup');
                $match->add_data = $val->validated('add_data');

                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('match', $match, false);
            $this->template->set_global('events', \Model_Event::get_events_for_select(), false);
        }

        $this->template->content = \View::forge('competitions/matches/edit');

    }

    public function action_delete($id = null)
    {
            is_null($id) and \Response::redirect('matches');

            if ($match = \Model_Match::find($id))
            {
                    $match->delete();

                    \Session::set_flash('success', 'Матч удалён.');
            }

            else
            {
                    \Session::set_flash('error', 'Could not delete match #'.$id);
            }

            \Response::redirect('admin/competitions/matches');

    }
    
    /**
     * Обработчик запроса на добавление события матча
     */
    public function action_add_event()
    {
        $data = array();
        
        // Поступили ли данные?
        if (\Input::method() == 'POST')
        {
            // Правила валидации полей
            $val = \Validation::forge('my_validation');
            $val->add('event_id', 'Событие')->add_rule('required')->add_rule('valid_string', 'numeric');
            $val->add('player', 'Игрок')->add_rule('required');
            $val->add('time', 'Минута')->add_rule('required');
            $val->add('match_id', 'ID матча')->add_rule('required')->add_rule('valid_string', 'numeric');
            $val->add('team_id', 'ID команды')->add_rule('required')->add_rule('valid_string', 'numeric');
            
            // Проверяем, прошла ли валидация
            if ($val->run())
            {
                // Добавляем событие в БД
                $match_event = \Model_Matches_Events::forge(array(
                    'match_id' => \Input::post('match_id'),
                    'event_id' => \Input::post('event_id'),
                    'player' => \Input::post('player'),
                    'time' => \Input::post('time'),   
                    'team_id' => \Input::post('team_id'),     
                    'comment' => \Input::post('comment'),                    
                ));
                
                if ($match_event and $match_event->save())
                {
                    $data['result']['code'] = 1;
                }

                else
                {
                    $data['result']['code'] = 0;
                    $data['result']['errors'] = '<p>Could not save match.</p>';
                }               
            }
            else
            {
                $data['result']['code'] = 0;
                $data['result']['errors'] = '<p>' . implode('</p><p>', $val->error()) . '</p>';
            }
            
            $data['result']['post'] = \Input::post();
        }
        
        return \View::forge('competitions/matches/add_event', $data, FALSE);
    }
    
    /**
     * Получение событий определённого матча определённой команды
     * 
     * @param int $match_id
     * @param int $team_id
     */
    public function action_get_events($match_id = NULL, $team_id = NULL)
    {
        $data['result'] = array();
        
        $match_events = \Model_Matches_Events::find('all', array(
            'related' => array('event'),
            'where' => array(array('match_id' => $match_id), array('team_id' => $team_id)),
        ));
        
        foreach ($match_events as $value)
        {
            $data['result'][] = array(
                'match_event_id' => $value->id,
                'event_value' => $value->event->value,
                'time' => $value->time,
                'player' => $value->player,
                'comment' => $value->comment,
            );
        }
        
        return \View::forge('competitions/matches/get_events', $data, FALSE);
    }

    /**
     * Обработчик запроса на удаление события
     */
    public function action_delete_event()
    {
        $data = array();
        if (\Input::method() == 'POST')
        {
            $match_event = \Model_Matches_Events::find(\Input::post('match_event_id'));
            
            if ($match_event)
            {
                $data['result']['match_id'] = $match_event->match_id;
                $data['result']['team_id'] = $match_event->team_id;
                
                $match_event->delete();
            }
        }
        
        return \View::forge('competitions/matches/delete_event', $data, FALSE);
    }
}
