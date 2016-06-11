<?php

class Wallpaper extends Model
{

    public function getWallpapersMenu()
    {
        $sql   = "select * from `wallpapers_menu` ORDER BY `number`";
        $result = $this->db->query($sql);
        return isset($result) ? $result : null;
    }


    public function getMenuItemById($id)
    {
        $id = (int) $id;
        $sql   = "select * from `wallpapers_menu` where id ='{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
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
            // старый комментарий: не актуален для этого кода.
            // признак последнего пункта меню - его нет в столбце parent_id
            // получаем его
            // $sql = "SELECT id FROM `pages_menu` where id NOT IN (SELECT parent_id FROM `pages_menu`)";

            $sql = "SELECT MAX(number) FROM `wallpapers_menu`";
            $number = $this->db->query($sql);
            $number = (int) $number[0]['MAX(number)'] + 1;


            $sql = "
                insert into `wallpapers_menu`
                  set `number` = '{$number}',
                      ancor = '{$ancor}',
                      url = '{$url}',
                      is_published = '{$is_published}'
            ";
        }
        else
        {
            $sql = "
                update `wallpapers_menu`
                  set ancor = '{$ancor}',
                      url = '{$url}',
                      is_published = '{$is_published}'
                   where  id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }


    // метод для удаления пункта меню из бд
    public function delete_item_menu($id)
    {
        $id = (int) $id;

        $sql = "delete from `wallpapers_menu` where id = '{$id}'";
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
        $sql = "select number from `wallpapers_menu` where `id` = '{$id}'";
        $number = $this->db->query($sql);
        $number = (int) $number[0][number];

        if ( $number != 0 )
        {
            // теперь мне нужно найти пункт
            $sql = "SELECT MAX(number) AS number FROM `wallpapers_menu` WHERE number IN (SELECT number FROM `wallpapers_menu` WHERE number < '{$number}')";
            $g_number = $this->db->query($sql);
            $g_number = $g_number[0]['number'];

            $sql = "select id from `wallpapers_menu` where `number` = '{$g_number}'";
            $g_id = $this->db->query($sql);
            $g_id = $g_id[0]['id'];

            // теперь мы имеем в переменных все данные.

            //
            $sql = "
                update `wallpapers_menu`
                  set number = '{$g_number}'
                   where  id = '{$id}'
            ";
            $this->db->query($sql);

            //
            $sql = "
                update `wallpapers_menu`
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
        $sql = "select number from `wallpapers_menu` where `id` = '{$id}'";
        $number = $this->db->query($sql);
        $number = (int) $number[0][number];

        // получаем number следующего за понижаемым пунктом.
        // если он =0, значит это последний пункт и его понизить невозможно.
        $sql = "SELECT MIN(number) AS number FROM `pages_menu` WHERE number IN (SELECT number FROM `wallpapers_menu` WHERE number > '{$number}')";
        $g_number = $this->db->query($sql);
        $g_number = (int) $g_number[0]['number'];

        if ( $g_number != 0 )
        {
//            echo "<pre>";
//            die( var_dump( $g_number ) );

            $sql = "select id from `wallpapers_menu` where `number` = '{$g_number}'";
            $g_id = $this->db->query($sql);
            $g_id = $g_id[0]['id'];

            // теперь мы имеем в переменных все данные.

            //
            $sql = "
                update `wallpapers_menu`
                  set number = '{$g_number}'
                   where  id = '{$id}'
            ";
            $this->db->query($sql);

            //
            $sql = "
                update `wallpapers_menu`
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





    public function getWallpapersCategories()
    {
        $sql   = "select * from `wallpapers_categories` ORDER BY `name`";
        $result = $this->db->query($sql);
        return isset($result) ? $result : null;
    }


    public function getCategoryAliasById($id)
    {
        if ( !$id ) return null;
        $sql   = "select `alias` from `wallpapers_categories` WHERE `id`={$id}";
        $result = $this->db->query($sql);
        return isset($result) ? $result[0] : null;
    }

    public function getCategoryIdByAlias($alias)
    {
        if ( !$alias ) return null;
        $sql    = "select `id` from `wallpapers_categories` WHERE `alias`='{$alias}'";
        $result = $this->db->query($sql);
        return isset($result) ? $result[0] : null;
    }

    public function getCategoryById($id)
    {
        $id = (int) $id;
        $sql   = "select * from `wallpapers_categories` where id ='{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }


    public function save_category($data, $id = null)
    {
        if ( !isset($data['name']) || !isset($data['alias']))
        {
            // если этот метод возвращает false, то в контроллере инициализируется соответствующее сообщение.
            return false;
        }

        $id = (int) $id;

        $name        = $this->db->escape($data['name']);
        $alias       = $this->db->escape($data['alias']);

        if ( !$id )
        {
            $sql = "
                insert into `wallpapers_categories`
                  set `name` = '{$name}',
                      `alias` = '{$alias}'
            ";
        }
        else
        {
            $sql = "
                update `wallpapers_categories`
                  set `name` = '{$name}',
                      `alias` = '{$alias}'
                   where  id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }


    // метод для удаления категории из бд
    public function delete_category($id)
    {
        $id = (int) $id;

        $sql = "delete from `wallpapers_categories` where id = '{$id}'";
        return $this->db->query($sql);
    }


    public function delete_wallpaper($id)
    {
        $id = (int) $id;

        $sql = "delete from `wallpapers` where id = '{$id}'";
        return $this->db->query($sql);
    }




    public function save_wallpaper($data, $id = null)
    {
        if ( !$id )
            if ( !isset($data['alias']) || !isset($data['file_name']) || !isset($data['url']) || !isset($data['title']) || !isset($data['description']) || !isset($data['keywords']) || !isset($data['comment']) )
            {
                // если этот метод возвращает false, то в контроллере инициализируется соответствующее сообщение.
                die('v1 ' . $id );
                return false;
            }

        if ( $id )
            if ( !isset($data['title']) || !isset($data['description']) || !isset($data['keywords']) || !isset($data['comment']) )
            {
                // если этот метод возвращает false, то в контроллере инициализируется соответствующее сообщение.
                die('v2');
                return false;
            }

        $id = (int) $id;
        $alias        = $this->db->escape($data['alias']);
        $file_name    = $this->db->escape($data['file_name']);
        $file_name    = $file_name . '.jpg';
        $url          = $this->db->escape($data['url']);
        $category_id  = $this->db->escape($data['category_id']);
        $title        = $this->db->escape($data['title']);
        $description  = $this->db->escape($data['description']);
        $keywords     = $this->db->escape($data['keywords']);
        $comment      = $this->db->escape($data['comment']);

        if ( !$id )
        {
            $sql = "
                insert into `wallpapers`
                  set `alias` = '{$alias}',
                      `file_name` = '{$file_name}',
                      `url` = '{$url}',
                      `category_id` = '{$category_id}',
                      `title` = '{$title}',
                      `description` = '{$description}',
                      `keywords` = '{$keywords}',
                      `comment` = '{$comment}'
            ";
        }
        else
        {
            $sql = "
                update `wallpapers`
                  set `title` = '{$title}',
                      `description` = '{$description}',
                      `keywords` = '{$keywords}',
                      `comment` = '{$comment}'
                   where  id = '{$id}'
            ";
        }


        return $this->db->query($sql);
    }


    public function checkWallpaperAlias($alias, $category_id)
    {
        $sql   = "select `alias` from `wallpapers` WHERE `alias`='{$alias}' AND `category_id`='{$category_id}'";
        $result = $this->db->query($sql);
        return isset($result) ? $result : null;
    }

    public function checkWallpaperTitle($title, $id = null)
    {
        $id = (int) $id;
        // тут можно проверить есть ли данный id в БД, но это паранойя.
        if ($id) $sql = "select `title` from `wallpapers` WHERE `title`='{$title}' AND `id`!='{$id}'";
        else     $sql = "select `title` from `wallpapers` WHERE `title`='{$title}'";

        $result = $this->db->query($sql);
        return isset($result) ? $result : null;
    }

    public function checkWallpaperDescription($description, $id = null)
    {
        $id = (int) $id;
        // тут можно проверить есть ли данный id в БД, но это паранойя.
        if ($id) $sql = "select `description` from `wallpapers` WHERE `description`='{$description}' AND `id`!='{$id}'";
        else     $sql = "select `description` from `wallpapers` WHERE `description`='{$description}'";

        $result = $this->db->query($sql);
        return isset($result) ? $result : null;
    }

    public function checkWallpaperComment($comment, $id = null)
    {
        $id = (int) $id;
        // тут можно проверить есть ли данный id в БД, но это паранойя.
        if ($id) $sql = "select `comment` from `wallpapers` WHERE `comment`='{$comment}' AND `id`!='{$id}'";
        else     $sql = "select `comment` from `wallpapers` WHERE `comment`='{$comment}'";

        $result = $this->db->query($sql);
        return isset($result) ? $result : null;
    }

    public function getCountCategoryById($id)
    {
        $id = (int) $id;
        $sql   = "SELECT COUNT(*) FROM `wallpapers` WHERE `category_id`='{$id}'";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getListWallpapersByCategoriesId($id)
    {
        $id = (int) $id;
        $sql   = "SELECT * FROM `wallpapers` WHERE `category_id`='{$id}'";
        $result = $this->db->query($sql);

//                    echo "<pre>";
//                    die( print_r($result) );

        return isset($result) ? $result : null;
    }

    public function getWallpaperById($id)
    {
        $id = (int) $id;
        if (! $id) die('ID not getting in model:' . __FILE__);

        $sql   = "SELECT * FROM `wallpapers` WHERE `id`='{$id}'";
        $result = $this->db->query($sql);

        return isset($result) ? $result[0] : null;
    }


    public function get2WallpapersFromCategory($id)
    {
        $id = (int) $id;
        if (! $id) die('ID not getting in model:' . __FILE__);

        $sql   = "SELECT * FROM `wallpapers` WHERE `category_id`='{$id}' ORDER BY `id` LIMIT 2";
        $result = $this->db->query($sql);

        return isset($result) ? $result : null;
    }

    public function getWallpapersFromCategory($id)
    {
        $id = (int) $id;
        if (! $id) die('ID not getting in model:' . __FILE__);

        $sql   = "SELECT * FROM `wallpapers` WHERE `category_id`='{$id}' ORDER BY `id`";
        $result = $this->db->query($sql);

        return isset($result) ? $result : null;
    }


}