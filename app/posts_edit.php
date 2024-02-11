<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

secure();

if (isset($_POST['title'])) {
    $db_con = db_connect();

    $sql = 'update posts set ' .
        'title = :title, content = :content, changed = :changed ' .
        'where id = :id';
    $query = $db_con->prepare($sql);
    try {
        $date = date('Y-m-d H:i:s');
        $query->execute([
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'changed' => $date,
            'id' => (int) $_GET['id']
        ]);
        set_message('A post ' . $_POST['title'] . ' has been updated');
        header('Location: /posts.php');
        die();
    } catch (PDOException $err) {
        set_message($err->getMessage());
        header('Location: /posts_edit.php?id=' . $_GET['id']);
        die();
    }
}

$post = null;
if (!isset($_GET['id'])) {
    set_message('No post selected');
} else {
    $db_con = db_connect();

    $sql = 'select * from posts where id = :id';
    $query = $db_con->prepare($sql);

    $query->execute(['id' => $_GET['id']]);
    $post = $query->fetch();

    if (!$post) {
        set_message('Post does not exist');
    }
}

include('includes/header.inc.php');
?>

<h1>Edit post</h1>
<ul>
    <li><a href="/users.php">Users management</a></li>
    <li><a href="/posts.php">Posts management</a></li>
</ul>

<?php if ($post) { ?>

    <form method="post">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required placeholder="title" value="<?php echo $post['title'] ?>" />

        <label for="content">Content</label>
        <textarea name="content" id="content" required placeholder="Enter your text here..."><?php echo $post['content'] ?></textarea>

        <input type="submit" value="Update post" />
    </form>

<?php }
include('includes/footer.inc.php');
?>
