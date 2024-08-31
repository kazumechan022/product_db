<?php 

$mysqli = new mysqli("localhost", "root", "", "product_db");

if ($mysqli->connect_error){
    die("Connection failed: " . $mysqli->connect_error);
}

if (isset($_GET['delete']) ){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM products WHERE id=$id") or die($mysqli->error);

    header("Location: index.php");
}

$result = $mysqli->query("SELECT * FROM products") or die($mysqli->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>
    <h1>Product List</h1>
    <a class="btn btn-primary" href="create.php" role="button">Create New Product</a>

    <table border="1" cellpading="15" cellspacing="0">
        <thread>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
    <tbody>
        <?php while($row =$result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </tr>
        <?php endwhile; ?>
            </td>
            </tr>
    </tbody>

    </table>
</body>
</html>