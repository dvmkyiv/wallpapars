<div class="col-lg-9 col-md-9 col-lg-push-3 col-md-push-3" xmlns:width="http://www.w3.org/1999/xhtml">
    <!-- начало столбца для контента -->

    <h1>Wallpapers</h1>

    <?php foreach($data['categories'] as $category) {

        if ( is_array( $category ) ) {

            if ( is_array($data['wallpapers'][$category['id']]) )
            {
                // 1 обоина = $data['wallpapers'][$category['id']][0]
    ?>

        <section>
            <header>
                <h2><?=$category['name']?></h2>
            </header>


            <div>
                <div class="block-wallpaper-preview">
                    <img src="/img/wallpapers/<?=$category['alias'];?>/<?=$data['wallpapers'][$category['id']][0]['file_name'];?>" alt="">
                </div>
                <div class="block-wallpaper-preview">
                    <img src="/img/wallpapers/<?=$category['alias'];?>/<?=$data['wallpapers'][$category['id']][1]['file_name'];?>" alt="">
                </div>
                <div class="block-wallpaper-preview">
                    <img src="/img/wallpapers/<?=$category['alias'];?>/<?=$data['wallpapers'][$category['id']][1]['file_name'];?>" alt="">
                </div>
            </div>


            <p>Category: <a href="/wallpapers/category/<?=$category['alias']?>"><?=$category['name']?></a>.</p>
        </section>

    <?php } } }?>


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

