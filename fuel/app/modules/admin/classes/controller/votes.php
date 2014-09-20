<?php

/**
 * Контроллер для управления модулем голосований
 */
namespace Admin;

class Controller_Votes extends Controller_Admin
{
    public function before() 
    {
        parent::before();
        $this->template->title = 'Голосования';
        \View::set_global('subnav', array('votes'=> 'active'));
    }
	
    /**
     * Редактирование голосования
     */
    public function action_edit()
    {
        if ( ! $vote = \Model_Vote::find(1))
        {
            \Session::set_flash('error', 'Нет записи в БД. Обратитесь к разработчику.');
            \Response::redirect('admin/articles');
        }
        $vote->answers = json_decode($vote->answers_json);

        $val = \Model_Vote::validate('edit');

        if ($val->run())
        {
            $vote->question = \Input::post('question');
            $vote->enable = \Input::post('enable');
            
            // Варианты ответов
            $answers = array();
            for ($i=1; $i<=10; $i++)
            {
                if (\Input::post('reset') == 1)
                    $answers[] = array('answer' => \Input::post('answer_'.$i), 'count' => 0);
                else
                    $answers[] = array('answer' => \Input::post('answer_'.$i), 'count' => $vote->answers[$i-1]->count);                    
            }            
            $vote->answers_json = json_encode($answers);
            
            // Hash для кукисов
            if (\Input::post('reset') == 1)
                $vote->hash = md5(date('Y-m-d H:i:s'));

            if ($vote->save())
            {
                \Session::set_flash('success', 'Голосование обновлено.');

                \Response::redirect('admin/votes/edit');
            }

            else
            {
                \Session::set_flash('error', 'Could not update Vote #' . $id);
            }
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                $vote->question = $val->validated('question');
                $vote->answers_json = $val->validated('answers_json');
                $vote->hash = $val->validated('hash');
                $vote->enable = $val->validated('enable');

                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('vote', $vote, false);
        }

        $this->template->content = \View::forge('votes/edit');

    }
}
