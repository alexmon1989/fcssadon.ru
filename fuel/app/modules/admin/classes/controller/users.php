<?php

namespace Admin;

class Controller_Users extends Controller_Admin
{
    public function before()
    {
        parent::before();
        \View::set_global('subnav', array('users'=> 'active' ));
    }

    /**
     * Индексная страница (отображение всех пользователей)
     */
    public function action_index()
    {
        // Извлекаем пользователей из БД
        $data['users'] = \Model_User::find('all');
        
        $this->template->title = 'Пользователи';
        $this->template->content = \View::forge('users/index', $data);
    }

    /**
     * Добавление нового пользователя
     */
    public function action_create()
    {
        if (\Input::method() == 'POST')
        {
            $val = \Model_User::validate('create');

            if ($val->run())
            {
                try
                {
                    $created = \Auth::create_user(
                            \Input::post('username'),
                            \Input::post('password'),
                            \Input::post('email'),
                            \Config::get('application.user.default_group', 100)
                    );
                    
                    if ($created)
                    {
                        \Session::set_flash('success', e('Добавлен новый пользователь'));
                        \Response::redirect_back('admin/users');
                    }
                    else
                    {
                        // oops, creating a new user failed?
                        \Session::set_flash('error', e('Не удалось создать пользователя'));
                    }
                    
                }
                // исключения от вызова create_user()
                catch (\SimpleUserUpdateException $e)
                {
                    // Повтор е-мэил
                    if ($e->getCode() == 2)
                    {
                        \Session::set_flash('error', e('E-Mail существует'));
                    }

                    // Повтор логина
                    elseif ($e->getCode() == 3)
                    {
                        \Session::set_flash('error', e('Логин существует'));
                    }

                    // Этого не должно произойти, но как знать..
                    else
                    {
                        \Messages::error($e->getMessage());
                    }
                }
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
        }
        
        $this->template->title = 'Пользователи';
        $this->template->content = \View::forge('users/create');
    }

    /**
     * Редактирование пользователя
     * 
     * @param integer $id id пользователя
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect('admin/users');
        
        $user = \Model_User::find($id);
        if (!empty($user))
        {
            if (\Input::method() == 'POST')
            {
                $val = \Model_User::validate('edit');
                
                // Если ихменили E-Mail
                if (\Input::post('email') != $user->email)
                {
                    $val->add_callable(new \MyRules());
                    $val->add_field('email', 'E-Mail', 'required|max_length[255]|unique[users.email]');
                    $val->set_message('unique', 'E-Mail существует.');
                }
                
                if ($val->run())
                {
                    try
                    {
                        // Сбрасіваем пароль
                        $new_password = \Auth::reset_password($user->username);
                        
                        $arr = array(
                            'email'        => \Input::post('email'),
                        );
                        if (trim(\Input::post('password') != ''))
                        {
                            $arr['old_password'] = $new_password;
                            $arr['password'] = \Input::post('password');
                        }
                        $updated = \Auth::update_user($arr, $user->username);                                                

                        if ($updated)
                        {
                            \Session::set_flash('success', e('Пользователь отредактирован'));
                            \Response::redirect_back('admin/users');
                        }
                        else
                        {
                            // oops, creating a new user failed?
                            \Session::set_flash('error', e('Не удалось отредактировать данные пользователя'));
                        }

                    }
                    // исключения от вызова create_user()
                    catch (\SimpleUserUpdateException $e)
                    {
                        // Повтор е-мэил
                        if ($e->getCode() == 2)
                        {
                            \Session::set_flash('error', e('E-Mail существует'));
                        }

                        // Этого не должно произойти, но как знать..
                        else
                        {
                            \Session::set_flash('error', $e->getMessage());
                        }
                    }
                }
                else
                {
                    \Session::set_flash('error', $val->error());
                }
            }
            
            \View::set_global('user', $user, FALSE);
            $this->template->title = 'Пользователи';
            $this->template->content = \View::forge('users/edit');
        }
        else 
        {
            \Session::set_flash('error', e('Пользователь отсутствует'));
            \Response::redirect('admin/users');
        }
    }
    
    /**
     * Удаление пользователя
     * 
     * @param integer $id id пользователя
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect('admin/users');
        
        $user = \Model_User::find($id);
        if (!empty($user))
        {
            \Auth::delete_user($user->username);
            \Session::set_flash('success', e('Пользователь удалён')); 
            \Response::redirect('admin/users');
        }
        else 
        {
            \Session::set_flash('error', e('Пользователь отсутствует'));
            \Response::redirect('admin/users');
        }
    }
}
