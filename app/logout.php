<?php
include('includes/config.inc.php');

session_destroy();
header('Location: /');
die();
