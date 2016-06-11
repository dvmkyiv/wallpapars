<h1>Wallpapers</h1>

<h3>Review Wallpapers Category (<?=$data['category']['name']?>)</h3>

<?php if( $data['wallpapers']['0'] ) : ?>
    <table class="table table-striped admin">
        <tr>
            <th>ID</th>
            <th>Alias</th>
            <th>Title</th>
            <th>Actions</th>
        </tr>

        <?php foreach($data['wallpapers'] as $wallpaper) { ?>
            <tr>
                <td><?=$wallpaper['id']?></td>
                <td><?=$wallpaper['alias']?></td>
                <td><?=$wallpaper['title']?></td>
                <td>
                    <a href="/admin/wallpapers/edit/<?=$wallpaper['id']?>"><button class="btn btn-sm btn-primary">edit</button></a>
                    <a href="/admin/wallpapers/delete/<?=$wallpaper['id']?>" onclick="return confirmDelete()"><button class="btn btn-sm btn-warning">delete</button></a>
                </td>
            </tr>
        <?php } ?>

    </table>
<?php else: ?>

    <p>Category "<?=$data['category']['name']?>" is empty.</p>

<?php endif; ?>

<br><br><br>

