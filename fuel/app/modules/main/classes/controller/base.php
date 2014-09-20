<?php

namespace Main;

/**
 * Базовый контроллер модуля
 */
class Controller_Base extends \Controller_Template
{
    // Шаблон модуля Admin
    public $template = 'template/template';
    
    public function before()
    {
        parent::before();
    }
}