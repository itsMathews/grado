<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;

use Illuminate\Support\Facades\Redirect;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



class EmailController extends Controller
{
    

	public function index( Request $Requests){

    if($Requests){      



     //$query=trim($Requests->get('search'));
     //$adicional=DB::table('adicional')->where('descripcion','LIKE','%'.$query.'%')->orderBy('descripcion','desc')->paginate(7);
     //return view('preescolar.adicional.index',["adicional"=>$adicional,"search"=>$query]);
     return view('preescolar.email.index');

    }

	}

    public function envio(Request $Requests){
        $email = $Requests->input('email');
        $asunto = $Requests->input('asunto');
        $mensaje = $Requests->input('mensaje');
        $adjunto = $Requests->input('adjunto');

        $body = "email : ".$email."<br>Mensaje: ".$mensaje;

        require '../vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
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
            
            echo '<script>
                alert("El mensaje se envio correctamente")
                window.history.go(-1)
                </script>';
            
            
        } catch (Exception $e) {
            
            '<script>
                alert("El mensaje no se pudo enviar correctamente")
                window.history.go(-1)
                </script>';
        }
        


        

        
        
    }

	

    

  

    



}
