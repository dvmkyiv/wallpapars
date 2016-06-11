<div class="col-lg-9 col-md-9 col-lg-push-3 col-md-push-3">
<!-- начало столбца для контента -->

            <?php if (Session::hasFlash()) { ?>
                <div class="alert alert-info" role="alert">
                    <?php Session::flash() ?>
                </div>
            <?php } ?>


            <?=$data['page']['content']?>

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