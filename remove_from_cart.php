<?php
include("config.php");
session_start();

$id = $_GET['id'];
$query = "DELETE FROM shoppingcart_item WHERE `shoppingcart_item`.`id` = ?";
$con = $db->prepare($query);
$con->execute(array($id));

header('Location: view_cart.php');
exit;
