<h3>Admin Wallpapers Categories</h3>
<table class="table table-striped admin">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Alias</th>
        <th>Actions</th>
    </tr>

    <?php foreach($data['menu'] as $menu) { ?>
    <tr>
        <td><?=$menu['id']?></td>
        <td><?=$menu['name']?></td>
        <td><?=$menu['alias']?></td>
        <td>
            <a href="/admin/wallpapers/category_edit/<?=$menu['id']?>"><button class="btn btn-sm btn-primary">edit</button></a>
            <a href="/admin/wallpapers/category_delete/<?=$menu['id']?>" onclick="return confirmDelete()"><button class="btn btn-sm btn-warning">delete</button></a>
        </td>
    </tr>
    <?php } ?>

</table>

<div>
    <a href="/admin/wallpapers/category_add/"><button class="btn btn-sm btn-success">New Category</button></a>
</div>