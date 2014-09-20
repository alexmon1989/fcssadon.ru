<?php

namespace Admin;

class Controller_Media_Photos_Categories extends Controller_Admin
{
    public function before()
    {
        parent::before();
                
        $this->template->title = "Фотогалереи";
        
        \View::set_global('subnav', array('media'=> 'active' ));
    }    

    /**
     * Действие для вывода списка категорий
     */
    public function action_index()
    {
        // Пагинация
        $config = array(
            'pagination_url' => \URI::create('admin/media/photos/categories/index'),
            'total_items'    => \Model_Media_Photos_Category::count(),
            'per_page'       => 10,
            'uri_segment'    => 6,
        );
        $pagination = \Pagination::forge('categories_pagination', $config);
        $data['pagination'] = $pagination->render();
        
        $data['сategories'] = \Model_Media_Photos_Category::find('all', array(
            'related' => 'photos',
            'order_by' => array('created_at' => 'DESC'),
            'offset' => $pagination->offset,
            'limit' => $pagination->per_page,
        ));
        $this->template->content = \View::forge('media/photos/categories/index', $data, FALSE);
    }

    /**
     * Действие для создание категории
     */
    public function action_create()
    {
        if (\Input::method() == 'POST')
        {
            $val = \Model_Media_Photos_Category::validate('create');

            if ($val->run())
            {
                $category = \Model_Media_Photos_Category::forge(array(
                        'title' => \Input::post('title'),
                ));

                if ($category and $category->save())
                {
                    \Session::set_flash('success', 'Добавлена новая галерея.');
                    \Response::redirect_back('admin/media/photos/categories');
                }

                else
                {
                    \Session::set_flash('error', 'Could not save Media_Photos_Category.');
                }
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->content = \View::forge('media/photos/categories/create');
    }

    /**
     * Редактирование категории
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect('media/photos/categories');

        if ( ! $category = \Model_Media_Photos_Category::find($id))
        {
            \Session::set_flash('error', 'Галерея не найдена.');
            \Response::redirect_back('admin/media/photos/categories');
        }

        $val = \Model_Media_Photos_Category::validate('edit');

        if ($val->run())
        {
                $category->title = \Input::post('title');

                if ($category->save())
                {
                    \Session::set_flash('success', 'Галерея обновлена.');
                    \Response::redirect_back('admin/media/photos/categories');
                }

                else
                {
                    \Session::set_flash('error', 'Could not update Media_Photos_Category #' . $id);
                }
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                    $category->title = $val->validated('title');

                    \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('category', $category, false);
        }

        $this->template->content = \View::forge('media/photos/categories/edit');

    }

    /**
     * Действие для удаления категории
     * 
     * @param int $id
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect_back('admin/media/photos/categories');

        if ($category = \Model_Media_Photos_Category::find($id, array('related' => 'photos')))
        {
            // Удаляем все фото галереи
            foreach ($category->photos as $item)
            {
                unlink(DOCROOT . 'assets/img/gallery/' . $item->image_path);
                unlink(DOCROOT . 'assets/img/gallery/thumbnails/' . $item->image_path);
            }
            
            $category->delete();

            \Session::set_flash('success', 'Галерея удалена.');
        }

        else
        {
            \Session::set_flash('error', 'Could not delete Media_Photos_Category #'.$id);
        }

        \Response::redirect_back('admin/media/photos/categories');

    }


}
