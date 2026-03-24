<?php include 'db.php'; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>TechStore | Premium Tech</title>
</head>
<body>
<header>
    <div class="logo">📱 TechStore</div>
    <nav>
        <a href="index.php">Shop</a>
        <a href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)</a>
        <?php if(isset($_SESSION['u'])): ?>
            <?php if($_SESSION['r'] == 'admin'): ?><a href="admin.php">Admin Panel</a><?php endif; ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">
    <h2>Explore the latest tech.</h2>
    <form method="GET">
        <input type="text" name="s" placeholder="Search for iPhone, AirPods, or Chargers..." value="<?php echo $_GET['s'] ?? ''; ?>">
    </form>

    <div class="product-grid">
        <?php
        $s = $_GET['s'] ?? '';
        $res = $conn->query("SELECT * FROM products WHERE name LIKE '%$s%'");
        while($r = $res->fetch_assoc()): ?>
            <div class="card">
                <img src="<?php echo $r['image_url']; ?>" alt="<?php echo $r['name']; ?>">
                
                <p style="color: #888; font-size: 0.8rem; text-transform: uppercase; margin: 0;"><?php echo $r['category']; ?></p>
                
                <h3><?php echo $r['name']; ?></h3>
                
                <p class="price">$<?php echo number_format($r['price'], 2); ?></p>
                
                <a href="add_to_cart.php?id=<?php echo $r['id']; ?>" class="btn">Add to Cart</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>