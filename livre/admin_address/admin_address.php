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
        $resSql = $pdo->query("SELECT `id_order`, `date_order`, `price_order`, `name`, `lastname`, `street_number`, `street_name`,`zip_code`, `city`, `country` FROM `order` INNER JOIN user ON user_iduser = iduser INNER JOIN address ON address_id_address = id_address");

        while($address = $resSql->fetch(PDO::FETCH_ASSOC)) $addresses[] = $address;

        $sql = db("SELECT * FROM `order` INNER JOIN order_has_product ON id_order = order_id_order INNER JOIN product ON product_id_product = id_product");
        $orders = resultAsArray($sql);

        $resSql = $pdo->query("SELECT * FROM `order` INNER JOIN order_has_product ON id_order = order_id_order INNER JOIN product ON product_id_product = id_product");

        while($order = $resSql->fetch(PDO::FETCH_ASSOC)) $orders[] = $order;

        echo json_encode(['success' => true, 'address' => $addresses, 'orders' => $orders]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;
}
