<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Script is running!";

session_start();
require('../sql.php'); 
require_once('../vendor/autoload.php'); // Ensure this path is correct

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email=$_SESSION['farmer_login_user'];
$res=mysqli_query($conn,"select * from farmerlogin where email='$email'");
$count=mysqli_num_rows($res);

if($count>0) {
    $otp=rand(100000, 999999);
    mysqli_query($conn,"update farmerlogin set otp='$otp' where email ='$email'");
    
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
        echo "yes"; // Or redirect to OTP verification page
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "not exist";
}
?>