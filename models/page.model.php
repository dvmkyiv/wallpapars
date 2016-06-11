<?php

// Контроллер pages сможет обращаться к этой модели и получать данные.
// Эта модель содержит различные методы для вывода контента на страницах.
// Она наследует от класса Model только свойство $db, в котором есть объект базы данных.
// Объект этого класса храниться в свойстве контроллера PagesController.

class Page extends Model
{
    public function getList($only_published = false)
    {
        $sql = "select * from pages where 1";
        if ($only_published)
        {
            $sql .= " and is_published = 1";
        }
        return $this->db->query($sql);
    }



    public function getByAlias($alias)
    {
        $alias = $this->db->escape($alias);
        $sql   = "select * from pages where alias ='{$alias}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }



    // этот метод используется в админке.
    public function getById($id)
    {
        $id = (int) $id;
        $sql   = "select * from pages where id ='{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }



    public function getMenuItemById($id)
    {
        $id = (int) $id;
        $sql   = "select * from `pages_menu` where id ='{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }



    public function getPageMenu()
    {
        $sql   = "select * from `pages_menu` ORDER BY `number`";
        $result = $this->db->query($sql);
        return isset($result) ? $result : null;
    }



    public function save($data, $id = null)
    {
        if ( !isset($data['alias']) || !isset($data['title']) || !isset($data['content']) ) //  || !isset($data['is_published'])
        {
            // если этот метод возвращает false, то в контроллере инициализируется соответствующее сообщение.
            return false;
        }

        $id = (int) $id;
        $alias        = $this->db->escape($data['alias']);
        $title        = $this->db->escape($data['title']);
        $description  = $this->db->escape($data['description']);
        $keywords     = $this->db->escape($data['keywords']);
        $content      = $this->db->escape($data['content']);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if ( !$id )
        {
            $sql = "
                insert into pages
                  set alias = '{$alias}',
                      title = '{$title}',
                      description = '{$description}',
                      keywords = '{$keywords}',
                      content = '{$content}',
                      is_published = '{$is_published}'
            ";
        }
        else
        {
            $sql = "
                update pages
                  set alias = '{$alias}',
                      title = '{$title}',
                      description = '{$description}',
                      keywords = '{$keywords}',
                      content = '{$content}',
                      is_published = '{$is_published}'
                   where  id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }





    public function save_menu($data, $id = null)
    {
        if ( !isset($data['ancor']) || !isset($data['url']))
        {
            // если этот метод возвращает false, то в контроллере инициализируется соответствующее сообщение.
            return false;
        }

        $id = (int) $id;

        $ancor        = $this->db->escape($data['ancor']);
        $url          = $this->db->escape($data['url']);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if ( !$id )
        {
            // признак последнего пункта меню - его нет в столбце parent_id
            // получаем его
            // $sql = "SELECT id FROM `pages_menu` where id NOT IN (SELECT parent_id FROM `pages_menu`)";

            $sql = "SELECT MAX(number) FROM `pages_menu`";
            $number = $this->db->query($sql);
            $number = (int) $number[0]['MAX(number)'] + 1;


            $sql = "
                insert into `pages_menu`
                  set `number` = '{$number}',
                      ancor = '{$ancor}',
                      url = '{$url}',
                      is_published = '{$is_published}'
            ";
        }
        else
        {
            $sql = "
                update `pages_menu`
                  set ancor = '{$ancor}',
                      url = '{$url}',
                      is_published = '{$is_published}'
                   where  id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }



    // метод для поднятия пункта меню на уровень выше
    public function up_item_menu($id)
    {
        $id = (int) $id;

        /*
         * Алгоритм такой:
         * number содержит "важность по возрастанию".
         * Нам нужно просто поменять местами два поля number.
         * Проблема в том, как найти вторую запись - это максимальная среди меньших.
         */

        // получаем number поднимаемого пункта.
        // если он =0, значит это первый пункт и его поднять невозможно
        $sql = "select number from `pages_menu` where `id` = '{$id}'";
        $number = $this->db->query($sql);
        $number = (int) $number[0][number];

        if ( $number != 0 )
        {
            // теперь мне нужно найти пункт
            $sql = "SELECT MAX(number) AS number FROM `pages_menu` WHERE number IN (SELECT number FROM `pages_menu` WHERE number < '{$number}')";
            $g_number = $this->db->query($sql);
            $g_number = $g_number[0]['number'];

            $sql = "select id from `pages_menu` where `number` = '{$g_number}'";
            $g_id = $this->db->query($sql);
            $g_id = $g_id[0]['id'];

            // теперь мы имеем в переменных все данные.

            //
            $sql = "
                update pages_menu
                  set number = '{$g_number}'
                   where  id = '{$id}'
            ";
            $this->db->query($sql);

            //
            $sql = "
                update pages_menu
                  set number = '{$number}'
                   where  id = '{$g_id}'
            ";
            $this->db->query($sql);
            return true;
        }
        else
        {
            // это первый пункт, его невозможно поднять.
            return null;
        }

    }


    // метод для понижения пункта меню на один уровень
    public function dn_item_menu($id)
    {
        $id = (int) $id;

        /*
         * Алгоритм такой:
         * number содержит "важность по возрастанию".
         * Нам нужно просто поменять местами два поля number.
         *
         */

        // получаем number понижаемого пункта.
        $sql = "select number from `pages_menu` where `id` = '{$id}'";
        $number = $this->db->query($sql);
        $number = (int) $number[0][number];

        // получаем number следующего за понижаемым пунктом.
        // если он =0, значит это последний пункт и его понизить невозможно.
        $sql = "SELECT MIN(number) AS number FROM `pages_menu` WHERE number IN (SELECT number FROM `pages_menu` WHERE number > '{$number}')";
        $g_number = $this->db->query($sql);
        $g_number = (int) $g_number[0]['number'];

        if ( $g_number != 0 )
        {
//            echo "<pre>";
//            die( var_dump( $g_number ) );

            $sql = "select id from `pages_menu` where `number` = '{$g_number}'";
            $g_id = $this->db->query($sql);
            $g_id = $g_id[0]['id'];

            // теперь мы имеем в переменных все данные.

            //
            $sql = "
                update pages_menu
                  set number = '{$g_number}'
                   where  id = '{$id}'
            ";
            $this->db->query($sql);

            //
            $sql = "
                update pages_menu
                  set number = '{$number}'
                   where  id = '{$g_id}'
            ";
            $this->db->query($sql);
            return true;
        }
        else
        {
            // это первый пункт, его невозможно поднять.
            return null;
        }

    }





    // метод для поднятия пункта меню на уровень выше
    // не используется, основан на очереди в столбце важности.
    // были трудности с сортировкой массива меню.
    public function up_item_menu_1($id)
    {
        $id = (int) $id;

        /*
         * Алгоритм такой:
         * Если ( parent_id != 0 ), то
         * в id = parent_id присваиваем полю parent_id значение parent_id из id = id
         * а в текущий parent_id
         */

        // получаем parent_id поднимаемого пункта.
        // если он =0, значит это первый пункт и его поднять невозможно
        $sql = "select parent_id from `pages_menu` where `id` = '{$id}'";
        $parent_id = $this->db->query($sql);
        $parent_id = (int) $parent_id[0][parent_id];

        if ( $parent_id != 0 )
        {
            // теперь получаем дочерний пункт меню.
            // он нужен, в его parent_id мы запишем id родителя
            $sql = "select id from `pages_menu` where `parent_id` = '{$id}'";
            $daughter_id = $this->db->query($sql);
            $daughter_id = (int) $daughter_id[0][id];

            // получаем parent_id родительского пункта.
            $sql = "select parent_id from `pages_menu` where `id` = '{$parent_id}'";
            $g_parent_id = $this->db->query($sql);
            $g_parent_id = (int) $g_parent_id[0][parent_id];
//            die("GIP = " . $g_parent_id);

            // теперь есть parent_id родительского пункта
            // можно его затереть.
            $sql = "
                update pages_menu
                  set parent_id = '{$id}'
                   where  id = '{$parent_id}'
            ";
            $this->db->query($sql);

            // меняем parent_id поднимаемого пункта .
            $sql = "
                update pages_menu
                  set parent_id = '{$g_parent_id}'
                   where  id = '{$id}'
            ";
            $this->db->query($sql);

            // меняем parent_id дочернего пункта .
            $sql = "
                update pages_menu
                  set parent_id = '{$parent_id}'
                   where  id = '{$daughter_id}'
            ";
            $this->db->query($sql);
            return true;
        }
        else
        {
            // это первый пункт, его невозможно поднять.
            return null;
        }

    }





    // метод для удаления пункта меню из бд
    public function delete_item_menu($id)
    {
        $id = (int) $id;

//        // получаем parent_id удаляемого пункта.
//        $sql = "select parent_id from `pages_menu` where `id` = '{$id}'";
//        $parent_id = $this->db->query($sql);
//        $parent_id = (int) $parent_id[0][parent_id];
//
//        // получаем id дочки (следующего пункта)
//        $sql = "select id from `pages_menu` where `parent_id` = '{$id}'";
//
//        $daughter_id = $this->db->query($sql);
//        $daughter_id = (int) $daughter_id[0][id];
//
//        if ( $daughter_id != 0 )
//        {
//            $sql = "
//                update pages_menu
//                  set parent_id = '{$parent_id}'
//                   where  id = '{$daughter_id}'
//            ";
//            $this->db->query($sql);
//        }
//        else die('last');

        $sql = "delete from `pages_menu` where id = '{$id}'";
        return $this->db->query($sql);
    }


    // метод для удаления страницы из бд
    public function delete($id)
    {
        $id = (int) $id;
        $sql = "delete from pages where id = '{$id}'";
        return $this->db->query($sql);
    }

}