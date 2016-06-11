<h1>Wallpapers</h1>

<h3>Edit wallpaper</h3>

<form action="" method="post">

    <div class="form-group">
        <label for="url">Download from URL</label>
        <input type="text" id="url" name="url" value="<?=$data['wallpaper']['url'];?>" disabled class="form-control">
    </div>

    <div class="form-group">
        <label for="alias">Alias</label>
        <input type="text" id="alias" name="alias" value="<?=$data['wallpaper']['alias'];?>" disabled class="form-control">
    </div>

    <div class="form-group">
        <label for="category">Category</label><br>
        <?php
        $categories = new Wallpaper;
        $categories = $categories->getWallpapersCategories();
        foreach ($categories as $category)
        {
            if ($category['id'] == $data['wallpaper']['category_id'] ) $selected = ' checked';
            else $selected = '';
            echo '
                <div class="form-radio-list">
                     <input type="radio" name="category_id" value="' . $category['id'] . '"' . $selected .' disabled> ' . $category['name'] . '
                </div>
            ';
        }
        ?>
    </div>

    <div class="form-group">
        <label for="name">File Name without .jpg</label>
        <input type="text" id="file_name" name="file_name" value="<?=$data['wallpaper']['file_name'];?>" disabled class="form-control">
    </div>

    <img src="/img/wallpapers/<?=$data['category']['alias'];?>/<?=$data['wallpaper']['file_name'];?>" alt="" class="admin-preview">

    <div class="form-group">
        <label for="description">Title</label>
        <input type="text" id="title" name="title" value="<?=$data['wallpaper']['title'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="description">Meta-description</label>
        <input type="text" id="description" name="description" value="<?=$data['wallpaper']['description'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="keywords">Meta-keywords</label>
        <input type="text" id="keywords" name="keywords" value="<?=$data['wallpaper']['keywords'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea id="comment" name="comment" class="form-control"><?=$data['wallpaper']['comment'];?></textarea>
    </div>

    <input type="submit" class="btn btn-success" value="Submit">
</form>

<script>
    CKEDITOR.replace("comment");
</script>