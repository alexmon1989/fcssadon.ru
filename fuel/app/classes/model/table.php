<?php
use Orm\Model;

class Model_Table extends Model
{
	protected static $_properties = array(
		'id',
		'results_json',
		'season_id',
		'show_on_main',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
        
        protected static $_belongs_to = array(
            'season' => array(
                'key_from' => 'season_id',
                'model_to' => 'Model_Season',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            )
        );
        
        public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('results_json', 'Results Json', 'required');
		$val->add_field('season_id', 'Season Id', 'required|valid_string[numeric]');
		$val->add_field('show_on_main', 'Show On Main', 'required|valid_string[numeric]');

		return $val;
	}

	public static function validate_result_item($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('games', 'Игр', 'required|valid_string[numeric]|numeric_min[0]');
		$val->add_field('wins', 'Побед', 'required|valid_string[numeric]|numeric_min[0]');
		$val->add_field('draws', 'Ничьих', 'required|valid_string[numeric]|numeric_min[0]');
		$val->add_field('loss', 'Поражений', 'required|valid_string[numeric]|numeric_min[0]');
		$val->add_field('goals_out', 'Количество забитых голов', 'required|valid_string[numeric]|numeric_min[0]');
		$val->add_field('goals_in', 'Количество пропущенных голов', 'required|valid_string[numeric]|numeric_min[0]');
		$val->add_field('points', 'очков', 'required|valid_string[numeric]|numeric_min[0]');

		return $val;
	}
        
        public static function edit_table($season_id, $team1_id, $team2_id, $team1_goals, $team2_goals)
        {
            $table = self::find('first', array(
                'where' => array(array('season_id', '=', $season_id))
            ));             
            
            if ($table)
            {
                $results = json_decode($table->results_json);
                foreach ($results as $key => $item)
                {
                    if ($item->id == $team1_id)
                    {
                        $results[$key]->games++;
                        if ($team1_goals > $team2_goals)
                        {
                            $results[$key]->wins++;
                            $results[$key]->points += 3;
                        }
                        if ($team1_goals < $team2_goals)
                        {
                            $results[$key]->loss++;
                        }
                        if ($team1_goals == $team2_goals)
                        {
                            $results[$key]->draws++;
                            $results[$key]->points += 1;
                        }
                        $results[$key]->goals_in += $team2_goals;
                        $results[$key]->goals_out += $team1_goals;
                        
                        continue;
                    }
                    
                    if ($item->id == $team2_id)
                    {
                        $results[$key]->games++;
                        if ($team1_goals < $team2_goals)
                        {
                            $results[$key]->wins++;
                            $results[$key]->points += 3;
                        }
                        if ($team1_goals > $team2_goals)
                        {
                            $results[$key]->loss++;
                        }
                        if ($team1_goals == $team2_goals)
                        {
                            $results[$key]->draws++;
                            $results[$key]->points += 1;
                        }
                        $results[$key]->goals_in += $team1_goals;
                        $results[$key]->goals_out += $team2_goals;
                        
                        continue;
                    }
                }
                
                // Теперь делаем сортировку по местам
                usort($results, array("Model_Table", "cmp_obj"));
                // И присваиваем новые значения очков - значение ключа плюс 1
                foreach ($results as $key => $item)
                {
                    $results[$key]->place = $key+1;
                }
                
                $table->results_json = json_encode($results);
                
                $table->save();
                
                return TRUE;
            }
            else
                return FALSE;
        }

        /**
         * Функция сравнения для сортировки таблицы по местам
         * 
         * @return int
         */
        static function cmp_obj($a, $b)
        {
            // Очков К1
            $points_t1 = $a->points;
            // Очков К2
            $points_t2 = $b->points;
            
            if ($points_t1 == $points_t2) {
                // Сравниваем по разнице забитых/пропущенных
                $goals_diff_t1 = $a->goals_out - $a->goals_in;
                $goals_diff_t2 = $b->goals_out - $b->goals_in;
                if ($goals_diff_t1 == $goals_diff_t2)
                {
                    // Если и тут паритет, то смотрим у кого больше забито
                    $goals_out_t1 = $a->goals_out;
                    $goals_out_t2 = $b->goals_out;
                    if ($goals_out_t1 == $goals_out_t2)
                        return 0;
                    else
                        return ($goals_out_t1 > $goals_out_t2) ? -1 : +1;
                }
                else
                    return ($goals_diff_t1 > $goals_diff_t2) ? -1 : +1;
            }
            return ($points_t1 > $points_t2) ? -1 : +1;
        }
}
