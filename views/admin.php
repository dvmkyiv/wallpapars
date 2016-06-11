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

    <link rel="stylesheet" href="/css/style.css">
    <script src="/webroot/js/admin.js"></script>
    <?php if($data['additional']) echo $data['additional'] . "\n"; ?>

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
            <a class="navbar-brand" href="/admin/"><?=Config::get('site name')?> - <?=__('lng.admin', 'Admin Section')?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php if ( Session::get('login') ) { ?>
                    <li<?php if ( App::getRouter()->getController() == 'pages' )        { ?> class="active"<?php } ?>><a href="/admin/pages/">Pages</a></li>
                    <li<?php if ( App::getRouter()->getController() == 'wallpapers' )   { ?> class="active"<?php } ?>><a href="/admin/wallpapers/">Wallpapers</a></li>
                    <li><a href="/admin/users/logout">Logout</a></li>
                <?php } ?>
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
                <div class="alert alert-info margin-top-20" role="alert">
                    <?php Session::flash() ?>
                </div>
            <?php } ?>


            <?php
            if (Session::get('message'))
            {
            ?>
                <div class="alert alert-info margin-top-20" role="alert">
                    <?php
                        echo Session::get('message');
                        Session::delete('message');
                    ?>
                </div>
            <?php }; ?>

            <?=$data['content']?>

        </div> <!-- конец столбца для контента -->


        <div class="col-lg-3 col-md-3 col-xs-12 col-lg-pull-9 col-md-pull-9">
            <?php /* столбец меню */

            if( Session::get('role') == 'admin' )
            {
            echo '
            <nav class="site-menu">
                <header>' . __('admin.section', 'Admin Section') . '</header>

                    <div>
                        <a href="/admin/">Pages</a>
                        <a href="/admin/pages/page_menu">Pages Menu</a>
                        <a href="/admin/wallpapers/">Wallpapers</a>
                        <a href="/admin/wallpapers/menu/">Wallpapers Menu</a>
                        <a href="/admin/wallpapers/categories/">Wallpapers Categories</a>
                    </div>

            </nav>
            ';
            }
            ?>

        </div>


    </div> <!-- конец столбца row -->
</div> <!-- конец столбца container-fluid -->



</body>
</html>