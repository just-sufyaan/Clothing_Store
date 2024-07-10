<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);
$cart_items = $data['cart_items'] ?? [];

$_SESSION['cart_items'] = $cart_items;

echo json_encode(['success' => true]);
?>
