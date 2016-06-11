<?php
//

class Pagination
{
    public $buttons = array();      // массив кнопок (экземпляры класса Button)


    // общее количество элементов (например, статей, продукции, комментариев и т.п.)
    // количество элементов на страницу
    // значение текущей страницы
    public function __construct(Array $options = array('itemsCount' => 111, 'itemsPerPage' => 10, 'currentPage' => 1))
    {
        extract($options);
        $pagesCount = ceil($itemsCount / $itemsPerPage);

        if (!$currentPage)      { return; }
        if ($pagesCount == 1)   { return; }

        if ($currentPage > $pagesCount)
        {
            $currentPage = $pagesCount;
        }

        if ( $currentPage > 1 )
        $this->buttons[] = new Button($currentPage - 1, true, '&laquo;');

        if ( $pagesCount <= 7 )
        {
            for ($i = 1; $i <= $pagesCount; $i++)
            {
                $active = $currentPage != $i;
                $this->buttons[] = new Button($i, $active);
            }
        }
        else
        {
            // у нас всегда есть первый и последний элемент

            // добавляем первый элемент
            $active = $currentPage != 1;
            $this->buttons[] = new Button(1, $active);

            // тут циклом наполняем меню пагинации.
            if ( $currentPage <= 4 )
            {
                for ($i = 2; $i <= ($currentPage+3); $i++)
                {
                    $active = $currentPage != $i;
                    $this->buttons[] = new Button($i, $active);
                }
                // вставляем неактивное троеточие
                $this->buttons[] = new Button(false, true, '&hellip;');

                // добавляем последний элемент
                $active = $currentPage != $pagesCount;
                $this->buttons[] = new Button($pagesCount, $active);
            }

            if ( $currentPage > 4 and $currentPage < ($pagesCount-3) )
            {
                // вставляем неактивное троеточие
                $this->buttons[] = new Button(false, true, '&hellip;');

                for ($i = ($currentPage-3); $i <= ($currentPage+3); $i++)
                {
                    $active = $currentPage != $i;
                    $this->buttons[] = new Button($i, $active);
                }
                // вставляем неактивное троеточие
                $this->buttons[] = new Button(false, true, '&hellip;');

                // добавляем последний элемент
                $active = $currentPage != $pagesCount;
                $this->buttons[] = new Button($pagesCount, $active);
            }

            if ( $currentPage >= ($pagesCount-3) )
            {
                // вставляем неактивное троеточие
                $this->buttons[] = new Button(false, true, '&hellip;');

                for ($i = ($currentPage-3); $i <= $pagesCount; $i++)
                {
                    $active = $currentPage != $i;
                    $this->buttons[] = new Button($i, $active);
                }
            }

        }

        if ( $currentPage < $pagesCount )
        $this->buttons[] = new Button($currentPage + 1, true, '&raquo;');
    }
}