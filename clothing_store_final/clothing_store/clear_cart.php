// clear_cart.php
<?php
session_start();
$_SESSION['cart_items'] = [];
echo json_encode(['success' => true]);
?>
