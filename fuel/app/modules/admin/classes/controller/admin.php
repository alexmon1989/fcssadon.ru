<?php

namespace Admin;

class Controller_Admin extends Controller_Base
{
	public $template = 'template';

	public function before()
	{
            parent::before();

            if (\Request::active()->controller !== 'Admin\Controller_Admin' or ! in_array(\Request::active()->action, array('login', 'logout')))
            { 
                    if (\Auth::check())
                    {
                            $admin_group_id = \Config::get('auth.driver', 'Simpleauth') == 'Ormauth' ? 6 : 100;
                            if ( ! \Auth::member($admin_group_id))
                            {
                                    \Session::set_flash('error', e('You don\'t have access to the admin panel'));
                                    \Response::redirect('/');
                            }
                    }
                    else
                    {
                            \Response::redirect('admin/login');
                    }
            }
	}

        /**
         * Действие для авторизации пользователя
         */
	public function action_login()
	{
            // Already logged in
            \Auth::check() and \Response::redirect('admin/articles');

            $val = \Validation::forge();

            if (\Input::method() == 'POST')
            {
                    $val->add('email', 'Логин')
                        ->add_rule('required');
                    $val->add('password', 'Пароль')
                        ->add_rule('required');

                    if ($val->run())
                    {
                            $auth = \Auth::instance();

                            // check the credentials. This assumes that you have the previous table created
                            if (\Auth::check() or $auth->login(\Input::post('email'), \Input::post('password')))
                            {
                                    // credentials ok, go right in
                                    if (\Config::get('auth.driver', 'Simpleauth') == 'Ormauth')
                                    {
                                            $current_user = \Model\Auth_User::find_by_username(\Auth::get_screen_name());
                                    }
                                    else
                                    {
                                            $current_user = \Model_User::find_by_username(\Auth::get_screen_name());
                                    }
                                    \Session::set_flash('success', 'Добро пожаловать, <b>'.$current_user->username.'</b>');
                                    \Response::redirect('admin/articles');
                            }
                            else
                            {
                                    \Session::set_flash('error', 'Неверная комбинация логина и пароля.');
                            }
                    }
            }

            $this->template->title = 'Авторизация';
            $this->template->content = \View::forge('login', array('val' => $val), false);
	}

	/**
	 * The logout action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_logout()
	{
		\Auth::logout();
		\Response::redirect('admin/login');
	}

	/**
	 * The index action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_index()
	{            
            \Response::redirect('admin/articles');
	}

}

/* End of file admin.php */
