<?php  session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormManager</title>

    <link rel="stylesheet" href="./css/home.css">
</head>

<body>

    <?php
    $id = $_SESSION['user'];

    include './database.php';
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    // print_r($user);
    ?>
    <h2>hi <?php echo $user["name"] ?></h2>

    <div style="overflow-x: auto;">
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo $user["name"] ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $user["email"] ?></td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td><?php echo $user["mobile"] ?></td>
            </tr>
            <tr>
                <th>Message</th>
                <td><?php echo $user["message"] ?></td>
            </tr>
            <tr>
                <th>File</th>
                <td><img src="<?php echo $user["file"] ?>" alt="" srcset=""></td>
            </tr>
        </table>
    </div>
</body>

</html>