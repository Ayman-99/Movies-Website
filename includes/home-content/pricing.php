<article class="plans" id="menu_price">
    <div class="container">
        <h2 class="animated" data-animation="fadeInUp" data-animation-delay="200">Ours Plans</h2>
        <h6 class="animated" data-animation="fadeInUp" data-animation-delay="400">Choose the most suitable plan for you!</h6>

        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="plans-items animated" data-animation="flipInY" data-animation-delay="200">
                    <strong>$0<small>/month</small></strong>
                    <p>Free</p>
                    <ul style="color: black;">
                        <li>- Ability to rate on movie</li>
                        <li>- Ability to like/dislike movie</li>
                    </ul>
                    <a href="register.php" class="btn btn-plans">Sing Up</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="plans-items animated" data-animation="flipInY" data-animation-delay="600">
                    <strong>$10<small>/month</small></strong>
                    <p>Premium</p>
                    <ul style="color: black;">
                        <li>- Access to premium movie</li>
                        <li>- Access to chat with Developers</li>
                        <li>- Ability to view any profile</li>
                        <li>- Ability to comment on movies</li>
                        <li>- Ability to like/dislike movie</li>
                        <li>- Ability to rate on movies</li>
                    </ul>
                    <a data-toggle="modal" href="#priceModal" class="btn btn-plans">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</article>

<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="examplePriceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>"> 
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Email:</label>
                        <input type="email" name="u_email" class="form-control" id="recipient-name" required="">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Plan:</label>
                        <input type="text" name="u_payment" class="form-control" value="Premium" readonly="">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message (Optional):</label>
                        <textarea name="u_mess" class="form-control" id="message-text"></textarea>
                    </div>
                    <button type="submit" name="sendMess" class="btn btn-primary">Send message</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['sendMess'])) {

    $email = $_POST['u_email'];
    $type = $_POST['u_payment'];
    $userMessage = $_POST['u_mess'];

    $txt = "email: $email -- type: $type -- message: $userMessage\n";

    $transport = new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls');
    $transport->setUsername('work000test@gmail.com');
    $transport->setPassword('32145688+++');

    $mailer = new Swift_Mailer($transport);

    $txt2 = "This person would like to contact you";
    $message = new Swift_Message('Notification!');
    $message->setFrom(['work000test@gmail.com' => 'YourMovies Support Team']);
    $message->setTo(['aymanhun@gmail.com' => 'Ayman Hunjul']);
    $message->setBody("This person would like to contact you\nemail: $email\ntype: $type\nmessage: $userMessage");

    $result = $mailer->send($message);

    $myfile = fopen("admin/pages/payments.txt", "a+");
    fwrite($myfile, $txt);
    fclose($myfile);
    echo "<script>alert('Message sent successfully. We will contact you within 24 hours');</script>";
}
?>
