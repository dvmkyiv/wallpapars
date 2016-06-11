<?php
// Это основной конфигурационный файл нашего приложения.
// Он содержит имя сайта, данные от БД.

Config::set('site name', 'Desktop Wallpapers');
Config::set('languages', array('en', 'ru'));    // соответствует файлам в папке lang

// Routes. Route name => method prefix (route - маршрут)

// Ключ - название маршрута, а значение - прификс метода.
// Это называется список роутеров.
Config::set('routes', array(
        'default' => '',
        'admin' => 'admin_'
    )
);

Config::set('default_route', 'default');
Config::set('default_language', 'en');
Config::set('default_controller', 'pages');
Config::set('default_action', 'index');

// при запросе site/pages сработает метод по умолчанию index

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', '');
Config::set('db.db_name', 'my_directory');

Config::set('salt', '5ghjyuloi5e2wd');
