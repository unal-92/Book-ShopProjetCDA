<?php
session_start();
require_once('../utils/db_connect.php');
require_once('../utils/function.php');

// Récuperer les données 

// if (!empty($_POST)) {
// if (isset($_POST['mail'], $_POST['password'])) {
// switch ($_POST['choice']) {
//     case 'infoUser':

//         $myid = $_SESSION['user']['id'];
//         $reqUser = $db->query("SELECT * FROM user WHERE iduser = $myid");
//         $resUser = resultAsArray($reqUser);
//         if ($resUser) {
//             echo json_encode(["resUser" => $resUser]);
//         }
//         break;

//     case 'update':

//         $myid = $_SESSION['user']['id'];
//         // $reqUser = $db->query("UPDATE user SET login='[value-2]',name='[value-3]',lastname='[value-4]',birthdate='[value-5]',email='[value-6]',password='[value-7]',is_admin='[value-8]' WHERE iduser=$my_id");
//         $sql = "UPDATE user SET name='{$_POST['name']}', lastname='{$_POST['lastname']}', birthdate='{$_POST['birthdate']}', email='{$_POST['email']}' WHERE iduser=$myid";
//         $db->query($sql);
//         echo json_encode(['success' => true]);
//         break;
// }

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $method = $_POST;
} else {
    $method = $_GET;
}

switch ($method['choice']) {
    case 'select_id':
        $resSql = $pdo->prepare("SELECT name, lastname, birthdate, email FROM user WHERE iduser = ? ");
        $resSql->execute([$_SESSION['user']['id']]);
        $account = $resSql->fetch(PDO::FETCH_ASSOC);           
        echo json_encode(['success' => true, 'user' => $account]);
        break;


    case 'update':
        if (
            isset($method['name'], $method['lastname'], $method['birthdate'], $method['email']) &&
            !empty(trim($method['name'])) &&
            !empty(trim($method['lastname'])) &&
            !empty(trim($method['birthdate'])) &&
            !empty(trim($method['email']))
        ) { 
            $resSql = $pdo->prepare ("UPDATE user SET name = :name, lastname = :lastname, birthdate= :birthdate, email = :email WHERE iduser = :id");
            $resSql->bindValue("name", $method['name']);
            $resSql->bindValue("lastname", $method['lastname']);
            $resSql->bindValue("birthdate", $method['birthdate']);
            $resSql->bindValue("email", $method['email']);
            $resSql->bindValue("id", $_SESSION['user']['id']);
            $resSql->execute();
            echo json_encode(['success' => true]);

        } else echo json_encode(['success' => false]);
        break;

    default:
        echo json_encode(['success' => false]);  
        break;
}