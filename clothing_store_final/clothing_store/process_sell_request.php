<?php
session_start();
include 'DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $userID = $_POST['userID'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "Images/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if (file_exists($targetFile)) {
            $baseName = pathinfo($fileName, PATHINFO_FILENAME);
            $counter = 1;
            while (file_exists($targetFile)) {
                $newFileName = $baseName . '_' . $counter . '.' . $imageFileType;
                $targetFile = $targetDir . $newFileName;
                $counter++;
            }
            $fileName = $newFileName;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $query = "INSERT INTO tblsellerrequests (UserID, Title, Description, Size, Brand, Price, QuantityAvailable, ImageURL) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $connect->prepare($query);
                $stmt->bind_param("issssdss", $userID, $title, $description, $size, $brand, $price, $quantity, $targetFile);

                if ($stmt->execute()) {
                    $message = "New record created successfully and waiting on the admin to confirm the details.";
                } else {
                    $message = "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $message = "No file was uploaded or there was an upload error.";
    }
} else {
    header("Location: sell_clothes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message-container h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .message-container p {
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
    <script>
        function startCountdown(duration, display) {
            var timer = duration, seconds;
            var interval = setInterval(function () {
                seconds = parseInt(timer, 10);

                display.textContent = seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    window.location.href = 'homepage.php';
                }
            }, 1000);
        }

        window.onload = function () {
            var countdownDuration = 5,
                display = document.querySelector('#countdown');
            startCountdown(countdownDuration, display);
        };
    </script>
</head>

<body>
    <div class="message-container">
        <h1>Submission Status</h1>
        <p><?php echo $message; ?></p>
        <p>You will be redirected to the homepage in <span id="countdown">5</span> seconds.</p>
    </div>
</body>

</html>
