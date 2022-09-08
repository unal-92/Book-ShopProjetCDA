<?php
session_start();
require_once('./utils/db_connect.php');
require_once('./utils/fucntion.php');

// if (isset($_POST['action']) && $POST['action'] == 'delete' && isset($POST['iduser'])) { //* si je souhaite supprimer un utilisateur
//     $sql = $PDO->prepare (" DELETE FROM `user` WHERE iduser = {$POST['iduser']}");
//     $sql->execute([$sql]);
//     $resultat = $sql->fetch(PDO::FETCH_ASSOC);
//     // $db->query($sql);
// }

// $valid = true;
// $keys = ['name', 'firstname', 'birthdate', 'email'];
// if (count($_POST)) { //! si la superglobal $_POST contient des valeurs, j'itère sur les clés pour vérifier leur éxistance
//     foreach ($keys as $key) {
//         if (!isset($_POST[$key])) {

//             $valid = false; //! $valid passe à false si une des clés n'éxiste pas dans la superglobal $_POST
//         }
//     }
// } else $valid = false;  //! $valid passe à false si la superglobale $_POST contient aucune valeur

// if ($valid) { //* Si $valid est true j'update les valeurs de l'utilisateur sélectionné
//     $sql = "UPDATE `user` SET name= '{$_POST['name']}' lastname = '{$_POST['lastname']}', birthdate = '{$_POST['birthdate']}', email = '{$_POST['email']}' WHERE iduser = {['iduser']}";
//     $sql->execute([$valid]);
//     $resultat = $valid->fetch(PDO::FETCH_ASSOC);

//     // $db->query($sql);
// }

// if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['iduser'])) { //* si je veux update un user
//     $sql = "SELECT * FROM `user` WHERE iduser = {$_GET['iduser']}";
//     $res = $dn->query($sql);
//     $user = resultAsArray($res)[0]; //! je récupère le premier résultat de ma requête (il correspond au tableau de données de mon user)
// }

// $sql = " SELECT* FROM `user`"; //! je selectionne tout mes utilisateurs
// $res = $db->query($sql);

// $user = resultAsArray($res);


    
        if (isset($method['iduser'], $method['login'], $method['name'], $method['lastname'], $method['birthdate'], $method['email'], $method['password'])) {
            $resSql = $pdo->prepare("INSERT INTO user (iduser, login, name, lastname, birthdate, email, 'password') VALUES (?,?,?,?,?,?,?)");
            $resSql->execute([$method['iduser'], $method['login'], $method['name'], $method['lastname'], $method['birthdate'], $method['email'], $method['password']]);
            $user = $pdo->lastInsertId();
          
        }
    