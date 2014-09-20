<?php
namespace Admin;

class Controller_Media_Videos extends Controller_Admin
{
     public function before()
    {
        parent::before();
                
        $this->template->title = "Видеогалерея";
        
        \View::set_global('subnav', array('media'=> 'active' ));
    }
    
    /**
     * Действие для вывода списка видео
     */
    public function action_index()
    {
        // Пагинация
        $config = array(
            'pagination_url' => \URI::create('admin/media/videos/index'),
            'total_items'    => \Model_Media_Video::count(),
            'per_page'       => 10,
            'uri_segment'    => 5,
        );
        $pagination = \Pagination::forge('videos_pagination', $config);
        $data['pagination'] = $pagination->render();
        
        $data['videos'] = \Model_Media_Video::find('all', array(
            'order_by' => array('created_at' => 'DESC'),
            'offset' => $pagination->offset,
            'limit' => $pagination->per_page,
        ));
        $this->template->content = \View::forge('media/videos/index', $data, FALSE);
    }
    
    /**
     * Действие для создания видео
     */
    public function action_create()
    {
        if (\Input::method() == 'POST')
        {
            $val = \Model_Media_Video::validate('create');

            if ($val->run())
            {
                $video = \Model_Media_Video::forge(array(
                        'videoid' => \Input::post('videoid'),
                        'title' => \Input::post('title'),
                ));

                if ($video and $video->save())
                {
                    \Session::set_flash('success', 'Видео добавлено.');

                    \Response::redirect_back('admin/media/videos');
                }

                else
                {
                    \Session::set_flash('error', 'Could not save Media_Video.');
                }
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->content = \View::forge('media/videos/create');

    }

    /**
     * Редактирование видео
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
            is_null($id) and \Response::redirect_back('admin/media/videos');

            if ( ! $video = \Model_Media_Video::find($id))
            {
                \Session::set_flash('error', 'Видеозапись не найдена.');
                \Response::redirect('admin/media/videos');
            }

            $val = \Model_Media_Video::validate('edit');

            if ($val->run())
            {
                $video->videoid = \Input::post('videoid');
                $video->title = \Input::post('title');

                if ($video->save())
                {
                    \Session::set_flash('success', 'Видеозапись обновлена.');

                    \Response::redirect_back('admin/media/videos');
                }

                else
                {
                    \Session::set_flash('error', 'Could not update Media_Video #' . $id);
                }
            }

            else
            {
                    if (\Input::method() == 'POST')
                    {
                            $video->videoid = $val->validated('videoid');
                            $video->title = $val->validated('title');

                            \Session::set_flash('error', $val->error());
                    }

                    $this->template->set_global('video', $video, false);
            }

            $this->template->content = \View::forge('media/videos/edit');

    }

    /**
     * Удаление видео
     * 
     * @param int $id
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/media/videos');

        if ($video = \Model_Media_Video::find($id))
        {
                $video->delete();

                \Session::set_flash('success', 'Видео удалено.');
        }

        else
        {
                \Session::set_flash('error', 'Could not delete Media_Video #'.$id);
        }

        \Response::redirect_back('admin/media/videos');

    }

}
