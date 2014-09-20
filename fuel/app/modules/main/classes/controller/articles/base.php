<?php
/**
 * Контроллер для отображения новостей
 */
namespace Main;

class Controller_Articles_Base extends Controller_Base
{
    protected $category_id = 1;
    protected $title = 'Новости ФК "Шахтёр Садон"';
    protected $uri = 'shahter';
    
    public function before() 
    {
        parent::before();
        \View::set_global('page_title', $this->title);
        \View::set_global('uri', $this->uri);
    }

    /**
     * Действие для отображения списка новостей
     */
    public function action_index()
    {
        // Запрос на извлечение количества статей
        $count = \Model_Article::get_articles_count(NULL, $this->category_id);

        // Пагинация
        $config = array(
                'pagination_url' => \URI::create("news/{$this->uri}/page"),
                'total_items'    => $count,
                'per_page'       => 6,
                'uri_segment'    => 4,
        );
        $pagination = \Pagination::forge('news_pagination', $config);
        $data['pagination'] = $pagination->render();

        // Получение статей
        $data['articles'] = \Model_Article::get_articles('',
                                                    $this->category_id,
                                                    $pagination->per_page, 
                                                    $pagination->offset);

        $this->template->content = \View::forge('articles/index', $data, FALSE);
    }
    
    /**
     * Действие для просмотра новости
     * 
     * @param int $article_id
     */
    public function action_view($article_id)
    {
        is_null($article_id) and \Response::redirect('');

        // Получаем новость
        $data['article'] = \Model_Article::query()
                                ->where('category_id', $this->category_id) // чтобы точно знать, что это именно новость
                                ->where('id', $article_id)
                                ->get_one();
        // Если такой статьи нет, то отображаем страницу 404
        if (is_null($data['article']))
            throw new \HttpNotFoundException;

        // Передаем данные в вид         
        $this->template->page_title = $this->template->page_title . ' :: ' . $data['article']->title;
        $this->template->content = \View::forge('articles/view', $data, FALSE);
    }
    
    /**
     * Дейсвтие-обработчик ПОСТ-запроса на изменения кол-ва комментов ВК
     */
    public function action_change_comments_num()
    {
        if (\Input::method() == 'POST')
        {
            $id = (int) \Input::post('id');
            $num = (int) \Input::post('num');
            
            if ($id != 0)
            {
                $article = \Model_Article::find($id);
                if ($article)
                {
                    $article->vk_comments_count = $num;
                    $article->save();
					
					return \View::forge('empty', array());
                }
            }
        }
    }
}
