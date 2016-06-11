<h3>Pages Menu</h3>
<table class="table table-striped admin">
    <tr>
        <th>ID</th>
        <th>Ancor</th>
        <th>URL</th>
        <th>Actions</th>
    </tr>

    <?php foreach($data['menu'] as $menu) { ?>
    <tr>
        <td><?=$menu['id']?></td>
        <td><?=$menu['ancor']?></td>
        <td><?=$menu['url']?></td>
        <td>
            <a href="/admin/pages/menu_up/<?=$menu['id']?>"><img src="/img/admin/up.png" alt="Up"></a>
            <a href="/admin/pages/menu_dn/<?=$menu['id']?>"><img src="/img/admin/dn.png" alt="Dn"></a>
            <a href="/admin/pages/menu_edit/<?=$menu['id']?>"><button class="btn btn-sm btn-primary">edit</button></a>
            <a href="/admin/pages/menu_delete/<?=$menu['id']?>" onclick="return confirmDelete()"><button class="btn btn-sm btn-warning">delete</button></a>
        </td>
    </tr>
    <?php } ?>

</table>

<div>
    <a href="/admin/pages/menu_add/"><button class="btn btn-sm btn-success">New Menu Item</button></a>
</div>