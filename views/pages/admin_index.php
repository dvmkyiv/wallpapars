<h3>Pages</h3>
<table class="table table-striped admin">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Actions</th>
    </tr>

    <?php foreach($data['pages'] as $page_data) { ?>
    <tr>
        <td><?=$page_data['id']?></td>
        <td><?=$page_data['title']?></td>
        <td>
            <a href="/admin/pages/edit/<?=$page_data['id']?>"><button class="btn btn-sm btn-primary">edit</button></a>
            <a href="/admin/pages/delete/<?=$page_data['id']?>" onclick="return confirmDelete()"><button class="btn btn-sm btn-warning">delete</button></a>
        </td>
    </tr>
    <?php } ?>

</table>

<div>
    <a href="/admin/pages/add/"><button class="btn btn-sm btn-success">New Page</button></a>
</div>