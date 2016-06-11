<?php
define('DS',    DIRECTORY_SEPARATOR);            // http://php.net/manual/ru/dir.constants.php
define('ROOT',  dirname(dirname(__FILE__)) );    // путь к корню.

$queries[] = 'create database my_directory';
$queries[] = 'use my_directory';

$link = mysqli_connect('localhost', "root", '');
if ( !$link ) die("Error");

foreach ($queries as $query)
{
    if (mysqli_query($link, $query)) echo "Запрос `$query` выполнен.<br><br>";
    else echo "Запрос `$query` не выполнен: ".mysqli_error().'<br><br>';
}

mysqli_close($link);
unset($queries);


$queries[] = '
create table `wallpapers_menu`(
  `id` tinyint(3) unsigned not null auto_increment,
  `number` tinyint(3) unsigned not null,
  `ancor` VARCHAR(100) NOT NULL,
  `url` VARCHAR(100) NOT NULL,
  `is_published` tinyint(1) unsigned default 0,
  PRIMARY KEY (`id`)
) engine = InnoDB default charset=utf8
';
$queries[] = "
insert into `wallpapers_menu`
values  (1, 0, 'Main', '/' ,1)
";


$queries[] = '
create table `wallpapers_categories`(
  `id` tinyint(3) unsigned not null auto_increment,
  `name` VARCHAR(100) NOT NULL,
  `alias` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) engine = InnoDB default charset=utf8
';

foreach ( getCategories() as $entry )
{
    $values .= "(" . ++$i . ", '{$entry['name']}', '{$entry['alias']}'),\n";
}

$values = rtrim( rtrim($values), ',' );

$queries[] = "
insert into `wallpapers_categories`
values $values";





$queries[] = '
create table `wallpapers`(
  `id` tinyint(3) unsigned not null auto_increment,
  `alias` VARCHAR(100) NOT NULL,
  `file_name` VARCHAR(100) NOT NULL,
  `url` VARCHAR(100) NOT NULL,
  `category_id` tinyint(3) NOT NULL,
  `title` VARCHAR(256) NOT NULL,
  `description` VARCHAR(256) NOT NULL,
  `keywords` VARCHAR(256) NOT NULL,
  `comment` TEXT NOT NULL,
  PRIMARY KEY (`id`)
) engine = InnoDB default charset=utf8
';




$queries[] = '
create table `pages_menu`(
  `id` tinyint(3) unsigned not null auto_increment,
  `number` tinyint(3) unsigned not null,
  `ancor` VARCHAR(100) NOT NULL,
  `url` VARCHAR(100) NOT NULL,
  `is_published` tinyint(1) unsigned default 0,
  PRIMARY KEY (`id`)
) engine = InnoDB default charset=utf8
';
$queries[] = "
insert into `pages_menu`
values  (1, 0, 'Main', '/' ,1),
        (2, 1, 'About Us', '/pages/view/about', 1),
        (3, 2, 'Test page', '/pages/view/test', 1),
        (4, 3, 'Admin Section', '/admin/', 1)
";



$queries[] = '
create table `pages`(
  `id` tinyint(3) unsigned not null auto_increment,
  `alias` VARCHAR(100) NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `description` VARCHAR(256) NOT NULL,
  `keywords` VARCHAR(256) NOT NULL,
  `content` text DEFAULT NULL,
  `is_published` tinyint(1) unsigned default 0,
  PRIMARY KEY (`id`)
) engine = InnoDB default charset=utf8
';

$queries[] = "
insert into `pages`
values  (1,'about','About CMS','description','keywords','В меню не реализовано поле `is_published`.<br>',1),
        (2,'test','Test page','description','keywords','Another test content',1)
";




$queries[] = "
create table `users`(
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `login` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `role` VARCHAR(45) NOT NULL DEFAULT 'admin',
  `password` CHAR(32) NOT NULL ,
  `is_active` tinyint(1) unsigned  DEFAULT '1',
  PRIMARY KEY (`id`)
) engine = InnoDB default charset=utf8
";

$queries[] = "
insert into `users`
SET login = 'admin',
    email = 'zevz@meta.ua',
    role  = 'admin',
    `password` = md5('5ghjyuloi5e2wdadmin');
";




$queries[] = '
create table `categories` (
  `id` tinyint(3) unsigned not null auto_increment,
  `alias` VARCHAR(100) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) engine = InnoDB default charset=utf8
';

$queries[] = "
insert into `categories`
SET alias = 'index',
    name  = ''
";



$link = mysqli_connect('localhost', "root", '', 'my_directory');
if ( !$link ) die("Error");

foreach ($queries as $query)
{
    if (mysqli_query($link, $query)) echo "Запрос `$query` выполнен.<br><br>";
    else echo "Запрос `$query` не выполнен: ".mysqli_errno($link).' - '.mysqli_error($link).'<br><br>';
}

mysqli_close($link);


foreach ( getCategories() as $category )
{
    mkdir( ROOT . DS . 'webroot' . DS . 'img' . DS . 'wallpapers' . DS . $category['alias'] );
}



exit("<br><br>This is all.");






function getCategories()
{
return
        [
            [
                'name'  => '3D',
                'alias' => '3d'
            ],

            [
                'name'  => 'Abstract',
                'alias' => 'abstract'
            ],

            [
                'name'  => 'Animals',
                'alias' => 'animals'
            ],

            [
                'name'  => 'Anime',
                'alias' => 'anime'
            ],

            [
                'name'  => 'Brands',
                'alias' => 'brands'
            ],

            [
                'name'  => 'Cars',
                'alias' => 'cars'
            ],

            [
                'name'  => 'City',
                'alias' => 'city'
            ],

            [
                'name'  => 'Fantasy',
                'alias' => 'fantasy'
            ],

            [
                'name'  => 'Flowers',
                'alias' => 'flowers'
            ],

            [
                'name'  => 'Food',
                'alias' => 'food'
            ],

            [
                'name'  => 'Games',
                'alias' => 'games'
            ],

            [
                'name'  => 'Girls',
                'alias' => 'girls'
            ],

            [
                'name'  => 'Hi-Tech',
                'alias' => 'hi-tech'
            ],

            [
                'name'  => 'Holidays',
                'alias' => 'holidays'
            ],

            [
                'name'  => 'Macro',
                'alias' => 'macro'
            ],

            [
                'name'  => 'Men',
                'alias' => 'men'
            ],

            [
                'name'  => 'Movies',
                'alias' => 'movies'
            ],

            [
                'name'  => 'Music',
                'alias' => 'music'
            ],

            [
                'name'  => 'Nature',
                'alias' => 'nature'
            ],

            [
                'name'  => 'Other',
                'alias' => 'other'
            ],

            [
                'name'  => 'Space',
                'alias' => 'space'
            ],

            [
                'name'  => 'Sport',
                'alias' => 'sport'
            ],

            [
                'name'  => 'Textures',
                'alias' => 'textures'
            ],

            [
                'name'  => 'TV Series',
                'alias' => 'tv-series'
            ],

            [
                'name'  => 'Vector',
                'alias' => 'vector'
            ]
        ];
}