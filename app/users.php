<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

secure();

include('includes/header.inc.php');

$db_con = db_connect();

$sql = 'select * from users';
$query = $db_con->prepare($sql);
$query->execute();

$users = $query->fetchAll();
?>

<h1>Users management</h1>
<ul>
    <li><a href="/users.php">Users management</a></li>
    <li><a href="/posts.php">Posts management</a></li>
</ul>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Email</th>
            <th>Status</th>
            <th>Added</th>
            <th>Edit | Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['id'];       ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email'];    ?></td>
                <td><?php echo $user['active'];   ?></td>
                <td><?php echo $user['added'];    ?></td>
                <td><a href="/users_edit.php?id=<?php echo $user['id'] ?>">Edit</a> |
                    <a href="/users.php?delete=<?php echo $user['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<a href="/users_add.php">Add new user</a>

<?php
include('includes/footer.inc.php');
?>
