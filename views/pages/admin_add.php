<h3>Add page</h3>

<form action="" method="post">

    <div class="form-group">
        <label for="alias">Alias</label>
        <input type="text" id="alias" name="alias" value="<?=$_POST['alias'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?=$_POST['title'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="title">Meta-description</label>
        <input type="text" id="description" name="description" value="<?=$_POST['description'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="title">Meta-keywords</label>
        <input type="text" id="keywords" name="keywords" value="<?=$_POST['keywords'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="content">Content</label>
        <textarea id="content" name="content" class="form-control"><?=$_POST['content'];?></textarea>
    </div>

    <div class="form-group">
        <label for="is_published">Publish?</label>
        <input type="checkbox" id="is_published" name="is_published" checked="checked" class="form-control">
    </div>

    <input type="submit" class="btn btn-success" value="Submit">
</form>

<script>
    CKEDITOR.replace("content");
</script>