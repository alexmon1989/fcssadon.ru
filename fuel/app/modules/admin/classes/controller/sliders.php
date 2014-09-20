<?php

namespace Admin;

/**
 * Контроллер для управления слайдерами
 */
class Controller_Sliders extends Controller_Admin
{

    public function before() 
    {
        parent::before();
        \View::set_global('subnav', array('sliders'=> 'active'));
    }

    /**
     * Действия для отображения всех слайдеров
     */
    public function action_index()
    {        
        // Получаем слайдеры
        $data['sliders'] = \Model_Slider::find('all', array('order_by' => 'position'));
        
        // Передаём данные в вид и отображаем страницу
        $this->template->title = "Слайдеры";
        $this->template->content = \View::forge('sliders/index', $data);
    }

    /**
     * Действие для создания слайдера
     */
    public function action_create()
    {
        // Если форма была отправлена
        if (\Input::method() == 'POST')
        {
            $val = \Model_Slider::validate('create');
            if ($val->run())
            {                
                // Загружаем файл
                $config = array(
                    'path' => DOCROOT.'assets/img/slider',
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                );
                \Upload::process($config);
                if (\Upload::is_valid())
                {
                    // Сохраняем файл на диск
                    \Upload::save();
                    
                    // Меняем размер изображения на 650px * 435px
                    $files = \Upload::get_files();
                    $path = $files[0]['saved_to'] . $files[0]['saved_as'];
                    \Image::load($path)
                            ->resize(650, 435, false)->save($path);
                    
                    // Пишем инфу в БД
                    $slider = \Model_Slider::forge(array(
                            'img_path' => $files[0]['saved_as'],
                            'uri' => \Input::post('uri'),
                            'description' => \Input::post('description'),
                            'position' => \Model_Slider::max('position') + 1,
                    ));

                    if ($slider and $slider->save())
                    {
                        \Session::set_flash('success', 'Слайд добавлено.');

                        \Response::redirect('admin/sliders/index');
                    }
                    else
                    {
                        \Session::set_flash('error', 'Ошибка при создании слайда.');
                    }
                    
                }
            }
            else
            {
                \Session::set_flash('error', $val->error());
            }
            
            // Если есть ошибки при сохранении файла
            foreach (\Upload::get_errors() as $file)
            {
                if (isset($file['errors'][0]))
                    \Session::set_flash('error', $file['errors'][0]['message']);
            }
        }
        
        $this->template->title = "Слайдеры";
        $this->template->content = \View::forge('sliders/create');
    }

    /**
     * Действие для редактирования слайдера
     * 
     * @param int $id
     */
    public function action_edit($id = null)
    {
        is_null($id) and \Response::redirect('sliders');

        if ( ! $slider = \Model_Slider::find($id))
        {
            \Session::set_flash('error', 'Невозможно найти слайдер');
            \Response::redirect('admin/sliders/index');
        }
                        
        $val = \Model_Slider::validate('edit');
        if ($val->run())
        {
            // Загружаем файл
            $config = array(
                'path' => DOCROOT.'assets/img/slider',
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
            );
            \Upload::process($config);
            if (\Upload::is_valid())
            {
                // Сохраняем файл на диск
                \Upload::save();
                
                // Меняем размер изображения на 650px * 435px
				$files = \Upload::get_files();
                $path = $files[0]['saved_to'] . $files[0]['saved_as'];
                \Image::load($path)
                    ->resize(650, 435, false)->save($path);
                
                // Удаляем старый файл
                unlink(DOCROOT . 'assets/img/slider/' . $slider->img_path);

                // Пишем инфу в БД
                $slider->img_path = $files[0]['saved_as'];
                $slider->description = \Input::post('description');    
                $slider->uri = \Input::post('uri');    

                if ($slider->save())
                {
                    \Session::set_flash('success', 'Слайд отредактировано.');

                    \Response::redirect('admin/sliders/index');
                }
                else
                {
                    \Session::set_flash('error', 'Ошибка при редактировании слайда.');
                }
            }
            else
            {
                // Если есть ошибки при сохранении файла
                foreach (\Upload::get_errors() as $file)
                {
                    if (isset($file['errors'][0]))
                        \Session::set_flash('error', $file['errors'][0]['message']);
                }
            }
        }
        else
        {
            if (\Input::method() == 'POST')
            {
                $slider->uri = $val->validated('uri');
                $slider->description = $val->validated('description');

                \Session::set_flash('error', $val->error());
            }
        }                  

        $this->template->set_global('slider', $slider, false);
        $this->template->title = "Слайды";
        $this->template->content = \View::forge('sliders/edit');
    }

    /**
     * Действие для удаления слайдера
     * 
     * @param int $id
     */
    public function action_delete($id = null)
    {
        is_null($id) and \Response::redirect('sliders');

        if ($slider = \Model_Slider::find($id))
        {
            // Удаляем также изображение слайда с диска
            unlink(DOCROOT . 'assets/img/slider/' . $slider->img_path);
            
            $slider->delete();

            \Session::set_flash('success', 'Слайд удалён');
        }

        else
        {
            \Session::set_flash('error', 'Невозможно удалить слайд');
        }

        \Response::redirect('admin/sliders/index');
    }
    
    /**
     * Увеличение позиции слайдера
     * 
     * @param int $id
     */
    public function action_increase_pos($id = null)
    {
        // Получаем элемент текущую позицию
        $slider_1 = \Model_Slider::find($id);
        
        // Получаем элемент с позицией, которую необходимо уменьшить
        $slider_2 = \Model_Slider::find('first', array(
                        'where' => array(
                            array('position', ($slider_1->position + 1)),
                        ),
                   ));
        
        // Если элемент $slider_1 не последний
        if (!is_null($slider_2))
        {
            // Увеличиваем позицию
            $slider_1->position = $slider_1->position + 1;
            $slider_1->save();
        
            // Уменьшаем позицию
            $slider_2->position = $slider_2->position - 1;
            $slider_2->save();
            
            \Session::set_flash('success', 'Позиция слайда увеличена.');
        }
        else
        {
            \Session::set_flash('error', 'Невозможно увеличить позицию последнего слайда.');
        }
        
        \Response::redirect('admin/sliders/index');        
    }
    
    /**
     * Уменьшение позиции слайдера
     * 
     * @param int $id
     */
    public function action_decrease_pos($id = null)
    {
        // Получаем элемент текущую позицию
        $slider_1 = \Model_Slider::find($id);
        
        // Получаем элемент с позицией, которую необходимо увеличть
        $slider_2 = \Model_Slider::find('first', array(
                        'where' => array(
                            array('position', ($slider_1->position - 1)),
                        ),
                   ));
        
        // Если элемент $slider_1 не первый
        if (!is_null($slider_2))
        {
            // Уменьшаем позицию
            $slider_1->position = $slider_1->position - 1;
            $slider_1->save();
        
            // Увеличиваем позицию
            $slider_2->position = $slider_2->position + 1;
            $slider_2->save();
            
            \Session::set_flash('success', 'Позиция слайда уменьшена.');
        }
        else
        {
            \Session::set_flash('error', 'Невозможно уменьшить позицию первого слайда.');
        }
        
        \Response::redirect('admin/sliders/index');
    }
}
