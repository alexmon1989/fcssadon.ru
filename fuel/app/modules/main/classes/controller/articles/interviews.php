<?php
/**
 * Контроллер для отображения интервью
 */
namespace Main;

class Controller_Articles_Interviews extends Controller_Articles_Base
{   
    public function before() {
                
        $this->category_id = 3;
        $this->title = 'Интервью';
        $this->uri = 'interviews';
        
        parent::before();
    }
}
