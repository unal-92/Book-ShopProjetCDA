<?php
// Importez les classes PHPMailer dans l'espace de noms global 
// Celles-ci doivent être en haut de votre script, pas dans une fonction 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Charger l'autochargeur de Compositeur 
require '../vendor/autoload.php';

function smtpMailer($to, $subject, $body)
{
    $mail = new PHPMailer(); // L'instanciation et le passage de «true» activent les exceptions 

    try {
        // Paramètres du serveur 
        $mail->isSMTP(); // Envoi en utilisant SMTP 
        $mail->SMTPDebug = 0; // Activer la sortie de débogage détaillée
        $mail->SMTPAuth = true; // Activer l'authentification SMTP 
        $mail->SMTPSecure = 'ssl'; // Activer le cryptage TLS; `PHPMailer :: ENCRYPTION_SMTPS` encouragé 

        $mail->Host = 'smtp.gmail.com'; // Définit le serveur SMTP pour qu'il envoie via 
        $mail->Port = 465;  // Port TCP auquel se connecter, utilisez 465 pour `PHPMailer :: ENCRYPTION_SMTPS` ci-dessus
        $mail->Username = "bookshop.imie@gmail.com";
        $mail->Password = "Bookshop92";
        $mail->setFrom("bookshop.imie@gmail.com", 'bookshop');
        $mail->Subject = $subject; // ceci est le sujet
        $mail->Body = $body; // Ceci est le corps du message HTML <b> en gras! </b>' ;
        $mail->addAddress($to);

        $mail->send();

        //  echo "Message envoyé";
    } catch (Exception $e) {
        echo "Error";
    }
}

// $res = smtpMailer('bookshop.imie@gmail.com', 'Ceci est un sujet', 'Ceci est un body');

// $mail->Body = $body;
// $mail->isHTML(true);
// $mail->CharSet = "utf-8";
// $mail->msgHTML($body);
