<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artikel_ID'])) {
    $id = intval($_POST['artikel_ID']);

    // Verwijder het artikel met het opgegeven ID
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($id) {
            return $item['id'] !== $id;
        });
    }
}

header('Location: view_cart.php');
exit;
