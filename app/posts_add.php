<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

secure();

if (isset($_POST['title'])) {
    $db_con = db_connect();

    $sql = 'insert into posts (title, author_id, content) ' .
        'values (:title, :author_id, :content)';
    $query = $db_con->prepare($sql);

    try {
        $query->execute([
            'title' => $_POST['title'],
            'author_id' => $_POST['author_id'],
            'content' => $_POST['content'],
        ]);
        set_message('A new post ' . $_POST['title'] . ' has been added');
        header('Location: /posts.php');
        die();
    } catch (PDOException $err) {
        if ($err->getCode() == '23000') {
            set_message('Author does not exist');
        } else {
            set_message($err->getMessage());
        }
        header('Location: /posts_add.php');
        die();
    }
}

include('includes/header.inc.php');
?>

<h1>Add post</h1>
<ul>
    <li><a href="/users.php">Users management</a></li>
    <li><a href="/posts.php">Posts management</a></li>
</ul>

<form method="post">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" required placeholder="title" />

    <label for="author_id">Author id</label>
    <input type="number" name="author_id" id="author_id" required placeholder="author_id" />

    <label for="content">Content</label>
    <textarea name="content" id="content" required placeholder="Enter your text here..."></textarea>

    <input type="submit" value="Add post" />
</form>

<?php
include('includes/footer.inc.php');
?>
