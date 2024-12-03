<?php

include("config.php");

session_start();

if ($_SESSION) {
    if ($_SESSION['role'] == 1) {
        echo "Welcome to the admin page " . $_SESSION['user'];
    } else {
        echo "You need to be an administrator";
    }
} else {
    echo "An error occured, you will be redirected shortly...";
    header("refresh;2 url=login.php");
}
