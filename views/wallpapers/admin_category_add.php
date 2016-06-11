<h3>Ad Wallpapers Category</h3>

<form action="" method="post">

    <div class="form-group">
        <label for="alias">Name</label>
        <input type="text" id="name" name="name" value="<?=$_POST['name'];?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="title">Alias</label>
        <input type="text" id="alias" name="alias" value="<?=$_POST['alias'];?>" class="form-control">
    </div>

    <input type="submit" class="btn btn-success" value="Submit">
</form>