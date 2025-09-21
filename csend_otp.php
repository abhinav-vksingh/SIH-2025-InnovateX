<?php
session_start();
require('../sql.php'); 
// This path is correct for including the Composer-installed PHPMailer
require_once('../vendor/autoload.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_SESSION['customer_login_user'];
$res = mysqli_query($conn, "select * from custlogin where email='$email'");
$count = mysqli_num_rows($res);

if($count > 0) {
    // Generate a random 6-digit OTP
    $otp = rand(100000, 999999);
    // Update the database with the new OTP
    mysqli_query($conn, "update custlogin set otp='$otp' where email ='$email'");
    
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vikramsinghabhinav@gmail.com'; // Your full Gmail address
        $mail->Password   = 'pxwpywtczzhglokx'; // Your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        $mail->setFrom('vikramsinghabhinav@gmail.com', 'Agriculture Portal');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body    = "Your OTP verification code is: <b>$otp</b>";
        
        $mail->send();
        echo "yes"; // You should redirect to the OTP verification page instead
    } catch (Exception $e) {
        // Revert to the original error message
    echo "not exist";
    }
} else {
    echo "not exist";
}
?>