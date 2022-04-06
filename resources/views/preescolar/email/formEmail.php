
<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use phpMailer\PHPMailer;
use phpMailer\SMTP;
use phpMailer\Exception;

$email = $_POST["email"];
$asunto = $_POST["asunto"];
$mensaje = $_POST["mensaje"];
$adjunto = $_POST["adjunto"];

$body = "email : ".$email."<br>Mensaje: ".$mensaje ;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'reportes.grados@gmail.com';                     //SMTP username
    $mail->Password   = 'reportesgrados2021';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($email, 'prueba');           //Add a recipient
    $mail->addAddress($email);     //Name is optional
                                                           
    
    //Attachments
    
    $mail->addAttachment($_FILES['adjunto']['tmp_name'], $_FILES['adjunto']['name']);    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $body;
    $mail->AltBody = $mensaje;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>


