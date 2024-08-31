<?php 

$mysqli = new mysqli("localhost", "root", "", "product_db");

if ($mysqli->connect_error){
    die("Connection Failed: " . $mysqli->connect_error);
}

$product = null;

if (isset($_GET['id'])) {
    $id =intval($_GET['id']);
    $result =$mysqli->query("SELECT * FROM products WHERE id=$id");

    if ($result && $result->num_rows > 0){
        $product = $result->fetch_assoc();
    } else {
        echo "No product found with this ID.";
        exit ();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id =intval($_POST['id']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

   $stmt = $mysqli->prepare("UPDATE products SET name=?, description=?, price=?, quantity=?, updated_at=NOW() WHERE id=?");
   $stmt->bind_param("ssdii", $name, $description, $price, $quantity, $id);

   if ($stmt->execute()) {
    header("Location: index.php");
    exit();
   } else {
    echo "Error updating product: " . $stmt->error;
   }
   $stmt->close();
}

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <?php if ($product): ?>
    <form action="edit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <label for="name">Name: </label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br><br>

        <label for="description">Description: </label>
        <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($product['description']); ?>" required><br><br>


        <label for="price">Price: </label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br><br>


        <label for="quantity">Quantity: </label>
        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required><br><br>


        <button type="submit">Update</button>
    </form>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
</body>
</html>