<?php
    if ($data['title']) {
        $title = $data['title'];
    }
    else $title = Config::get('site name');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <?php if($data['description'])  echo '<meta name="description" content="' . $data['description'] . '">'."\n";?>
    <?php if($data['keywords'])     echo '<meta name="keywords"    content="' . $data['keywords']    . '">'."\n";?>
    <link rel="stylesheet" href="/css/style.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?=Config::get('site name')?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li<?php if ( App::getRouter()->getController() == 'pages' )         { ?> class="active" <?php } ?>><a href="/pages/">Pages</a></li>
                <li<?php if ( App::getRouter()->getController() == 'wallpapers' )    { ?> class="active" <?php } ?>><a href="/wallpapers/">Wallpapers</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>







<?php /* главная "таблица" сайта */ ?>
<div class="container-fluid">
    <div class="row">


        <div class="col-lg-9 col-md-9 col-lg-push-3 col-md-push-3">
            <!-- начало столбца для контента -->

            <?php if (Session::hasFlash()) { ?>
                <div class="alert alert-info" role="alert">
                    <?php Session::flash() ?>
                </div>
            <?php } ?>

            <?=$data['content']?>
            <?=__('lng.test2', '')?>

        </div> <!-- конец столбца для контента -->


        <div class="col-lg-3 col-md-3 col-xs-12 col-lg-pull-9 col-md-pull-9">
            <?php /* столбец меню */ ?>

                <nav class="site-menu">
                    <header>Pages</header>

                    <?php foreach($data['menu'] as $pages_menu) { ?>

                        <div>
                            <a href="<?=$pages_menu['url']?>"><?=$pages_menu['ancor']?></a>
                        </div>

                    <?php } ?>

                </nav>

        </div>


    </div> <!-- конец столбца row -->
</div> <!-- конец столбца container-fluid -->


</body>
</html>