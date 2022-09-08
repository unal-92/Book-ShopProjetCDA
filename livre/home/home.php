<?php
session_start();
require_once('../utils/db_connect.php');
require_once('../utils/function.php');

//? $method = $_POST or $_GET
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $method = $_POST;
} else {
    $method = $_GET;
}

// $needle ='{"success":true,"products":[{"id_product":"85","name_product":"a","author":"a","min_age":"6","image":"..\/assets\/one piece tom 1.jpg","description":"z","price":"5","category_id_category":"14","id_category":"14","label":"One Piece"},{"id_product":"91","name_product":"ihug","author":"Zerty","min_age":"0","image":"..\/assets\/dragon ball tom 1.jpg","description":"azertyuiop","price":"5","category_id_category":"13","id_category":"13","label":"Dragon Ball"},{"id_product":"92","name_product":"oui","author":"ouooui","min_age":"7","image":"il est bien","description":"test","price":"7","category_id_category":"14","id_category":"14","label":"One Piece"}],"connexion":false}';
switch ($method['choice']) {
    case 'select_all':
        $is_connected = false; //! déclaration de variable
        if (isset($_SESSION['user'])) {
            $is_connected = true; //! si l'user a une session il est co
        }

        // $resSql = db("SELECT p.*, c.label FROM product p INNER JOIN category c ON p.category_id_category = c.id_category");
        $products = selectAll($pdo,"product p", "INNER JOIN category c ON p.category_id_category = c.id_category");
        $productsJSON = json_encode(['success' => true, 'products' => $products, 'connexion' => $is_connected]);
        echo $productsJSON;
        break;
        //default:

    case 'check_user':
        if (isset($_SESSION['user'])) {

            $myId = $_SESSION['user']['id'];
            $res = db("SELECT is_admin FROM user WHERE iduser = $myId");
            $resRole = resultAsArray($res);
            var_dump($resRole);
            die();
            echo json_encode(['success' => true, 'role' => $resRole]);
        } else {
            echo json_encode(['success' => false]);
        }
        
        break;
}
