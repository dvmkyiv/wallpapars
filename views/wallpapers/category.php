<div class="col-lg-9 col-md-9 col-lg-push-3 col-md-push-3" xmlns:width="http://www.w3.org/1999/xhtml">
    <!-- начало столбца для контента -->

    <h1>Wallpapers</h1>
    <h2>Category <?=$data['category']?></h2>

    <?php
        foreach($data['wallpapers'] as $wallpaper)
        {
            /*
             *
             */
     ?>

        <div class="block-wallpaper-preview">
            <img src="/img/wallpapers/<?=$data['category']?>/<?=$wallpaper['file_name'];?>" alt="">
        </div>

    <?php } ?>

</div> <!-- конец столбца для контента -->


<div class="col-lg-3 col-md-3 col-xs-12 col-lg-pull-9 col-md-pull-9">

    <?php /* столбец меню */ ?>
    <nav class="site-menu">
        <header>Wallpapers</header>

        <?php foreach($data['menu'] as $pages_menu) { ?>

            <div>
                <a href="<?=$pages_menu['url']?>"><?=$pages_menu['ancor']?></a>
            </div>

        <?php } ?>

    </nav>
</div>