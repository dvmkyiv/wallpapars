<h3>Add wallpaper</h3>

<form action="" method="post">

    <div class="form-group">
        <label for="url">Wallpaper URL</label>
        <input type="text" id="url" name="url" value="<?=$_POST['url'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="alias">Alias</label>
        <input type="text" id="alias" name="alias" value="<?=$_POST['alias'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="category">Category</label><br>
        <?php
        $categories = new Wallpaper;
        $categories = $categories->getWallpapersCategories();
        foreach ($categories as $category)
        {
            if ($category['id'] == $_POST['category_id'] ) $selected = ' checked';
            else $selected = '';
            echo '
                <div class="form-radio-list">
                     <input type="radio" name="category_id" value="' . $category['id'] . '"' . $selected .'> ' . $category['name'] . '
                </div>
            ';
        }
        ?>
    </div>

    <div class="form-group">
        <label for="name">File Name without .jpg</label>
        <input type="text" id="file_name" name="file_name" value="<?=$_POST['file_name'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="description">Title</label>
        <input type="text" id="title" name="title" value="<?=$_POST['title'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="description">Meta-description</label>
        <input type="text" id="description" name="description" value="<?=$_POST['description'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="keywords">Meta-keywords</label>
        <input type="text" id="keywords" name="keywords" value="<?=$_POST['keywords'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea id="comment" name="comment" class="form-control"><?=$_POST['comment'];?></textarea>
    </div>

    <input type="submit" class="btn btn-success" value="Submit">
</form>

<script>
    CKEDITOR.replace("comment");
</script>