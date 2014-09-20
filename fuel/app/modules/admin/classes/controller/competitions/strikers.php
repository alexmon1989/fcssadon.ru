<?php

/**
 * Контроллер для управления настройками отображения бомбардиров
 */
namespace Admin;

class Controller_Competitions_Strikers extends Controller_Admin
{
    public function before()
    {
        parent::before();
        \View::set_global('subnav', array('competitions'=> 'active'));
        
        $this->template->title = "Бомбардиры";
    }
    
    /**
     * Действие для управления настройками
     */
    public function action_index()
    {
        $settings = \Model_Striker::find('first');
        
        $seasons = \Model_Season::get_seasons_for_select();
        
        if (\Input::method() == 'POST')
        {
            $settings->show = \Input::post('show', 0);
            $settings->season_id = \Input::post('season_id');
            $settings->save();
            
            \Session::set_flash('success', 'Настройки обновлены.');
            \Response::redirect_back('admin/competitions/strikers');
        }
        
        \View::set_global('seasons', $seasons);
        \View::set_global('settings', $settings);
        
        $this->template->content = \View::forge('competitions/strikers/index', array('settings' => $settings));
    }
}
