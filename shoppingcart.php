<?php
session_start();

// Winkelkar initialiseren
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Verzoeken verwerken
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'add') {
            $id = $_POST['id'];
            $name = $_POST['name'];
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
        } elseif ($action === 'remove') {
            $id = $_POST['id'];
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($id) {
                return $item['id'] !== $id;
            });
        } elseif ($action === 'clear') {
            $_SESSION['cart'] = [];
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Simpele Winkelkar</title>
</head>

<body>
    <h1>Winkelkar</h1>

    <!-- Winkelkar weergeven -->
    <?php if (!empty($_SESSION['cart'])): ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <li>
                    <?= htmlspecialchars($item['name']) ?> -
                    <?= $item['quantity'] ?> x €<?= number_format($item['price'], 2) ?> =
                    €<?= number_format($item['price'] * $item['quantity'], 2) ?>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="hidden" name="action" value="remove">
                        <button type="submit">Verwijderen</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Totaal: €<?= number_format(array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $_SESSION['cart'])), 2) ?></strong></p>
        <form method="post">
            <input type="hidden" name="action" value="clear">
            <button type="submit">Winkelkar Leegmaken</button>
        </form>
    <?php else: ?>
        <p>De winkelkar is leeg.</p>
    <?php endif; ?>

    <h2>Product Toevoegen</h2>
    <form method="post">
        <input type="hidden" name="action" value="add">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required>
        <br>
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="price">Prijs:</label>
        <input type="number" id="price" name="price" step="0.01" required>
        <br>
        <label for="quantity">Aantal:</label>
        <input type="number" id="quantity" name="quantity" required>
        <br>
        <button type="submit">Toevoegen</button>
    </form>
</body>

</html>