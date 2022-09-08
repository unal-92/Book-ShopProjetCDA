<?php
require_once('../utils/db_connect.php');
require_once('../utils/function.php');
require_once('../utils/mailer.php');


//! vérification du format de la date de naissance
$regex = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
if (!preg_match($regex, $_POST['birthdate'])) {
    echo json_encode(['success' => false, 'msg' => "la date  de naissance n'est pas au bon format"]);
    die();
}

//! vérification du format du mail
$regex = "/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
if (!preg_match($regex, $_POST['email'])) {
    echo json_encode(['success' => false, 'msg' => "l'email n'est pas au bon format"]);
    die();
}

//! Security -> hash password
if (isset($_POST['login'], $_POST['name'], $_POST['lastname'], $_POST['birthdate'], $_POST['email'], $_POST['password'])) {

    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (login, name, lastname, birthdate, email, password) VALUES ('{$_POST['login']}', '{$_POST['name']}','{$_POST['lastname']}','{$_POST['birthdate']}','{$_POST['email']}','{$hash}')";
    $db->query($sql);




    //! Message de bienvenue lors de l'inscription
    smtpMailer($_POST['email'], 'Bienvenue sur BookShop', 'merci de vous joindre à cette grande famille');

    echo json_encode(['success' => true]);
} else {

    echo json_encode(['success' => false]);
}



// $sql = htmlspecialchars(trim($_POST['email']));
// mysqli_real_escape_string(trim($_POST(connection, escapestring));
