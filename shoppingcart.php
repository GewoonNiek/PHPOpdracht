<?php
session_start();
include 'config.php';

// Winkelkar initialiseren
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Controleren of het formulier correct is verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artikel_ID'])) {
    $id = intval($_POST['artikel_ID']);
    $name = htmlspecialchars($_POST['artikel_Name'], ENT_QUOTES, 'UTF-8');
    $price = (float) $_POST['price'];
    $quantity = (int) $_POST['quantity'];


    $sql = "SELECT * FROM shoppingcart WHERE UserID = ?";
    $con = $db->prepare($sql);
    $con->execute(array($_SESSION['user_ID']));
    $x = $con->fetch(PDO::FETCH_ASSOC);

    $sql = "INSERT INTO shoppingcart_item (shoppingcart_id, product_id, amount) VALUES (?, ?, ?)";
    $con = $db->prepare($sql);
    $con->execute(array($x['shoppingcart_ID'], $id, $quantity));


    // Controleren of product al in winkelkar zit
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $id) {
            $item['quantity'] += $quantity; // Aantal verhogen
            $found = true;
            break;
        }
    }

    // Als product niet bestaat, toevoegen
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    echo "<p>Product succesvol toegevoegd aan de winkelkar!</p>";
    echo "<button onclick=\"window.location.href='index.php'\">Go back to menu</button> " . 
    "<button onclick=\"window.location.href='view_cart.php'\">Show shoppingcar</button> ";
} else {
    echo "<p>Ongeldig verzoek.</p>";
}
?>