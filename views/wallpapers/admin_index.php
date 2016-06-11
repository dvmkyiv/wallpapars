<h1>Wallpapers</h1>

<h3>Admin Wallpapers Categories</h3>
<table class="table table-striped admin">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Alias</th>
        <th>Count</th>
        <th>Actions</th>
    </tr>

    <?php foreach($data['categories'] as $categories) { ?>
        <tr>
            <td><?=$categories['id']?></td>
            <td><?=$categories['name']?></td>
            <td><?=$categories['alias']?></td>
            <td><a href="/admin/wallpapers/review_category/<?=$categories['id']?>"><?=$data['counter'][$categories['id']]?></a></td>
            <td>
                <a href="/admin/wallpapers/category_edit/<?=$categories['id']?>"><button class="btn btn-sm btn-primary">edit</button></a>
                <a href="/admin/wallpapers/category_delete/<?=$categories['id']?>" onclick="return confirmDelete()"><button class="btn btn-sm btn-warning">delete</button></a>
            </td>
        </tr>
    <?php } ?>

</table>

<div>
    <a href="/admin/wallpapers/category_add/"><button class="btn btn-sm btn-success">Add New Category</button></a>

    <a href="/admin/wallpapers/add/"><button class="btn btn-sm btn-success">Add New Wallpaper</button></a>
</div>

<br><br><br>