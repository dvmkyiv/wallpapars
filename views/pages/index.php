        <div class="col-lg-9 col-md-9 col-lg-push-3 col-md-push-3">
            <!-- начало столбца для контента -->

            <h1>Pages</h1>

            <?php if (Session::hasFlash()) { ?>
                <div class="alert alert-info" role="alert">
                    <?php Session::flash() ?>
                </div>
            <?php } ?>

            <?php foreach($data['pages'] as $page_data) { ?>

                <div>
                    <a href="/pages/view/<?=$page_data['alias']?>"><?=$page_data['title']?></a>
                </div>

            <?php } ?>

            <?=$data['content']?>

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

<?php

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$pagination = new Pagination(array(
    'itemsCount' => 2423,
    'itemsPerPage' => 20,
    'currentPage' => $page
));
?>

<div class="pagination">
<?php foreach ($pagination->buttons as $button) :
    if ($button->isActive and $button->page) : ?>
        <a href = '?page=<?=$button->page?>'><?=$button->text?></a>
    <?php elseif ($button->isActive and !$button->page) : ?>
        <span class="hellip"><?=$button->text?></span>
    <?php else : ?>
        <span><?=$button->text?></span>
    <?php endif;
endforeach; ?>
</div>


