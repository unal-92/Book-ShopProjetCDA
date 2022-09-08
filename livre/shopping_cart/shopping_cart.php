<?php

$sql_order = "INSERT INTO order (date_order, price_order, user_iduser, adress_id_adress= VALUES ('{$_POST['date']}', {$_POST['price']}, {$_SESSION['iduser']}, {$_POST['idaddr']})";
$db->query($sql_order);
$idorder = $db->insert_id;

foreach ($_POST['products'] as $idproduct) {
    $sql = "INSERT INTO order_has_product VALUES({$idorder}, {$idproduct})";

    $db->query($sql);
   
    //  $sql = "INSERT INTO order_has_product VALUES({$idorder}, {$idproduct}, {$number_item})";

   
    
}

