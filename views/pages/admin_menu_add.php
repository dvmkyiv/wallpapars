<h3>Ad Menu Item</h3>

<form action="" method="post">

    <div class="form-group">
        <label for="alias">Ancor</label>
        <input type="text" id="ancor" name="ancor" value="<?=$_POST['ancor'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="title">URL</label>
        <input type="text" id="url" name="url" value="<?=$_POST['url'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="is_published">Publish?</label>
        <input type="checkbox" id="is_published" name="is_published" checked="checked" class="form-control">
    </div>

    <input type="submit" class="btn btn-success" value="Submit">
</form>