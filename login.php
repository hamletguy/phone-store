<?php
include 'db.php';
session_start();

if (isset($_POST['login'])) {
    $u = $_POST['u'];
    $p = $_POST['p'];

    // Secret Admin Code Check
    if ($u === '14720680' && $p === '14720680') {
        $_SESSION['u'] = "Master Admin";
        $_SESSION['r'] = 'admin';
        header("Location: index.php");
        exit();
    }

    $res = $conn->query("SELECT * FROM users WHERE username='$u'");
    $user = $res->fetch_assoc();

    if ($user && password_verify($p, $user['password'])) {
        $_SESSION['u'] = $user['username'];
        $_SESSION['r'] = $user['role'];
        header("Location: index.php");
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Login | TechStore</title>
</head>
<body class="auth-page"> <div class="auth-card"> <h2>Welcome Back</h2>
        <p>Sign in to manage your orders.</p>
        
        <?php if(isset($error)) echo "<p style='color:red; font-size:0.8rem;'>$error</p>"; ?>

        <form method="POST">
            <input name="u" placeholder="Username" required>
            <input name="p" type="password" placeholder="Password" required>
            <button name="login" class="btn">Sign In</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="register.php">Create one</a>
        </div>
    </div>

</body>
</html>