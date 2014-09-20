<?php

namespace Admin;

class Controller_Categories extends Controller_Admin
{
    public function before()
    {
        parent::before();
        \View::set_global('subnav', array('articles'=> 'active' ));
    }

    /**
     * Индексная страница
     */
    public function action_index()
    {
        // Извлекаем категории из БД
        $data['categories'] = \Model_Category::find('all', 
                              array('related' => 'articles',
                                   'order_by' => array('value' => 'ASC')));
        
        $this->template->title = 'Статьи';
        $this->template->content = \View::forge('categories/index', $data);
    }

    /**
     * Страница создания категории
     */
    public function action_create()
    {
        // Если форма была отправлена
        if (\Input::method() == 'POST')
        {
            $val = \Model_Category::validate('create');

            if ($val->run())
            {
                // Создаём статью в таблице `articles`
                $category = \Model_Category::forge(array(
                    'value' => \Input::post('value'),
                ));
                $category->save();    

                \Session::set_flash('success', 'Добавлена новая категория <b>"'.$category->value.'</b>".');
                \Response::redirect('admin/categories');
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
        }
        
        $this->template->title = 'Статьи';
        $this->template->content = \View::forge('categories/create');
    }

    /**
     * Страница редактирования категории
     */
    public function action_edit($id = null)
    {
        is_null($id) and Response::redirect('admin/articles/categories');
        
        $category = \Model_Category::find($id);
        if (empty($category))
            throw new \HttpNotFoundException; 

        $val = \Model_Category::validate('edit');

        if ($val->run())
        {
            $category->value = \Input::post('value');

            if ($category->save())
            {
                \Session::set_flash('success', e('Категория успешно отредактирована'));

                \Response::redirect('admin/categories');
            }

            else
            {
                \Session::set_flash('error', e('Невозможно отредактировать статью' . $id));
            }
        }

        else
        {
            if (\Input::method() == 'POST')
            {
                $category->value = $val->validated('value');

                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('category', $category, false);
        }
        
       $this->template->title = "Статьи";
       $this->template->content = \View::forge('categories/edit');
    }
    
    /**
     * Действие для удаления категории
     * 
     * @param integer $id
     */
    public function action_delete($id = null)
    {
        is_null($id) and Response::redirect('admin/categories');
        
        $category = \Model_Category::find($id, array('related' => 'articles'));
       
        if (!empty($category) and empty($category->articles))
        {
                $category->delete();

                \Session::set_flash('success', 'Категория успешно удалена');
        }
        else
        {
                \Session::set_flash('error', 'Невозможно удалить категорию. Скорее всего существуют статьи, принадлежащие к ней.');
        }

        \Response::redirect('admin/categories');
    }

}
