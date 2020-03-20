<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require_once(__DIR__."/../thirdParty/vendor/autoload.php");


function sendMail($to, $subject, $body, $attachment = FALSE){

    if(defined('MAIL_TYPE') == false){
        die('Please Define the Mail Type Setting in config/app.php');
    }else{

        if(MAIL_TYPE === "PHP_MAILER"){

            phpMail($to, $subject, $body);

        }else if(MAIL_TYPE === "PHP_SMTP"){

            phpSmtp($to, $subject, $body, $attachment);
        }
    }
}


function phpMail($to, $subject, $body){

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers  .= 'From: <'.SMTP_FORM.'>' . "\r\n" .
        'Reply-To: '.SMTP_REPLY_TO. "\r\n" .
        'X-Mailer: PHP/' . phpversion();


    try{

        mail($to, $subject, $body, $headers);

        return true;

    }catch(Exception $e){

        return false;

    }

}

function phpSmtp($to, $subject, $body, $attachment = FALSE){

    $smtp_mail_name     = SMTP_MAIL;
    $smtp_mail_pass     = SMTP_PASS;
    $smtp_mail_reply_to = SMTP_REPLY_TO;
    $smtp_form          = SMTP_FORM;
    $smtp_name          = SMTP_NAME;

    # echo $smtp_mail_name." <br/>".$smtp_mail_pass;

    // Passing `true` enables exceptions

    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = 2;
        $mail->SMTPDebug = 0;

        // Enable verbose debug output
        $mail->isSMTP();

        // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';

        // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;

        // Enable SMTP authentication
        $mail->Username = $smtp_mail_name;

        // SMTP username
        $mail->Password = $smtp_mail_pass;

        // SMTP password
        $mail->SMTPSecure = 'tls';

        // Enable TLS encryption, `ssl` also accepted

        $mail->Port = 587;

        // TCP port to connect to

        //Recipients

        $mail->setFrom($smtp_form, $smtp_name);

        //$mail->addAddress('joe@example.net', 'Joe User');

        // Add a recipient
        $mail->addAddress($to);

        // Name is optional
        $mail->addReplyTo($smtp_mail_reply_to, 'Information');

        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');

        // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');

        if($attachment){

            $mail->addAttachment($attachment);

        }

        // Optional name

        //Content
        $mail->isHTML(true);

        // Set email format to HTML
        $mail->Subject = $subject;

        # this is the html supported body ...
        $mail->Body    = $body;

        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        # this will stop sending double time ..

        $mail->ClearAllRecipients();

        #echo 'Message has been sent';

        return true;

    } catch (Exception $e) {
        // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;

        return false;
    }
}

/*$to       = "arafat.dml@gmail.com";
$subject    = "my subject";

$body       = "
<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h3 style='color: red;'>Hi there</h3>
<p style='color: green;'>Let's plan new Things</p>

<h2>HTML Table</h2>

<table>
  <tr>
    <th>Company</th>
    <th>Contact</th>
    <th>Country</th>
  </tr>
  <tr>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
  </tr>
  <tr>
    <td>Centro comercial Moctezuma</td>
    <td>Francisco Chang</td>
    <td>Mexico</td>
  </tr>
  <tr>
    <td>Ernst Handel</td>
    <td>Roland Mendel</td>
    <td>Austria</td>
  </tr>
  <tr>
    <td>Island Trading</td>
    <td>Helen Bennett</td>
    <td>UK</td>
  </tr>
  <tr>
    <td>Laughing Bacchus Winecellars</td>
    <td>Yoshi Tannamuri</td>
    <td>Canada</td>
  </tr>
  <tr>
    <td>Magazzini Alimentari Riuniti</td>
    <td>Giovanni Rovelli</td>
    <td>Italy</td>
  </tr>
</table>

</body>
</html>
";


/* if($sentOk){
    echo "<br/>Admin Mail send";
}else{
 echo "<br/>admin mail Sending Failed";
}*/