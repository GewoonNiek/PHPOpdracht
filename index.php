<?php
include("config.php");

$con = $db->prepare("select * from product");
$con->execute(array());

$x = $con->fetchAll(PDO::FETCH_ASSOC);

foreach ($x as $z) {
    ?>

    <div style="border:1px solid #ddd; height:300px; width:500px; margin:5px; padding:2px; float:left;">
        <h2 style="border:1px solid #ddd; background:pink; fontsize 14px; font-family: verdana;">
            <?php echo $z["name"]; ?>
        </h2>
        <?php echo $z["description"]; ?>
        <br><br><br><br>
        <a onclick="return confirm('Are you sure you want to remove this product?');"
            href="deleteItem.php?id=<?php echo $z['id']; ?>">Delete item!</a>

    </div>
    <?php

}
?>