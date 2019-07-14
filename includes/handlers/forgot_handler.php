
<?php
$email = "";
if (isset($_POST['forgot_pass'])) {
    $email = validation_input($_POST['email']); //Last name
    if(strtolower($email) == "guest@gmail.com"){
        header("Location: index.php");
        exit;
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $transport = new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls');
        $transport->setUsername('email@gmail.com');
        $transport->setPassword('password');
        $mailer = new Swift_Mailer($transport);
        $message = new Swift_Message('Password Recovery!');
        $message->setFrom(['from@gmail.com' => 'SkyFall Support Team']);
        $message->setContentType("text/html");
        $message->setTo($email); //change to localhost
        $message->setBody("<h2>Hello, please click on the following link to reset your password"
                . "<p>"
                . "<a href='http://skyfall2019.000webhostapp.com/reset.php?email=$email&token=$token'>Reset my password</a>"
                . "</p>");
        if ($mailer->send($message)) {
            array_push($error_array, "Message has been sent, check your inbox<br>");
        } else {
            echo 'Message could not be sent';
        }
    } else {
        array_push($error_array, "Invalid email format<br>");
    }
}
