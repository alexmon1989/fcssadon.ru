<?php

/**
 * Контроллер для управления таблицами результатов
 */
namespace Admin;

class Controller_Competitions_Tables extends Controller_Admin
{
    public function before()
    {
        parent::before();
        \View::set_global('subnav', array('competitions'=> 'active'));
        
        $this->template->title = "Таблицы результатов";
    }
    
    /**
     * Действие для отображения списка таблиц результатов
     */
    public function action_index()
    {
        // Пагинация
        $config = array(
            'pagination_url' => \URI::create('admin/competitions/tables/index'),
            'total_items'    => \Model_Table::count(),
            'per_page'       => 10,
            'uri_segment'    => 5,
        );
        $pagination = \Pagination::forge('tables_pagination', $config);
        $data['pagination'] = $pagination->render();
        
        // Извлечения данных из БД
        $data['tables'] = \Model_Table::find('all', array(
            'related' => 'season',
            'order_by' => array('id' => 'DESC'),
            'offset' => $pagination->offset,
            'limit' => $pagination->per_page,
        ));
        $this->template->content = \View::forge('competitions/tables/index', $data);
    }

    /**
     * Действие для редактирования
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/competitions/tables');

        if ( ! $table = \Model_Table::find($id))
        {
            \Session::set_flash('error', 'Таблица не найдена.');
            \Response::redirect_back('admin/competitions/tables');
        }

        $val = \Model_Table::validate('edit');

        if ($val->run())
        {
            $table->results_json = \Input::post('results_json');
            $table->season_id = \Input::post('season_id');
            $table->show_on_main = \Input::post('show_on_main');

            if ($table->save())
            {
                \Session::set_flash('success', 'Updated table #' . $id);

                \Response::redirect_back('admin/competitions/tables');
            }

            else
            {
                \Session::set_flash('error', 'Could not update table #' . $id);
            }
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                $table->results_json = $val->validated('results_json');
                $table->season_id = $val->validated('season_id');
                $table->show_on_main = $val->validated('show_on_main');

                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('table', $table, false);
        }

        $this->template->content = \View::forge('competitions/tables/edit');

    }
    
    /**
     * Редактирование данных команды в таблице 
     * 
     * @param int $table_id id таблицы
     * @param int $team_id id команды
     */
    public function action_edit_result($table_id = null, $team_id = null)
    {
        (is_null($table_id) or is_null($team_id)) and \Response::redirect_back('admin/competitions/tables');
        
        // Проверяем существует ли такая таблица
        if ( ! $table = \Model_Table::find($table_id))
        {
            \Session::set_flash('error', 'Таблица не найдена.');
            \Response::redirect_back('admin/competitions/tables');
        }
        
        // Проверяем существует ли такая команда в ней
        $results = json_decode($table->results_json);
        foreach ($results as $key => $item)
        {
            if ($item->id == $team_id)
            {
                $key_num = $key;
                break;
            }
        }
        if (!isset($key_num))
        {
            \Session::set_flash('error', 'Запись в таблице не найдена.');
            \Response::redirect_back('admin/competitions/tables/edit/'.$table_id);
        }
        
        $val = \Model_Table::validate_result_item('edit');

        if ($val->run())
        {
            $results[$key_num]->games = \Input::post('games');
            $results[$key_num]->wins = \Input::post('wins');
            $results[$key_num]->draws = \Input::post('draws');
            $results[$key_num]->loss = \Input::post('loss');
            $results[$key_num]->goals_out = \Input::post('goals_out');
            $results[$key_num]->goals_in = \Input::post('goals_in');
            $results[$key_num]->points = \Input::post('points');
            $table->results_json = json_encode($results);

            if ($table->save())
            {
                \Session::set_flash('success', 'Запись обновлена.');

                \Response::redirect_back('admin/competitions/tables/edit/'.$table_id);
            }

            else
            {
                \Session::set_flash('error', 'Could not update item id=' . $team_id);
            }
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                

                \Session::set_flash('error', $val->error());
            }

            // Передаём данные в вид 
            $this->template->set_global('data', $results[$key_num], false);
            $this->template->set_global('table_id', $table_id, false);
        }
        
        $this->template->content = \View::forge('competitions/tables/edit_result');
    }
    
    /**
     * Действие-обработчик AJAX-запроса на утсановку таблицы на главную страницу
     * 
     * @param type $id
     */
    public function action_set_table_on_main()
    {
        $data['result'] = FALSE;
        if (\Input::method() == 'POST')
        {
            
            $id = \Input::post('id');
            \Input::post('show') == 'true' ? $show = 1 : $show = 0;
            
            // проверяем существует ли запись с таким id
            if ($item = \Model_Table::find($id))
            {
                // Ставим всем таблицам 0 в поле show_on_main
                $q = 'UPDATE tables SET show_on_main = 0';
                \DB::query($q)->execute();
                
                $item->show_on_main = $show;
                $item->save();      
                
                $show == 1 ? $message = 'Таблица поставлена на главную страницу.' : $message = 'Таблица убрана с главной страницы.';
                \Session::set_flash('success', $message);
                
                $data['result'] = TRUE;                
            }
        }
        
        return \View::forge('competitions/tables/set_table_on_main', $data);
    }
    
    /**
     * Действие увеличение позиции команды в таблице
     */    
    public function action_increase_team_position($table_id = null, $team_id = null)
    {
        (is_null($table_id) or is_null($team_id)) and \Response::redirect_back('admin/competitions/tables');
        
        // Проверяем существует ли такая таблица
        if ( ! $table = \Model_Table::find($table_id))
        {
            \Session::set_flash('error', 'Таблица не найдена.');
            \Response::redirect_back('admin/competitions/tables');
        }
        
        // Проверяем существует ли такая команда в ней
        $results = json_decode($table->results_json);
        foreach ($results as $key => $item)
        {
            // если такая команда найдена, то запоминаем место команды, 
            // место которой увеличиваем и той, место которой нужно уменьшить
            if ($item->id == $team_id)
            {
                $key_inc = $key;
                
                foreach ($results as $k => $i)
                {
                    if ($results[$k]->place == ($results[$key_inc]->place + 1))
                    {   
                        $key_dec = $k;
                        break;
                    }
                }
                
                break;
            }
        }
        if (!isset($key_inc))
        {
            \Session::set_flash('error', 'Запись в таблице не найдена.');
            \Response::redirect_back('admin/competitions/tables/edit/'.$table_id);
        }
        
        // Меняем местами команды и сохраняемся
        if (isset($key_inc) and isset($key_dec))
        {
            $results[$key_inc]->place += 1;
            $results[$key_dec]->place -= 1; 
            $table->results_json = json_encode($results);
            $table->save();
        }
        \Session::set_flash('success', 'Действие успешно совершено.');
        \Response::redirect_back('admin/competitions/tables/edit/'.$table_id);
    }
    
    /**
     * Действие уменьшение позиции команды в таблице
     */    
    public function action_decrease_team_position($table_id = null, $team_id = null)
    {
        (is_null($table_id) or is_null($team_id)) and \Response::redirect_back('admin/competitions/tables');
        
        // Проверяем существует ли такая таблица
        if ( ! $table = \Model_Table::find($table_id))
        {
            \Session::set_flash('error', 'Таблица не найдена.');
            \Response::redirect_back('admin/competitions/tables');
        }
        
        // Проверяем существует ли такая команда в ней
        $results = json_decode($table->results_json);
        foreach ($results as $key => $item)
        {
            // если такая команда найдена, то запоминаем место команды, 
            // место которой увеличиваем и той, место которой нужно уменьшить
            if ($item->id == $team_id)
            {
                $key_dec = $key;
                
                foreach ($results as $k => $i)
                {
                    if ($results[$k]->place == ($results[$key_dec]->place - 1))
                    {   
                        $key_inc = $k;
                        break;
                    }
                }
                
                break;
            }
        }
        if (!isset($key_dec))
        {
            \Session::set_flash('error', 'Запись в таблице не найдена.');
            \Response::redirect_back('admin/competitions/tables/edit/'.$table_id);
        }
        
        // Меняем местами команды и сохраняемся
        if (isset($key_inc) and isset($key_dec))
        {
            $results[$key_inc]->place += 1;
            $results[$key_dec]->place -= 1; 
            $table->results_json = json_encode($results);
            $table->save();
        }
        \Session::set_flash('success', 'Действие успешно совершено.');
        \Response::redirect_back('admin/competitions/tables/edit/'.$table_id);
    }


}
