<?php 
include 'db.php'; 
session_start();

// 1. Security Check
if(!isset($_SESSION['r']) || $_SESSION['r'] != 'admin') {
    die("Access Denied. You must be an admin.");
}

// 2. Add Product Logic
if(isset($_POST['add'])){
    $name = $_POST['n'];
    $cat  = $_POST['c'];
    $pri  = $_POST['p'];
    $sto  = $_POST['s'];

    // --- Image Upload Logic ---
    $target_dir = "uploads/";
    $file_name = time() . "_" . basename($_FILES["product_image"]["name"]); // Add timestamp to avoid duplicate names
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        // If upload successful, save the path 'uploads/filename.jpg' to the DB
        $conn->query("INSERT INTO products (name, category, price, stock, image_url) 
                      VALUES ('$name','$cat','$pri','$sto','$target_file')");
        header("Location: admin.php?success=1");
    } else {
        echo "<script>alert('Error uploading file.');</script>";
    }
}

// 3. Delete Product Logic
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: admin.php"); // Refresh after deleting
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <div class="admin-wrapper">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 style="margin: 0; text-align: left;">Inventory Management</h2>
            <a href="index.php" class="btn" style="background: var(--accent); font-size: 0.8rem;">← Back to Store</a>
        </header>

        <div class="admin-card">
            <h3>Add New Product</h3>
            <form method="POST" enctype="multipart/form-data" class="admin-form-grid">
                <div>
                    <label>Product Name</label>
                    <input name="n" placeholder="e.g., iPhone 15 Pro" required>
                </div>
                <div>
                    <label>Category</label>
                    <select name="c">
                        <option>Smartphones</option>
                        <option>Headphones</option>
                        <option>Chargers</option>
                        <option>Smartwatches</option>
                    </select>
                </div>
                <div>
                    <label>Price ($)</label>
                    <input name="p" type="number" step="0.01" placeholder="999.99" required>
                </div>
                <div>
                    <label>Stock</label>
                    <input name="s" type="number" placeholder="50" required>
                </div>
                    <div style="grid-column: span 2;">
    <label>Product Image (Upload File)</label>
    <input type="file" name="product_image" accept="image/*" required>
</div>
                </div>
                <div style="grid-column: span 2;">
                    <button name="add" class="btn" style="width: 100%; margin-top: 10px;">List Product on Store</button>
                </div>
            </form>
        </div>

        <h3>Active Inventory</h3>
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    <?php
    $res = $conn->query("SELECT * FROM products ORDER BY id DESC");
    while($row = $res->fetch_assoc()): ?>
    <tr>
        <td style="display: flex; align-items: center; gap: 15px;">
            <img src="<?php echo $row['image_url']; ?>" 
                 style="width: 45px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
            <strong><?php echo $row['name']; ?></strong>
        </td>
        
        <td><span style="background: #eee; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;"><?php echo $row['category']; ?></span></td>
        <td style="font-weight: 600;">$<?php echo number_format($row['price'], 2); ?></td>
        <td><?php echo $row['stock']; ?></td>
        <td>
            <a href="admin.php?delete=<?php echo $row['id']; ?>" 
               class="btn-delete" 
               onclick="return confirm('Remove this item?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>
        </table>
    </div>
</body>
</html>