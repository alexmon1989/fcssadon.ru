<?php

namespace Admin;

class Controller_Players extends Controller_Admin
{
    public function before()
    {
        parent::before();
        
        $this->template->title = "Команда";
        \View::set_global('subnav', array('players'=> 'active' ));
    }
    
    /**
     * Действие для отображения списка игроков
     */
    public function action_index()
    {
        $data['players'] = \Model_Position::find('all', array(
                'related' => 'players',
                'order_by' => array('id' => 'ASC', 'players.player_name' => 'ASC')
            )
        );   
        $this->template->content = \View::forge('players/index', $data);
    }

    /**
     * Действие для создания игрока
     */
    public function action_create()
    {
        if (\Input::method() == 'POST')
        {
            $val = \Model_Player::validate('create');
            
            if ($val->run())
            {
                // Валидация для фото
                $config = array(
                    'path' => DOCROOT.'assets/img/players',
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                );
                \Upload::process($config);
                if (\Upload::is_valid() or \Upload::get_errors()[0]['errors'][0]['error'] == 4)
                {
                    $player = \Model_Player::forge(array(
                        'player_name' => \Input::post('player_name'),
                        'is_core_player' => \Input::post('is_core_player', 0),
                        'position_id' => \Input::post('position_id'),
                        'birthdate' => strtotime(\Input::post('birthdate')),
                        'data' => \Input::post('data'),
                    ));
                    
                    if (!\Upload::get_errors())
                    {
                        // Сохраняем файл на диск
                        \Upload::save();

                        // Меняем размер изображения на 350px * 466px
                        $files = \Upload::get_files();
                        $path = $files[0]['saved_to'] . $files[0]['saved_as'];
                        \Image::load($path)
                                ->resize(350, 466, true)->save($path);
                        
                        $player->image_uri = $files[0]['saved_as'];
                    }
                    
                    // Пишем инфу в БД                    
                    if ($player and $player->save())
                    {
                            \Session::set_flash('success', 'Игрок создан.');

                            \Response::redirect_back('admin/players');
                    }

                    else
                    {
                            \Session::set_flash('error', 'Could not save Player.');
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

        $this->template->content = \View::forge('players/create');

    }

    /**
     * Действие для редактирования данных игрока
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/players');

        if ( ! $player = \Model_Player::find($id))
        {
            \Session::set_flash('error', 'Игрок не найден.');
            \Response::redirect_back('admin/players');
        }

        $val = \Model_Player::validate('edit');

        if ($val->run())
        {
            // Валидация для фото
            $config = array(
                'path' => DOCROOT.'assets/img/players',
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
            );
            \Upload::process($config);
            
            if (\Upload::is_valid() or \Upload::get_errors()[0]['errors'][0]['error'] == 4)
            {
                $player->player_name = \Input::post('player_name');
                $player->is_core_player = \Input::post('is_core_player', 0);
                $player->position_id = \Input::post('position_id');
                $player->birthdate = strtotime(\Input::post('birthdate'));
                $player->data = \Input::post('data');
                
                if (!\Upload::get_errors())
                {
                    // Сохраняем файл на диск
                    \Upload::save();

                    // Меняем размер изображения на 350px * 466px
                    $files = \Upload::get_files();
                    $path = $files[0]['saved_to'] . $files[0]['saved_as'];
                    \Image::load($path)
                            ->resize(350, 466, true)->save($path);

                    // Удаляем старый файл
                    if ($player->image_uri)
                        unlink(DOCROOT . 'assets/img/players/' . $player->image_uri);
                    
                    $player->image_uri = $files[0]['saved_as'];
                }

                if ($player->save())
                {
                    \Session::set_flash('success', 'Игрок обновлён.');

                    \Response::redirect('admin/players');
                }

                else
                {
                    Session::set_flash('error', 'Could not update Player #' . $id);
                }
            }            
            
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                $player->player_name = $val->validated('player_name');
                $player->is_core_player = $val->validated('is_core_player');
                $player->position_id = $val->validated('position_id');
                $player->birthdate = strtotime($val->validated('birthdate'));
                $player->data = $val->validated('data');

                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('player', $player, false);
        }

        $this->template->content = \View::forge('players/edit');

    }

    /**
     * Удаление игрока
     * 
     * @param int $id
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/players');

        if ($player = \Model_Player::find($id))
        {
            if ($player->image_uri)
                unlink(DOCROOT . 'assets/img/players/' . $player->image_uri);
            $player->delete();

            \Session::set_flash('success', 'Игрок удалён.');
        }

        else
        {
            \Session::set_flash('error', 'Could not delete Player #'.$id);
        }

        \Response::redirect_back('admin/players');

    }
}
