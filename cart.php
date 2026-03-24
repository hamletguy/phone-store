<?php include 'db.php'; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Your Cart | TechStore</title>
</head>
<body class="container">
    <header style="margin-bottom: 40px;">
        <h2 style="text-align: left;">Shopping Cart</h2>
        <a href="index.php" style="text-decoration: none; color: var(--accent);">← Continue Shopping</a>
    </header>

    <?php if(!empty($_SESSION['cart'])): ?>
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach($_SESSION['cart'] as $id => $qty): 
                    $res = $conn->query("SELECT * FROM products WHERE id=$id");
                    $p = $res->fetch_assoc();
                    $subtotal = $p['price'] * $qty;
                    $total += $subtotal;
                ?>
                <tr>
    <td style="display: flex; align-items: center; gap: 20px;">
        <img src="<?php echo $p['image_url']; ?>" 
             style="width: 70px; height: 70px; object-fit: contain; background: #fff; border-radius: 12px; border: 1px solid var(--gray-border);">
        <div>
            <strong style="display: block; font-size: 1.1rem;"><?php echo $p['name']; ?></strong>
            <span style="font-size: 0.8rem; color: #888;"><?php echo $p['category']; ?></span>
        </div>
    </td>
    <td style="font-weight: 600;">$<?php echo number_format($p['price'], 2); ?></td>
    <td><?php echo $qty; ?></td>
    <td style="font-weight: 700;">$<?php echo number_format($subtotal, 2); ?></td>
    
    <td>
        <a href="remove_from_cart.php?id=<?php echo $id; ?>" 
           style="color: #ff3b30; text-decoration: none; font-size: 1.2rem; font-weight: bold; padding: 5px 10px;"
           title="Remove Item">
           &times;
        </a>
    </td>
</tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right; padding: 20px; border-top: 2px solid var(--gray-border);">
            <p style="font-size: 1.2rem; color: #666;">Total Amount</p>
            <h2 style="font-size: 2.5rem; margin: 0 0 20px 0;">$<?php echo number_format($total, 2); ?></h2>
            <a href="checkout.php" class="btn" style="padding: 15px 40px; font-size: 1.1rem;">Complete Purchase</a>
        </div>

    <?php else: ?>
        <div style="text-align: center; padding: 100px 0;">
            <p style="font-size: 1.5rem; color: #888;">Your cart is feeling a bit light.</p>
            <a href="index.php" class="btn">Start Shopping</a>
        </div>
    <?php endif; ?>
</body>
</html>