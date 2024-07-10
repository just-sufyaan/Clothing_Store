<?php
session_start();

include('DBConn.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data)) {
    $cardName = $data['cardName'];
    $cardNumber = $data['cardNumber'];
    $expiryDate = $data['expiryDate'];
    $cvv = $data['cvv'];
    $cartItems = $data['cartItems'];

    if (!empty($cartItems)) {
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $price = floatval(str_replace("R", "", $item['price']));
            $totalAmount += $price * $item['quantity'];
        }

        $date = date('Y-m-d');
        $time = date('H:i:s');
        $status = "Processing";

        $query = "INSERT INTO tblaorder (UserID, OrderDate, OrderTime, TotalAmount, Status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("issss", $_SESSION['user_id'], $date, $time, $totalAmount, $status);

        if ($stmt->execute()) {
            $orderID = $stmt->insert_id;

            $query = "INSERT INTO orderline (OrderID, ClothingID, Quantity) VALUES (?, ?, ?)";
            $stmt = $connect->prepare($query);

            foreach ($cartItems as $item) {
                $stmt->bind_param("iii", $orderID, $item['clothingID'], $item['quantity']);
                if (!$stmt->execute()) {
                    file_put_contents("place_order_debug.txt", "Error inserting into orderline: " . $stmt->error . "\n", FILE_APPEND);
                }
            }

            foreach ($cartItems as $item) {
                $query = "UPDATE tblclothes SET QuantityAvailable = QuantityAvailable - ? WHERE ClothingID = ?";
                $stmt = $connect->prepare($query);
                $stmt->bind_param("ii", $item['quantity'], $item['clothingID']);
                $stmt->execute();
            }

            unset($_SESSION['cart_items']);

            $response = array("success" => true);
            echo json_encode($response);
        } else {
            $response = array("success" => false, "error" => "Failed to insert order");
            echo json_encode($response);
        }
    } else {
        $response = array("success" => false, "error" => "No cart items received");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "error" => "No data received");
    echo json_encode($response);
}
?>
