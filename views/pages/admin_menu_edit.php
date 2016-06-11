<h3>Edit Menu Item</h3>

<form action="" method="post">

    <input type="hidden" name="id" value="<?=$data['edit']['id'] ?>">

    <div class="form-group">
        <label for="alias">Ancor</label>
        <input type="text" id="ancor" name="ancor" value="<?=$data['edit']['ancor'] ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="title">URL</label>
        <input type="text" id="url" name="url" value="<?=$data['edit']['url'] ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="is_published">Publish?</label>
        <input type="checkbox" id="is_published" name="is_published" <?php if ($data['edit']['is_published']) { ?>checked="checked"<?php }; ?> class="form-control">
    </div>

    <input type="submit" class="btn btn-success" value="Submit">
</form>