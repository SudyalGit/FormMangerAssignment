<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Manager | Register</title>

    <link rel="stylesheet" href="./css/register.css">
</head>

<body>
    <h2>Please Register</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="mobile" placeholder="Moblie" maxlength="10" minlength="10" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="file" name="file" accept="image/jpeg" required>
        <textarea name="message" placeholder="Message" cols="30" rows="5"></textarea>
        <button type="submit" name="register">register</button>
        <span>already have an account <a href="login.php">login</a></span>
    </form>

    <?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    if (isset($_POST['register'])) {
        // print_r($_POST);

        // USER FORM DATA
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $pwd = $_POST['password'];
        $message = $_POST['message'];
        $id = date('YmdHis');

        // Validate file upload
        $file = $_FILES["file"];
        $file_name = $file["name"];
        $file_temp = $file["tmp_name"];
        $file_size = $file["size"];

        // Check if file is JPEG and within size limit
        $allowed_extensions = array("jpg", "jpeg");
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!in_array($file_extension, $allowed_extensions) || $file_size > 500000) {
            echo "<script>alert('please upload less than 500kb file')</script>";
        } else {
            // Move uploaded file to file manager
            $upload_directory = "uploads/";
            $new_file_name = $upload_directory . uniqid() . "." . $file_extension;
            move_uploaded_file($file_temp, $new_file_name);


            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'sudhyal99@gmail.com';                     //SMTP username
                $mail->Password   = 'password';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('sudhyal99@gmail.com', 'Sudhanshu');
                $mail->addAddress($email, $name);     //Add a recipient

                //Attachments
                $mail->addAttachment($new_file_name);         //Add attachments

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = "Registeration Completed";
                $mail->Body    = "Hi $name, Thank you for registering on Form Manager. You can login to see your profile click here for login <a href='youtube.com'>login</a>";

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            include './database.php'; //DATABASE CONNECTION
            $sql = "INSERT INTO users (id, name, email, mobile, password, file, message) VALUES ('$id', '$name', '$email', '$mobile', '$pwd', '$new_file_name', '$message')";
            if ($conn->query($sql) === TRUE) {
                echo "<script type='text/javascript'>window.location.href='sent.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }
    ?>
</body>

</html>