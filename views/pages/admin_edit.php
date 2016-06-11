<h3>Edit page</h3>

<form action="" method="post">

    <input type="hidden" name="id" value="<?=$data['edit']['id'] ?>">

    <div class="form-group">
        <label for="alias">Alias</label>
        <input type="text" id="alias" name="alias" value="<?=$data['edit']['alias'] ?>" class="form-control" size="10">
    </div>

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?=$data['edit']['title'] ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="title">Meta-description</label>
        <input type="text" id="description" name="description" value="<?=$data['edit']['description'] ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="title">Meta-keywords</label>
        <input type="text" id="keywords" name="keywords" value="<?=$data['edit']['keywords'] ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="content">Content</label>
        <textarea id="content" name="content" class="form-control"><?=$data['edit']['content'] ?></textarea>
    </div>

    <div class="form-group">
        <label for="is_published">Publish?</label>
        <input type="checkbox" id="is_published" name="is_published" <?php if ($data['edit']['is_published']) { ?>checked="checked"<?php }; ?> class="form-control">
    </div>

    <input type="submit" class="btn btn-success" value="Submit">
</form>

<script>
    CKEDITOR.replace("content");
</script>