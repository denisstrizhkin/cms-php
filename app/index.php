<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

if (isset($_SESSION['id'])) {
    header('Location: dashboard.php');
    die();
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db_con = db_connect();

    $sql = 'select * from users where email = :email and password = :password';
    $query = $db_con->prepare($sql);
    $query->execute(['email' => $email, 'password' => $password]);

    $result = $query->fetch();
    if ($result) {
        $_SESSION['id'] = $result['id'];
        $_SESSION['username'] = $result['username'];
        $_SESSION['email'] = $result['email'];

        set_message("You have succesfully logged in as " . $_SESSION['username']);
        header('Location: /dashboard.php');
        die();
    }
}

include('includes/header.inc.php');
?>

<form method="post">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required placeholder="john.doe@gmail.com" />

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required placeholder="password" />

    <input type="checkbox" name="remember" id="remember" checked />
    <label for="remember">Remember me</label>
    <input type="submit" value="Sign in" />
</form>

<?php
include('includes/footer.inc.php');
?>
