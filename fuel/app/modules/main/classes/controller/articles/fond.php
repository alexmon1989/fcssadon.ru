<?php
/**
 * Контроллер для отображения интервью
 */
namespace Main;

class Controller_Articles_Fond extends Controller_Articles_Base
{   
    public function before() {
                
        $this->category_id = 4;
        $this->title = 'Фонд "Быть добру"';
        $this->uri = 'fond';
        
        parent::before();
    }
}