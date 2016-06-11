<h3>Edit Wallpapers Category</h3>

<form action="" method="post">

    <input type="hidden" name="id" value="<?=$data['edit']['id'] ?>">

    <div class="form-group">
        <label for="alias">Name</label>
        <input type="text" id="name" name="name" value="<?=$data['edit']['name'] ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="title">Alias</label>
        <input type="text" id="alias" name="alias" value="<?=$data['edit']['alias'] ?>" class="form-control">
    </div>

    <input type="submit" class="btn btn-success" value="Submit">
</form>