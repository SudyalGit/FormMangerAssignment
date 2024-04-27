<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Manager | Login</title>

    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <h2>Please Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="login">login</button>
        <span>don't have an account <a href="./">register</a></span>
    </form>
</body>

<?php if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pwd = $_POST['password'];

    include './database.php';
    $sql = "SELECT * FROM users WHERE email = '$email' and password = '$pwd'";
    $result = $conn->query($sql);
    $count = $result->num_rows;
    $user = $result->fetch_assoc();
    if ($count == 1) {
        $_SESSION['user'] = $user['id'];
        echo "<script type='text/javascript'>window.location.href='home.php';</script>";
    } else {
        echo "<div style='color: red; text-align: center'>INVALID USER</div>";
    }

    $conn->close();
} ?>

</html>