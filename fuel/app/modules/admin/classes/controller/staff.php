<?php
/**
 * Контроллер для управления персоналом
 */

namespace Admin;

class Controller_Staff extends Controller_Admin
{
    public function before()
    {
        parent::before();
        
        $this->template->title = "Команда";
        \View::set_global('subnav', array('players'=> 'active' ));
    }
    
    /**
     * Действие для отображения списка персонала
     */
    public function action_index()
    {
        $data['staff'] = \Model_Staff::find('all', array(
                'order_by' => array('staff_name' => 'ASC')
            )
        );   
        $this->template->content = \View::forge('staff/index', $data);
    }

    /**
     * Действие для создания игрока
     */
    public function action_create()
    {
        if (\Input::method() == 'POST')
        {
            $val = \Model_Staff::validate('create');
            
            if ($val->run())
            {
                // Валидация для фото
                $config = array(
                    'path' => DOCROOT.'assets/img/staff',
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                );
                \Upload::process($config);
                if (\Upload::is_valid() or \Upload::get_errors()[0]['errors'][0]['error'] == 4)
                {
                    $player = \Model_Staff::forge(array(
                        'staff_name' => \Input::post('staff_name'),
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
                            \Session::set_flash('success', 'Персонал создан.');

                            \Response::redirect_back('admin/staff');
                    }

                    else
                    {
                            \Session::set_flash('error', 'Could not save Staff.');
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

        $this->template->content = \View::forge('staff/create');

    }

    /**
     * Действие для редактирования данных игрока
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/players');

        if ( ! $staff = \Model_Staff::find($id))
        {
            \Session::set_flash('error', 'Персонал не найден.');
            \Response::redirect_back('staff/players');
        }

        $val = \Model_Staff::validate('edit');

        if ($val->run())
        {
            // Валидация для фото
            $config = array(
                'path' => DOCROOT.'assets/img/staff',
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
            );
            \Upload::process($config);
            
            if (\Upload::is_valid() or \Upload::get_errors()[0]['errors'][0]['error'] == 4)
            {
                $staff->staff_name = \Input::post('staff_name');
                $staff->birthdate = strtotime(\Input::post('birthdate'));
                $staff->data = \Input::post('data');
                
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
                    if ($staff->image_uri)
                        unlink(DOCROOT . 'assets/img/staff/' . $staff->image_uri);
                    
                    $staff->image_uri = $files[0]['saved_as'];
                }

                if ($staff->save())
                {
                    \Session::set_flash('success', 'Персонад обновлён.');

                    \Response::redirect('admin/staff');
                }

                else
                {
                    Session::set_flash('error', 'Could not update Staff #' . $id);
                }
            }            
            
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                $staff->staff_name = $val->validated('staff_name');
                $staff->birthdate = strtotime($val->validated('birthdate'));
                $staff->data = $val->validated('data');

                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('staff', $staff, false);
        }

        $this->template->content = \View::forge('staff/edit');

    }

    /**
     * Удаление игрока
     * 
     * @param int $id
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/staff');

        if ($staff = \Model_Staff::find($id))
        {
            if ($staff->image_uri)
                unlink(DOCROOT . 'assets/img/staff/' . $staff->image_uri);
            $staff->delete();

            \Session::set_flash('success', 'Персонал удалён.');
        }

        else
        {
            \Session::set_flash('error', 'Could not delete Ыефаа #'.$id);
        }

        \Response::redirect_back('admin/staff');

    }
}
