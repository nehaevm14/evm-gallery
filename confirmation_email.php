<?php 

    $to = $shop_email; // this is your Email address
    $from = "support@expertvillagemedia.com"; // this is the sender's Email address
    $subject = "Thank you for installing our Instagram Feed App!";
    $message = "Hello,

Thank you very much for installing our App!

If you have any Issues or Questions please let us know by replying to this email and We will respond to you asap.

Hope you enjoy using our app!

Kind regards,
Expert Village Media";
    $f = "From:" . $from;
    mail($to,$subject,$message,$f);
    
?>

