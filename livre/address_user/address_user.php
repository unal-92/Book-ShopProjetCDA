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
$myid = $_SESSION['user']['id'];

switch ($method['choice']) {
    case 'insert':
        if (isset($method['street_number'], $method['street_name'], $method['zip_code'], $method['country'], $method['city'])) {
           $resSql = $pdo->prepare("INSERT INTO address (street_number, street_name, zip_code, country, city) VALUES (?, ?, ?, ?, ?)");
            $resSql->execute([$method['street_number'], $method['street_name'], $method['zip_code'], $method['country'], $method['city']]);
            $address_id = $pdo->lastInsertId(); //? insert a new address

            $resSql = $pdo->prepare("INSERT INTO `order`(price_order, user_iduser, address_id_address) VALUES (?, ?, ?)");
            $resSql->execute([$method['price'], $myid, $address_id]);
            $order_id = $pdo->lastInsertId(); //? insert a new order

            $products = $method['products'];
            foreach ($products as &$value) { //! id du produit
               $resSql = $pdo->prepare("INSERT INTO `order_has_product`(`order_id_order`, `product_id_product`) VALUES (?, ?)");
               $resSql->execute([$order_id, $value]);
            }

            echo json_encode(['success' => true, 'id_address' => $address_id, 'order_id' => $order_id]);
        } else echo json_encode(['success' => false]);
        break;
}
