<?php
session_start();
require_once('../utils/db_connect.php');
require_once('../utils/function.php');

// Récuperer les données 

if (!empty($_POST)) { //! si $_POST n'est pas vide

    $mail = $_POST['mail'];
    $password = $_POST['password']; //! $password = $_POST qui a pour valeur password

    $req = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $req->execute([$mail]);
    $resultat = $req->fetch(PDO::FETCH_ASSOC); 
 


    if ($resultat && password_verify($password, $resultat['password'])) {  
        $_SESSION['user'] = [ //session 
            'id' => $resultat['iduser'],
            'login' => $resultat['login'],
            'name' => $resultat['name'],
            'lastname' => $resultat['lastname'],
            'birthdate' => $resultat['birthdate'],
            'email' => $resultat['email'],
            // 'password' => $resultat['password'], //!
            'is_admin' => $resultat['is_admin'] //!
        ];
        echo json_encode(['success' => true, 'user' => $_SESSION['user']]); //!
    } else {
        echo json_encode(['success' => false]); //!
        //echo "utilisateur introuvable";
    }

    //echo "connexion reussie";
}
