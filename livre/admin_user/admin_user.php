<?php
require_once('../utils/db_connect.php');
require_once('../utils/function.php');


//? $method = $_POST or $_GET
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $method = $_POST;
} else {
    $method = $_GET;
}

switch ($method['choice']) {
    case 'select_all':
        $resSql = $pdo->query("SELECT `iduser`, `login`, `name`, `lastname`, `birthdate`, `email` FROM user"); 

        while($user = $resSql->fetch(PDO::FETCH_ASSOC)) $users[] = $user;

        echo json_encode(["success" => true, "users" => $users]);
        break;


    case 'select_id':
        if (isset($method['id'])) {
            $resSql = $pdo->prepare("SELECT `iduser`, `login`, `name`, `lastname`, `birthdate`, `email` FROM user WHERE iduser = ?");
            $resSql->execute([$method['id']]);
            $user = $resSql->fetch(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true,'user' => $user]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        } else echo json_encode(['success' => false]); //! else send success false
        break;

    case 'update':
        if (isset($method['flogin'], $method['fname'], $method['flastname'], $method['fbirthdate'], $method['femail'], $method['id'])) {

            // $sql = "UPDATE `user` SET login ='{$method['flogin']}', name ='{$method['fname']}', lastname ='{$method['flastname']}', birthdate ='{$method['fbirthdate']}', email ='{$method['femail']}' WHERE iduser = {$method['id']}";
            // db($sql);
            

            $resSql = $pdo->prepare("UPDATE `user` SET login = :login, name = :fname, lastname = :flastname, birthdate = :fbirthdate, email = :femail WHERE iduser = :id");
            $resSql->bindValue("login", $method['flogin']);
            $resSql->bindValue("fname", $method['fname']);
            $resSql->bindValue("flastname", $method['flastname']);
            $resSql->bindValue("fbirthdate", $method['fbirthdate']);
            $resSql->bindValue("femail", $method['femail']);
            $resSql->bindValue("id", $method['id']);
            $resSql->execute();

            echo json_encode(['success' => true]);
        } else echo json_encode(['success' => false]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;

    case 'delete':
        if (isset($method['id'])) {
           $resSql = $pdo->prepare("DELETE FROM user WHERE iduser = ?");
            $resSql->execute([$method['id']]);
            echo json_encode(['success' => true]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        } else echo json_encode(['success' => false]);
        break;

    default:

        break;
}
