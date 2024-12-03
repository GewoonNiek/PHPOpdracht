<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=muziekphp"
    , "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>