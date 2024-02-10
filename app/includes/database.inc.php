<?php

function db_connect(): PDO {
    $db_host = $_ENV["DB_HOST"];
    $db_port = $_ENV["DB_PORT"];
    $db_name = $_ENV["DB_NAME"];
    $db_user = $_ENV["DB_USER"];
    $db_passwd = $_ENV["DB_PASSWD"];

    $db_str = "mysql:host=$db_host:$db_port;dbname=$db_name";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    return new PDO($db_str, $db_user, $db_passwd, $options);
}

?>
