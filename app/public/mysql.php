<?php

$dbname = $_ENV["DB_NAME"];

echo $dbname;

$pdo = new PDO(
    'mysql:dbname=cms;host=mysql', 'user', 'passwd_user',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$query = $pdo->query('SHOW VARIABLES like "version"');

$row = $query->fetch();

echo 'MySQL version:' . $row['Value'];

