<?php
/**
 * Контроллер для отображения новостей
 */
namespace Main;

class Controller_News extends Controller_Base
{
    /**
     * Действие для отображения списка новостей
     */
    public function action_index()
    {
        // Запрос на извлечение количества статей
        $count = \Model_Article::get_articles_count(NULL, 1);

        // Пагинация
        $config = array(
                'pagination_url' => \URI::create('news/page'),
                'total_items'    => $count,
                'per_page'       => 6,
                'uri_segment'    => 3,
        );
        $pagination = \Pagination::forge('news_pagination', $config);
        $data['pagination'] = $pagination->render();

        // Получение статей
        $data['news'] = \Model_Article::get_articles('',
                                                    1,
                                                    $pagination->per_page, 
                                                    $pagination->offset);

        $this->template->content = \View::forge('news/index', $data, FALSE);
    }
    
    /**
     * Действие для просмотра новости
     * 
     * @param int $news_id
     */
    public function action_view($news_id)
    {
        is_null($news_id) and \Response::redirect('');

        // Получаем новость
        $data['news'] = \Model_Article::query()
                                ->where('category_id', 1) // чтобы точно знать, что это именно новость
                                ->where('id', $news_id)
                                ->get_one();
        // Если такой статьи нет, то отображаем страницу 404
        if (is_null($data['news']))
            throw new \HttpNotFoundException;

        // Передаем данные в вид 
        $this->template->content = \View::forge('news/view', $data, FALSE);
    }
}
