<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=
    muziekPHP", "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>