<?php

namespace Admin;

class Controller_Articles extends Controller_Admin
{

    public function before()
    {
        parent::before();
        \View::set_global('subnav', array('articles'=> 'active' ));
    }
    
    /**
     * Инлексная страница
     */
    public function action_index()
    {   
        // Если была отправлена форма фильтрации или сортировка
        if (\Input::method() == 'POST')
        {
            $category_id = (int) \Input::post('category_id');            
            if ($category_id > 0)
            {
                \Session::set('filter_articles_category_id', $category_id);
            }            
            else
            {
                \Session::set('filter_articles_category_id', null);                
            }
            
            $title = trim(\Input::post('title'));            
            \Session::set('filter_articles_title', $title);
            
            // Сортировка
            \Session::set('admin_articles_order_by', \Input::post('order_by', 'id'));
            \Session::set('admin_articles_order_method', \Input::post('order_method', 'desc'));
        }
        
        
       // Запрос на извлечение кол-ва статей
       $count = \Model_Article::get_articles_count(
                                    \Session::get('filter_articles_title'), 
                                    \Session::get('filter_articles_category_id')
        );

       // Пагинация
       $config = array(
           'pagination_url' => \URI::create('admin/articles/index'),
           'total_items'    => $count,
           'per_page'       => 15,
           'uri_segment'    => 4,
       );
       $pagination = \Pagination::forge('articles_pagination', $config);
       $data['pagination'] = $pagination->render();

       // Передаём в представление данные пагинации (для нумерации статей)
       $data['current_page'] = is_null($pagination->current_page) ? 1 : $pagination->current_page;
       $data['per_page'] = $pagination->per_page;

       // Получение статей
       $data['articles'] = \Model_Article::get_articles(\Session::get('filter_articles_title'),  
                                                        \Session::get('filter_articles_category_id'),
                                                        $pagination->per_page, 
                                                        $pagination->offset,
                                                        \Session::get('admin_articles_order_by', 'id'),
                                                        \Session::get('admin_articles_order_method', 'desc'));

       // Категории статей
       $data['categories'] = \Model_Category::get_categories_for_select();

       $this->template->title = "Статьи";
       $this->template->content = \View::forge('articles/index', $data, false);
    }

    /**
     * Страница создания статьи
     */
    public function action_create()
    {   
        // Если форма была отправлена
        if (\Input::method() == 'POST')
        {
            $val = \Model_Article::validate('create');

            if ($val->run())
            {
                // Создаём статью в таблице `articles`
                $article = \Model_Article::forge(array(
                    'title' => \Input::post('title'),
                    'preview' => \Input::post('preview'),
                    'full_text' => \Input::post('full_text'),
                    'category_id' => \Input::post('category_id'),
                    'on_main_page' => \Input::post('on_main_page', 0),
                    'vk_comments_count' => 0
                ));
                $article->save();
                               
                \Session::set_flash('success', e('Добавлена новая статья "'.$article->title.'".'));
                \Response::redirect('admin/articles');
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
        }
        
        // Категории статей
        $data['categories'] = \Model_Category::get_categories_for_select();
        
        $this->template->title = "Статьи";
        $this->template->content = \View::forge('articles/create', $data, false);

    }

    /**
     * Редактирование статьи
     * 
     * @param int $id id статьи
     * @param string $language язык
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect('admin/articles');
        
        $article = \Model_Article::find($id, array(
            'related' => 'category'
        ));        
        
        if (!empty($article))
        {
            $val = \Model_Article::validate('edit');

            if ($val->run())
            {
                $article->title = \Input::post('title');
                $article->category_id = \Input::post('category_id');  
                $article->on_main_page = \Input::post('on_main_page', 0);  
                $article->preview = \Input::post('preview');
                $article->full_text = \Input::post('full_text');

                if ($article->save())
                {
                    \Session::set_flash('success', e('Статья успешно отредактирована'));

                    \Response::redirect('admin/articles');
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
                    $article->title = $val->validated('title');
                    $article->category_id = $val->validated('category_id');  
                    $article->on_main_page = $val->validated('on_main_page');  
                    $article->preview = $val->validated('preview');
                    $article->full_text = $val->validated('full_text');

                    \Session::set_flash('error', $val->error());
                }

                $this->template->set_global('article', $article, false);
            }

           // Категории статей 
           $data['categories'] = \Model_Category::get_categories_for_select(); 

           $this->template->title = "Статьи";
           $this->template->content = \View::forge('articles/edit', $data, false);
        }
        else
        {
            throw new \HttpNotFoundException;
        }           
    }

    /**
     * Удаление статьи
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect('admin/articles');
        
        if ($article = \Model_Article::find($id))
        {
                $article->delete();

                \Session::set_flash('success', 'Статья успешно удалена');
        }

        else
        {
                \Session::set_flash('error', e('Could not delete articles_i18n #'.$id));
        }

        \Response::redirect('admin/articles');

    }
}