<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

secure();

if (isset($_POST['email'])) {
    $db_con = db_connect();

    $sql = null;
    $values = null;
    if ($_POST['password']) {
        $sql = 'update users set ' . 
            'username = :username, email = :email, password = :password, active = :active ' .
            'where id = :id';
        $values = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'active' => (int) isset($_POST['active']),
            'id' => (int) $_GET['id']
        ];
    } else {
        $sql = 'update users set ' . 
            'username = :username, email = :email, active = :active ' .
            'where id = :id';
        $values = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'active' => (int) isset($_POST['active']),
            'id' => (int) $_GET['id']
        ];
    }

    $query = $db_con->prepare($sql);
    try {
        $query->execute($values);
        set_message('A user ' . $_POST['username'] . ' has been updated');
        header('Location: /users.php');
        die();
    } catch (PDOException $err) {
        if ($err->getCode() == '23000') {
            set_message('Username or Email were already taken');
        } else {
            set_message($err->getMessage());
        }
        header('Location: /users_edit.php?id=' . $_GET['id']);
        die();
    }
}

$user = null;
if (!isset($_GET['id'])) {
    set_message('No user selected');
} else {
    $db_con = db_connect();

    $sql = 'select * from users where id = :id';
    $query = $db_con->prepare($sql);

    $query->execute(['id' => $_GET['id']]);
    $user = $query->fetch();

    if (!$user) {
        set_message('User does not exist');
    }
}

include('includes/header.inc.php');
?>

<h1>Edit user</h1>
<ul>
    <li><a href="/users.php">Users management</a></li>
    <li><a href="/posts.php">Posts management</a></li>
</ul>

<?php if ($user) { ?>

    <form method="post">
        <label for="username">Username</label>
        <input type="username" name="username" id="username" required placeholder="username" value=<?php echo $user['username']; ?> />

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required placeholder="john.doe@gmail.com" value=<?php echo $user['email']; ?> />

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="password" />

        <input type="checkbox" name="active" id="active" <?php if ($user['active']) echo 'checked' ?> />
        <label for="active">Active</label>

        <input type="submit" value="Add user" />
    </form>

<?php }
include('includes/footer.inc.php');
?>
