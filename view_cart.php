<?php
session_start();

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
    echo '<a href="index.php">Ga terug naar de artikelen</a>';
    echo '<a href="view_cart.php">Bekijk winkelkar</a>';
} else {
    echo "<p>Ongeldig verzoek.</p>";
}
?>