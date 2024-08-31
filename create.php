<?php 

session_start();

$mysqli = new mysqli("localhost", "root", "", "product_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $mysqli->real_escape_string($_POST['name']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $price = intval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    $sql ="INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssii", $name, $description, $price, $quantity);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Product</title>
</head>
<body>
    <h2>Create New Product</h2>
    <form action="create.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name"  id="name" required><br><br>

        <label for="description">Description:</label>
        <input type="text" name="description" id="description" required><br><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" required><br><br>

        <input type="submit" value="Add Product">
    </form>
</body>
</html>