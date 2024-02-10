<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

secure();

include('includes/header.inc.php');

$db_con = db_connect();
if (isset($_GET['delete'])) {
    $sql = 'delete from posts where id=:id';
    $query = $db_con->prepare($sql);

    $query->execute(['id' => $_GET['delete']]);
}

$sql = 'select * from posts';
$query = $db_con->prepare($sql);

$query->execute();
$posts = $query->fetchAll();

function get_author(int $author_id, PDO $con): string {
    $sql = 'select * from users where id = :id';
    $query = $con->prepare($sql);

    $query->execute(['id' => $author_id]);
    $user = $query->fetch();

    return $user['username'];
}
?>

<h1>Posts management</h1>
<ul>
    <li><a href="/users.php">Users management</a></li>
    <li><a href="/posts.php">Posts management</a></li>
</ul>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Author</th>
            <th>Content</th>
            <th>Changed</th>
            <th>Added</th>
            <th>Edit | Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $post) { ?>
            <tr>
                <td><?php echo $post['id'];    ?></td>
                <td><?php echo $post['title']; ?></td>
                <td><?php echo get_author($post['author_id'], $db_con); ?></td>
                <td>
                    <?php
                    $content = substr($post['content'], 0, 20);
                    if (strlen($content) < strlen($post['content'])) {
                        $content .= '...';
                    }
                    echo $content;
                    ?>
                </td>
                <td><?php echo $post['changed']; ?></td>
                <td><?php echo $post['added'];   ?></td>
                <td><a href="/posts_edit.php?id=<?php echo $post['id'] ?>">Edit</a> |
                    <a href="/posts.php?delete=<?php echo $post['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<a href="/posts_add.php">Add new post</a>

<?php
include('includes/footer.inc.php');
?>
