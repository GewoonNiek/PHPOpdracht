<?php session_start();
include 'config.php'; // Winkelkar initialiseren
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$userid = $_SESSION['user_ID'];
$sql = "SELECT shoppingcart_ID FROM shoppingcart WHERE UserID = ?";
$con = $db->prepare($sql);
$con->execute(array($_SESSION['user_ID']));
$x = $con->fetch(PDO::FETCH_ASSOC);



$sql = "SELECT * FROM shoppingcart_item WHERE shoppingcart_ID = ?";
$con = $db->prepare($sql);
$con->execute(array($x['shoppingcart_ID']));
$cart = $con->fetchAll(PDO::FETCH_ASSOC);

echo "<button onclick=\"window.location.href='index.php'\">Back to menu</button>";
?>
<table style="border: 1px solid;">
    <tr>
        <td>Product name: </td>
        <td>Price: </td>
        <td>Amount: </td>
    </tr>
    <?php
    foreach ($cart as $item) {
        $sql = "SELECT * FROM artikel WHERE artikel_ID = ?";
        $con = $db->prepare($sql);
        $con->execute(array($item['product_id']));
        $product = $con->fetch(PDO::FETCH_ASSOC);
        ?>
        <tr>
            <td><?php echo $product['artikel_Name'] ?></td>
            <td><?php echo $product['price'] ?></td>
            <td><?php echo $item['amount'] ?></td>
            <td><a href="remove_from_cart.php?id=<?php echo $item['id'] ?>">remove item</a>

        </tr>
        <?php
    }


    ?>
</table>