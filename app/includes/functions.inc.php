<?php

function secure()
{
    if (!isset($_SESSION['id'])) {
        set_message('Please login first!');
        header('Location: /');
        die();
    }
}

function set_message(string $message)
{
    $_SESSION["message"] = $message;
}

function get_message()
{
    if (isset($_SESSION['message'])) {
        echo '<p>' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }
}
