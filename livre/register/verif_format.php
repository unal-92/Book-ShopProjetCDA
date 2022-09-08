<?php
session_start();
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

if (isset($_POST['login'], $_POST['name'], $_POST['lastname'], $_POST['birthdate'], $_POST['email'], $_POST['password'])) {
    $options = [
        'cost' => 12,
    ];
   
    $hash_pass = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
    $sql = "INSERT INTO `user` (login, name, lastname, birthdate, email, password) VALUES (:login, :name, :lastname, :birthdate, :email, :hash_pass)"; //* := allias
    $res = db($sql, [
        'login' => $_POST['login'],
        'name' => $_POST['name'],
        'lastname' => $_POST['lastname'],
        'birthdate' => $_POST['birthdate'],
        'email' => $_POST['email'],
        'hash_pass' => $hash_pass
    ]);

    $_SESSION['user'] = [
        // 'id' => $db->insert_id,
        'login' => $_POST['login'],
        'name' => $_POST['name'],
        'lastname' => $_POST['lastname'],
        'birthdate' => $_POST['birthdate'],
        'email' => $_POST['email'],
        'is_admin' => '0' 
    ];
    //print_r($res);



    //! Message de bienvenue lors de l'inscription
    smtpMailer($_POST['email'], 'Bienvenue sur BookShop', 'merci de vous joindre à cette grande famille');

    echo json_encode(['success' => true, 'user' => $_SESSION['user']]);
} else {

    echo json_encode(['success' => false]);
}



//! Security -> hash password
// $hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

// $sql = "INSERT INTO user (name, last_name, password, email) VALUES ('{$_POST['fname']}','{$_POST['lastname']}','{$hash}','{$_POST['email']}')";
// $db->query($sql);

// echo json_encode(['success' => true]);
// } else echo json_encode(['success' => false]);