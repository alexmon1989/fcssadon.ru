<?php

/**
 * Контроллер для управления командами
 */
namespace Admin;

class Controller_Competitions_Teams extends Controller_Admin
{
    public function before()
    {
        parent::before();
        \View::set_global('subnav', array('competitions'=> 'active'));
        
        $this->template->title = "Команды";
    }

    /**
     * Список всех команд
     */
    public function action_index()
    {
        $data['teams'] = \Model_Team::find('all', array('order_by' => array('value' => 'ASC')));
        $this->template->content = \View::forge('competitions/teams/index', $data);
    }

    /**
     * Действие для создания команды
     */
    public function action_create()
    {
        if (\Input::method() == 'POST')
        {
            $val = \Model_Team::validate('create');

            if ($val->run())
            {
                // Валидация для фото
                $config = array(
                    'path' => DOCROOT.'assets/img/teams',
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                );
                \Upload::process($config);
                if (\Upload::is_valid() or \Upload::get_errors()[0]['errors'][0]['error'] == 4)
                {
                    $team = \Model_Team::forge(array(
                        'value' => \Input::post('value'),
                    ));
                    
                    if (!\Upload::get_errors())
                    {
                        // Сохраняем файл на диск
                        \Upload::save();

                        // Меняем размер изображения на 50px * 50px
                        $files = \Upload::get_files();
                        $path = $files[0]['saved_to'] . $files[0]['saved_as'];
                        \Image::load($path)
                                ->resize(50, 50, true)->save($path);
                        
                        $team->logo_uri = $files[0]['saved_as'];
                    }     
                    
                    if ($team and $team->save())
                    {
                        \Session::set_flash('success', 'Команда добавлена.');

                        \Response::redirect_back('admin/competitions/teams');
                    }
                    else
                    {
                        \Session::set_flash('error', 'Could not save Team.');
                    }                    
                }   
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
                        
            // Если есть ошибки при сохранении файла
            foreach (\Upload::get_errors() as $file)
            {
                if (isset($file['errors'][0]) and $file['errors'][0]['error'] != 4)
                    \Session::set_flash('error', $file['errors'][0]['message']);
            }
        }

        $this->template->content = \View::forge('competitions/teams/create');

    }

    /**
     * Редактирование команды
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect('teams');

        if ( ! $team = \Model_Team::find($id))
        {
            \Session::set_flash('error', 'Команда не найдена.');
            \Response::redirect_back('admin/competitions/teams');
        }

        $val = \Model_Team::validate('edit');

        if ($val->run())
        {
            // Валидация для фото
            $config = array(
                'path' => DOCROOT.'assets/img/teams',
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
            );
            \Upload::process($config);
            
            if (\Upload::is_valid() or \Upload::get_errors()[0]['errors'][0]['error'] == 4)
            {
                $team->value = \Input::post('value');
                
                if (!\Upload::get_errors())
                {
                    // Сохраняем файл на диск
                    \Upload::save();

                    // Меняем размер изображения на 50px * 50px
                    $files = \Upload::get_files();
                    $path = $files[0]['saved_to'] . $files[0]['saved_as'];
                    \Image::load($path)
                            ->resize(50, 50, true)->save($path);

                    // Удаляем старый файл
                    if ($team->logo_uri)
                        unlink(DOCROOT . 'assets/img/teams/' . $team->logo_uri);
                    
                    $team->logo_uri = $files[0]['saved_as'];
                }
                
                if ($team->save())
                {
                        \Session::set_flash('success', 'Команда обновлена.');

                        \Response::redirect_back('admin/competitions/teams');
                }

                else
                {
                        Session::set_flash('error', 'Could not update Team #' . $id);
                }
            }    
        }
        else
        {
                if (\Input::method() == 'POST')
                {
                        $team->value = $val->validated('value');

                        \Session::set_flash('error', $val->error());
                }

                $this->template->set_global('team', $team, false);
        }

        $this->template->content = \View::forge('competitions/teams/edit');

    }

    /**
     * Удаление команды
     * 
     * @param int $id
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/competitions/teams');

        if ($team = \Model_Team::find($id))
        {
            if ($team->logo_uri)
                unlink(DOCROOT . 'assets/img/teams/' . $team->logo_uri);
            $team->delete();

            \Session::set_flash('success', 'Команда удалена.');
        }

        else
        {
            \Session::set_flash('error', 'Could not delete Team #'.$id);
        }

        \Response::redirect_back('admin/competitions/teams');

    }


}
