<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$Student_ID = $_POST['Student_ID'];
// put saf email here
$sender_email = 'someone@gmail.com';
$recipient_email = $Student_ID . '@g.siit.tu.ac.th';


// Picks up certificate ID from database

$sql = "SELECT * FROM `certificate` WHERE Student_ID = ?";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
$Certificate_ID = $row['Certificate_ID'];
$fileName = substr($Certificate_ID,0,2).'-'.substr($Certificate_ID,3,2).'_'. substr($Certificate_ID,6,5).'.pdf';



// check if the student is allegible to recieve a certificate
if ($Student_Status == 'active'){
    try{
        $email = new PHPMailer();
        
        $email->SetFrom("someone@gmail.com", 'Mailer'); //Name is optional
        $email->AddAddress("someone@gmail.com", "$Student_ID");
        $email->isHTML(true);
        $email->Subject   = 'Alumni Talk Certificate';
        $email->Body      = 'Congratulations on your <b>5TH!</b> alumni talk participation';    //HTML
        $email->AltBody    = 'Congratulations on your 5TH! alumni talk participation';
        
        $file_to_attach = "D:/XAMPP/htdocs/alumniTalk_CODE/certificate/download_certificate/$fileName";
    
        $email->AddAttachment( $file_to_attach , "$fileName" );
    
        $email->Send();
        $output = 'Message has been sent';
    } catch (Exception $e) {
        $output = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>