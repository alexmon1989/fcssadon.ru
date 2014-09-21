<?php
/**
 * Контроллер для отображения новостей
 */
namespace Main;

class Controller_Widgets extends Controller_Base
{
    /**
     * Действие для отображения слайдера
     */
    public function action_slider()
    {      
        // Выбираем первых 5 слайдеров
        $data['slider'] = \Model_Slider::query()
                ->where('position', '<=', 5)
				->order_by(array('position' => 'ASC'))
                ->get();
        
        return \View::forge('widgets/slider', $data)->render();
    }
    
    /**
     * Действие для отображения слайдера
     */
    public function action_videos()
    {      
        // Выбираем первых 5 слайдеров
        $data['videos'] = \Model_Video::find('all');
        
        return \View::forge('widgets/videos', $data)->render();
    }
    
    /**
     * Действие для отображения именинников
     */
    public function action_birthdays()
    {
        $q = 'SELECT * '
            . 'FROM players '
            . 'WHERE is_core_player = 1 '
            . 'AND MONTH(FROM_UNIXTIME(birthdate)) = MONTH(NOW()) '
            . 'AND DAYOFMONTH(FROM_UNIXTIME(birthdate)) >= DAYOFMONTH(NOW()) '
            . 'ORDER BY DAYOFMONTH(FROM_UNIXTIME(birthdate))';
        
        // Выборка оставшихся именинников в этом месяце
        $data['birthdays'] = \DB::query($q)->as_object('Model_Player')->execute();
        
        return \View::forge('widgets/birthdays', $data, FALSE)->render();
    }
    
    /**
     * Действие для отображения голосований
     */
    public function action_votes()
    {
        $votes = \Model_Vote::find(1);
        
        // Проверяем включён ли виджет
        if ($votes->enable)
        {        
            $data['question'] = $votes->question;
            $data['answers'] = json_decode($votes->answers_json);

            // Если пользователь нажал "Проголосовать"
            if (\Input::method() == 'POST')
            {
                if (\Input::post('answers'))
                {
                    // Прибавляем 1 к счётчику ответа
                    foreach ($data['answers'] as $key => $item)
                    {
                        if (\Input::post('answers') == $item->answer)
                        {
                            $data['answers'][$key]->count++;
                        }
                    }
                    $votes->answers_json = json_encode($data['answers']);
                    $votes->save();

                    // Записываем куку на месяц
                    \Cookie::set('vote_'.$votes->hash, 1, 60*60*24*31);

                    \Response::redirect_back('');
                }
            }

            // Если пользователь проголосовал
            if (\Cookie::get('vote_'.$votes->hash))
            {
                // Количество голосов
                $data['count'] = 0;
                foreach ($data['answers'] as $item)
                {
                    $data['count'] += $item->count;
                }
                return \View::forge('widgets/votes/results', $data, FALSE)->render();
            }
            else
            {
                return \View::forge('widgets/votes/quiz', $data, FALSE)->render();
            }
        }
        else
        {
            return \View::forge('widgets/votes/empty')->render();
        }
    }
    
    /**
     * Действие для отображение следующего матча
     */
    public function action_next_match()
    {
        $data['match'] = \Model_Match::query()
                ->related(array('team_1', 'team_2', 'status'))
                ->where_open()
                ->where('team_1_id', \Config::get('main_team_id'))
                ->or_where('team_2_id', \Config::get('main_team_id'))
                ->where_close()
                //->where('date', '>=', time())
                ->where('status_id', '=', 1) // матч не начался
                ->order_by('id', 'ASC')
                ->limit(1)
                ->get_one();
        
        return \View::forge('widgets/next_match', $data)->render();
    }
    
    /**
     * Действие для отображение предыдущего матча
     */
    public function action_previous_match()
    {
        $data['match'] = \Model_Match::query()
                ->related(array('team_1', 'team_2', 'status'))
                ->where_open()
                ->where('team_1_id', \Config::get('main_team_id'))
                ->or_where('team_2_id', \Config::get('main_team_id'))
                ->where_close()
                ->where('date', '<', time())
                ->where('status_id', '=', 2) // матч завершен
                ->order_by('date', 'DESC')
                ->limit(1)
                ->get_one();
        
        return \View::forge('widgets/previous_match', $data)->render();
    }
    
    /**
     * Действие для отображения бомбардиров
     */
    public function action_strikers()
    {
        // Извлекаем настройки из БД
        $data['settings'] = \Model_Striker::find('first');
        
        if ($data['settings']->show == 1)
        {
            // Считаем голы игроков
            
            $data['season'] = \Model_Season::find($data['settings']->season_id);
            
            \Config::load('my_config');
            $team_id = \Config::get('main_team_id');
            
            
            $sql = "SELECT COUNT(`m_e`.`player`) AS `goals`, `m_e`.`player` AS `player`
                FROM `matches_events` AS `m_e`                 
                LEFT JOIN `matches` AS `m` ON (`m_e`.`match_id` = `m`.`id`) 
                WHERE `m_e`.`event_id` = 1  
                      AND `m`.`status_id` = 2 
                      AND `m_e`.`team_id` = {$team_id}
                      AND (`m`.`team_1_id` = {$team_id} OR `m`.`team_2_id` = {$team_id})
                      AND `m`.`season_id` = {$data['settings']->season_id}    
                GROUP BY `m_e`.`player`
                ORDER BY `goals` DESC
                LIMIT 5";
            
            $data['goals'] = \DB::query($sql)->execute();
        }
        
        return \View::forge('widgets/strikers', $data, FALSE)->render();
    }

    /**
     * Действие для отображение виджета турнирной таблицы
     */
    public function action_table()
    {
        // Извлекаем из БД таблицу для главной
        $table = \Model_Table::find('first', array(
            'where' => array(array('show_on_main', '=', 1))
        ));
        
        $data['results'] = array();
        if ($table)
        {
            // Сортируем по очкам            
            $data['results'] = json_decode($table->results_json);
            usort($data['results'], array('Main\Controller_Widgets', 'cmp'));
            $data['season_id'] = $table->season_id;
        }
        
        return \View::forge('widgets/table', $data, FALSE)->render();
    }
    
    /**
     * Функция сортировки
     */
    function cmp($a, $b)
    {
        if ($a->place == $b->place) {
            return 0;
        }
        return ($a->place < $b->place) ? -1 : 1;
    }
}
