<?php
/**
 * Контроллер для отображения детальной таблицы турнира
 */
namespace Main;

class Controller_Table extends Controller_Base
{
    public function before() 
    {
        parent::before();
        
        \View::set_global('page_title', 'Таблица');
    }


    /**
     * Действие для отображения
     */
    public function action_index($season_id)
    {
        // Извлекаем из БД таблицу для главной
        $data['table'] = \Model_Table::find('first', array(
            'related' => 'season',
            'where' => array(array('season_id', '=', $season_id))
        ));
        
        if ($data['table'])
        {
            $data['table']->results = json_decode($data['table']->results_json);
            // Сортируем по очкам            
            usort($data['table']->results, array('Main\Controller_Table', 'cmp'));
            
            // Извлекаем команды сезона для получения их картинок
            $season_teams = \Model_Team::find('all', array(
                'related' => 'seasons',
                'where' => array(array('seasons.id', '=' , $season_id))
            ));
            foreach ($data['table']->results as $key => $result_item)
            {
                foreach ($season_teams as $team)
                {
                    if ($result_item->id == $team->id)
                    {
                        $data['table']->results[$key]->logo_uri = $team->logo_uri;
                        break;
                    }
                }               
            }
        }
        
        $this->template->content = \View::forge('table/index', $data, FALSE);
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
