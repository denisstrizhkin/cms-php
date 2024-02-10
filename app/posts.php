<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

secure();

include('includes/header.inc.php');
?>

<h1>Posts management</h1>
<ul>
    <li><a href="/users.php">Users management</a></li>
    <li><a href="/posts.php">Posts management</a></li>
</ul>

<?php
include('includes/footer.inc.php');
?>
