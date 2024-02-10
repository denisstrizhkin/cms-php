<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

secure();

if (isset($_POST['email'])) {
    $db_con = db_connect();

    $sql = 'insert into users (username, email, password, active)' .
        'values (:username, :email, :password, :active)';
    $query = $db_con->prepare($sql);

    try {
        $query->execute([
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'active' => (int) isset($_POST['active'])
        ]);
        set_message('A new user ' . $_POST['username'] . ' has been added');
        header('Location: /users.php');
        die();
    } catch (PDOException $err) {
        if ($err->getCode() == '23000') {
            set_message('Username or Email were already taken');
        } else {
            set_message($err->getMessage());
        }
        header('Location: /users_add.php');
        die();
    }
}

include('includes/header.inc.php');
?>

<h1>Add user</h1>
<ul>
    <li><a href="/users.php">Users management</a></li>
    <li><a href="/posts.php">Posts management</a></li>
</ul>

<form method="post">
    <label for="username">Username</label>
    <input type="username" name="username" id="username" required placeholder="username" />

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required placeholder="john.doe@gmail.com" />

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required placeholder="password" />

    <input type="checkbox" name="active" id="active" checked />
    <label for="active">Active</label>

    <input type="submit" value="Add user" />
</form>

<?php
include('includes/footer.inc.php');
?>
