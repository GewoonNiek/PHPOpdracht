<?php

session_start();

session_destroy();

echo "You have been logged out, you will be redirected shortly...";

header("refresh:2; url=login.php");