<?php

namespace Admin;

class Controller_Media_Photos_List extends Controller_Admin
{
    public function before()
    {
        parent::before();
                        
        \View::set_global('subnav', array('media'=> 'active' ));
    }    
    
    /**
     * Действие для отображения списка фотографий категории
     */
    public function action_index($category_id = NULL)
    {
        is_null($category_id) and \Response::redirect('admin/media/photos/categories');
                
        if ( ! $data['category'] = \Model_Media_Photos_Category::find($category_id))
        {
            \Session::set_flash('error', 'Категория не найдена.');
            \Response::redirect('admin/media/photos/categories');
        }
                        
        // Пагинация
        $config = array(
            'pagination_url' => \URI::create('admin/media/photos/list/index/'.$category_id),
            'total_items'    => \Model_Media_Photo::count(array('where' => array(array('category_id' => $category_id)))),
            'per_page'       => 10,
            'uri_segment'    => 7,
        );
        $pagination = \Pagination::forge('categories_pagination', $config);
        $data['pagination'] = $pagination->render();
        
        $data['photos'] = \Model_Media_Photo::find('all', array(
            'where' => array(array('category_id', '=', $category_id)),
            'order_by' => array('created_at' => 'DESC') ,
            'offset' => $pagination->offset,
            'limit' => $pagination->per_page,
        ));
        
        $this->template->title = 'Фотогалерея "' . $data['category']->title . '"';
        $this->template->content = \View::forge('media/photos/list/index', $data, FALSE);
    }

    /**
     * Действие для создание фотографии
     * 
     * @param int $category_id
     */
    public function action_create($category_id = NULL)
    {
        is_null($category_id) and \Response::redirect('admin/media/photos/categories');
        
        if ( ! $data['category'] = \Model_Media_Photos_Category::find($category_id))
        {
            \Session::set_flash('error', 'Категория не найдена.');
            \Response::redirect_back('admin/media/photos/categories');
        }
        
        if (\Input::method() == 'POST')
        {
            $val = \Model_Media_Photo::validate('create');

            if ($val->run())
            {
                // Загружаем файл
                $config = array(
                    'path' => DOCROOT.'assets/img/gallery',
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                );
                \Upload::process($config);
                if (\Upload::is_valid())
                {
                    // Сохраняем файл на диск
                    \Upload::save();
                    
                    // Меняем размер изображения на 1024px * 768px
                    $files = \Upload::get_files();
                    $path = $files[0]['saved_to'] . $files[0]['saved_as'];
                    \Image::load($path)
                            ->resize(1024, 768, true)->save($path);
                    // Создаём thumbnail
                    $thumb_path = $files[0]['saved_to'] . 'thumbnails/' . $files[0]['saved_as'];
                    \Image::load($path)
                            ->resize(400, 300, true)->save($thumb_path);
                    
                    // Пишем инфу в БД
                    $photo = \Model_Media_Photo::forge(array(
                        'image_path' => $files[0]['saved_as'],
                        'category_id' => $category_id,
                    ));

                    if ($photo and $photo->save())
                    {
                        \Session::set_flash('success', 'Добавлено фото.');

                        \Response::redirect_back('admin/media/photos/list/index/'.$category_id);
                    }

                    else
                    {
                        \Session::set_flash('error', 'Could not save Media_Photo.');
                    }
                }
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = 'Фотогалерея "' . $data['category']->title . '"';
        $this->template->content = \View::forge('media/photos/list/create', $data, FALSE);

    }

    /**
     * Действие для редактирования фотографии
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect('admin/media/photos/categories');

        if ( ! $photo = \Model_Media_Photo::find($id, array('related' => 'category')))
        {
            \Session::set_flash('error', 'Фотография не найдена.');
            \Response::redirect('admin/media/photos/categories');
        }

        $val = \Model_Media_Photo::validate('edit');

        if ($val->run())
        {
            // Загружаем файл
            $config = array(
                'path' => DOCROOT.'assets/img/gallery',
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
            );
            \Upload::process($config);
            if (\Upload::is_valid())
            {
                // Сохраняем файл на диск
                \Upload::save();

                // Меняем размер изображения на 1024px * 768px
                $files = \Upload::get_files();
                $path = $files[0]['saved_to'] . $files[0]['saved_as'];
                \Image::load($path)
                    ->resize(1024, 768, true)->save($path);
                // Создаём thumbnail
                $thumb_path = $files[0]['saved_to'] . 'thumbnails/' . $files[0]['saved_as'];
                \Image::load($path)
                        ->resize(400, 300, true)->save($thumb_path);

                // Удаляем старые файлы
                unlink(DOCROOT . 'assets/img/gallery/' . $photo->image_path);
                unlink(DOCROOT . 'assets/img/gallery/thumbnails/' . $photo->image_path);

                // Пишем инфу в БД
                $photo->image_path = $files[0]['saved_as'];

                if ($photo->save())
                {
                    \Session::set_flash('success', 'Фотография обновлена.');

                    \Response::redirect('admin/media/photos/list/index/'.$photo->category->id);
                }

                else
                {
                    \Session::set_flash('error', 'Could not update Media_Photo #' . $id);
                }
            }   
        }
        else
        {
            if (\Input::method() == 'POST')
            {
                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('photo', $photo, false);
        }

        $this->template->title = 'Фотогалерея "' . $photo->category->title . '"';
        $this->template->content = \View::forge('media/photos/list/edit');

    }

    /**
     * Удаление фотографии
     * 
     * @param int $id
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/media/photos/categories');

        if ($photo = \Model_Media_Photo::find($id, array('related' => 'category')))
        {
            // Удаляем также изображение слайда с диска
            unlink(DOCROOT . 'assets/img/gallery/' . $photo->image_path);
            unlink(DOCROOT . 'assets/img/gallery/thumbnails/' . $photo->image_path);
            
            $category_id = $photo->category->id;
            
            // Удаляем из БД
            $photo->delete();
            
            \Session::set_flash('success', 'Фотография удалена.');
        }

        else
        {
            \Session::set_flash('error', 'Could not delete Media_Photo #'.$id);
        }
        
        if (isset($category_id))
        {
            \Response::redirect_back('admin/media/photos/list/index/'.$category_id);
        }
        else
        {
            \Response::redirect_back('admin/media/photos/categories');
        }
    }


}
