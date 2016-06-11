<?php
//

class Button
{
    public $page;       // номер страницы
    public $text;       // текст на кнопке
    public $isActive;   // "активность", три значения: active, link, hellip.

    public function __construct($page, $isActive = true, $text = null)
    {
        $this->page = $page;
        $this->text = is_null($text) ? $page : $text;
        $this->isActive = $isActive;
    }
}