<?php
try {
    $db = new PDO(
        "mysql:host=localhost;dbname=PHPOpdracht"
        ,
        "root",
        ""
    );
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>