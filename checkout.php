<?php include 'db.php'; session_start();
if(!isset($_SESSION['u_id'])) die("Please <a href='login.php'>Login</a> first.");
$total = 0;
foreach($_SESSION['cart'] as $id => $qty) {
    $p = $conn->query("SELECT price FROM products WHERE id=$id")->fetch_assoc();
    $total += $p['price'] * $qty;
}
$conn->query("INSERT INTO orders (user_id, total_price) VALUES ({$_SESSION['u_id']}, $total)");
$_SESSION['cart'] = [];
echo "<h2>Order Successful!</h2><a href='index.php'>Back to Home</a>";
?>