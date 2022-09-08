<?php
session_start();
require_once('../utils/db_connect.php');
require_once('../utils/function.php');

// Récuperer les données 

//if (!empty($_POST)) {

//if (isset($_POST['mail'], $_POST['password'])) {

$mail = $_POST['mail'];
$password = $_POST['password']; //! $password = $_POST qui a pour valeur password


if (!empty($_POST)) { //! si $_POST n'est pas vide


    $req = "SELECT password, iduser, login, name, lastname, birthdate, email, is_admin FROM user WHERE email = '$mail'";
    $res = $db->query($req); //! envoi la requete a la bdd

    // $data = mysqli_fetch_assoc($res); //! traiter le data

    if ($data = mysqli_fetch_assoc($res)) {
        if (password_verify(($password), $data["password"])) {
            $_SESSION['user'] = [ //!
                'iduser' => $data['iduser'],
                'login' => $data['login'],
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'birthdate' => $data['birthdate'],
                'email' => $data['email'],
                // 'password' => $data['password'], //!
                'is_admin' => $data['is_admin'] //!
            ];

            echo json_encode(['success' => true]); //!
        } else {
            echo json_encode(['success' => false]); //!
        }
    }
}
