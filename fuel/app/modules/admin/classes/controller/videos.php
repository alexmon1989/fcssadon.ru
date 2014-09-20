<?php

namespace Admin;

class Controller_Videos extends Controller_Admin
{
    public function before() 
    {
        parent::before();
        $this->template->title = 'Видео';
        \View::set_global('subnav', array('videos'=> 'active'));
    }
    
    /**
     * Список видео
     */
    public function action_index()
    {
        $data['videos'] = \Model_Video::find('all');
        
        $this->template->content = \View::forge('videos/index', $data);
    }

    /**
     * Создание новой записи
     */
    public function action_create()
    {
        if (\Input::method() == 'POST')
        {
            $val = \Model_Video::validate('create');

            if ($val->run())
            {
                $video = \Model_Video::forge(array(
                        'videoid' => \Input::post('videoid'),
                ));

                if ($video and $video->save())
                {
                        \Session::set_flash('success', 'Видео добавлено.');

                        \Response::redirect_back('admin/videos');
                }

                else
                {
                        \Session::set_flash('error', 'Could not save video.');
                }
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->content = \View::forge('videos/create');

    }

    /**
     * Редактирование записи
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/videos');

        if ( ! $video = \Model_Video::find($id))
        {
            \Session::set_flash('error', 'Невозможно найти видео #'.$id);
            \Response::redirect_back('admin/videos');
        }

        $val = \Model_Video::validate('edit');

        if ($val->run())
        {
            $video->videoid = \Input::post('videoid');

            if ($video->save())
            {
                \Session::set_flash('success', 'Видео обновлено.');

                \Response::redirect_back('admin/videos');
            }

            else
            {
                \Session::set_flash('error', 'Could not update video #' . $id);
            }
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                $video->videoid = $val->validated('videoid');

                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('video', $video, false);
        }

        $this->template->content = \View::forge('videos/edit');

    }

    /**
     * Удаление записи
     * 
     * @param int $id
     */
    public function action_delete($id = null)
    {
            is_null($id) and \Response::redirect_back('admin/videos');

            if ($video = \Model_Video::find($id))
            {
                    $video->delete();

                    \Session::set_flash('success', 'Видео удалено.');
            }

            else
            {
                    \Session::set_flash('error', 'Could not delete video #'.$id);
            }

            \Response::redirect_back('admin/videos');

    }


}
