<?php

/**
 * Контроллер для управления сезонами
 */
namespace Admin;

class Controller_Competitions_Seasons extends Controller_Admin
{
    public function before()
    {
        parent::before();
        \View::set_global('subnav', array('competitions'=> 'active'));
        
        $this->template->title = "Сезоны";
    }
    
    /**
     * Список сезонов
     */
    public function action_index()
    {
        // Пагинация
        $config = array(
            'pagination_url' => \URI::create('admin/competitions/seasons/index'),
            'total_items'    => \Model_Season::count(),
            'per_page'       => 10,
            'uri_segment'    => 5,
        );
        $pagination = \Pagination::forge('seasons_pagination', $config);
        $data['pagination'] = $pagination->render();
        
        $data['seasons'] = \Model_Season::find('all', array(
            'order_by' => array('id' => 'DESC'),
            'offset' => $pagination->offset,
            'limit' => $pagination->per_page,
        ));
        $this->template->content = \View::forge('competitions/seasons/index', $data);
    }

    /**
     * Действие для создания соревнования
     */
    public function action_create()
    {
        if (\Input::method() == 'POST')
        {
            $val = \Model_Season::validate('create');

            if ($val->run())
            {
                $season = \Model_Season::forge(array(
                    'value' => \Input::post('value'),
                    'has_table' => \Input::post('has_table', 0),
                ));
                
                if (\Input::post('teams'))
                {
                    foreach (\Input::post('teams') as $item)
                    {
                        $season->teams[] = \Model_Team::find($item);                        
                    }                                        
                }
                
                // Если нужно также создать таблицу
                if ($season->has_table == 1)
                {
                    // Массив таблицы результатов
                    $arr = array();
                    $i = 1;
                    foreach ($season->teams as $item)
                    {
                        $arr[] = array(
                            'id' => $item->id,
                            'place' => $i,
                            'name' => $item->value,
                            'games' => 0,
                            'wins' => 0,
                            'draws' => 0,
                            'loss' => 0,
                            'goals_in' => 0,
                            'goals_out' => 0,
                            'goals_out' => 0,
                            'points' => 0
                        ); 
                        $i++;
                    }
                    
                    $season->table = \Model_Table::forge(array(
                        'results_json' => json_encode($arr),
                        'show_on_main' => 0,
                    ));
                }

                if ($season and $season->save())
                {
                    \Session::set_flash('success', 'Сезон (соревнование) добавлен(о).');

                    \Response::redirect_back('admin/competitions/seasons');
                }
                else
                {
                    \Session::set_flash('error', 'Could not save Season.');
                }
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
        }
        
        // Команды
        $this->template->set_global('teams', \Model_Team::get_teams_for_select(), false);

        $this->template->content = \View::forge('competitions/seasons/create');

    }

    /**
     * Действие дял редактирования сезона (соревнования)
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/competitions/seasons');

        if ( ! $season = \Model_Season::find($id, array('related' => array('teams'))))
        {
            \Session::set_flash('error', 'Could not find Season #'.$id);
            \Response::redirect_back('admin/competitions/seasons');
        }

        $val = \Model_Season::validate('edit');

        if ($val->run())
        {
            $season->value = \Input::post('value');         
            unset($season->teams);
            if (\Input::post('teams'))
            {
                foreach (\Input::post('teams') as $item)
                {
                    $season->teams[] = \Model_Team::find($item);                        
                }                                        
            }
            
            if ($season->has_table == 1 and \Input::post('has_table') == 0)
            {
                $table = \Model_Table::find('first', array(
                    'where' => array(array('season_id', '=', $season->id))
                ));
                if ($table)
                    $table->delete();
                $season->has_table = 0;
            }
            
            // Если нужно также создать таблицу
            if ($season->has_table == 0 and \Input::post('has_table') == 1)
            {                
                $season->has_table = 1;
                                
                // Массив таблицы результатов
                $arr = array();
                $i = 1;
                foreach ($season->teams as $item)
                {
                    $arr[] = array(
                        'id' => $item->id,
                        'place' => $i,
                        'name' => $item->value,
                        'games' => 0,
                        'wins' => 0,
                        'draws' => 0,
                        'loss' => 0,
                        'goals_in' => 0,
                        'goals_out' => 0,
                        'goals_out' => 0,
                        'points' => 0
                    ); 
                    $i++;
                }

                $season->table = \Model_Table::forge(array(
                    'results_json' => json_encode($arr),
                    'show_on_main' => 0,
                ));
            }

            if ($season->save())
            {
                \Session::set_flash('success', 'Сезон (соревнование) обновлен(о).');

                \Response::redirect_back('admin/competitions/seasons');
            }

            else
            {
                \Session::set_flash('error', 'Could not update Season #' . $id);
            }
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                $season->value = $val->validated('value');
                $season->has_table = $val->validated('has_table');

                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('season', $season, false);
            
            // Все команды
            $this->template->set_global('teams', \Model_Team::get_teams_for_select(), false);
            
            // Массив id команд сезона
            $season_teams = array();
            foreach ($season->teams as $item)
            {
                $season_teams[] = $item->id;
            }
            $this->template->set_global('season_teams', $season_teams, false);
        }        

        $this->template->content = \View::forge('competitions/seasons/edit');

    }

    /**
     * Действие для удаления сезона
     * 
     * @param int $id
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/competitions/seasons');

        if ($season = \Model_Season::find($id))
        {
            $season->delete();

            \Session::set_flash('success', 'Сезон (соревнование) удалён(о).');
        }

        else
        {
            \Session::set_flash('error', 'Could not delete Season #'.$id);
        }

        \Response::redirect_back('admin/competitions/seasons');
    }
    
    public function action_get_teams_by_season()
    {        
        $data['teams'] = array();
        $data['teams'][] = array('id' => '', 'val' => '');
        $season = \Model_Season::find('first', array(
            'related' => 'teams',
            'where' => array(array('id', '=', \Input::get('season_id'))),
        ));
        foreach ($season->teams as $value)
        {
            $data['teams'][] = array('id' => $value->id, 'val' => $value->value);
        }
        
        return \View::forge('competitions/seasons/get_teams_by_season', $data);
    }
}
