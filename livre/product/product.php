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
        $resSql = $pdo->query("SELECT p.*, c.label FROM product p INNER JOIN category c ON p.category_id_category = c.id_category");

        while($product = $resSql->fetch(PDO::FETCH_ASSOC)) $products[] = $product;

        echo json_encode(["success" => true, "products" => $products]);
        break;


    case 'select_id':
        if (isset($method['id'])) {
            $resSql = $pdo->prepare("SELECT * FROM product WHERE id_product = ?");
            $resSql->execute([$method['id']]);
            $product = $resSql->fetch(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'product' => $product]);
        } else echo json_encode(['success' => false]); //! else send success false
        break;

    case 'insert':
        if (isset($method['ftitle'], $method['fauthor'], $method['fage'], $method['fdesc'], $method['fprice'], $method['fcateIdcate'])) {

            $ftitle = $method['ftitle'];
            $fauthor = $method['fauthor'];
            $fage = $method['fage'];
            $desc = $method['fdesc'];
            $fprice = $method['fprice'];
            $fcateIdcate = $method['fcateIdcate'];

            $resSql = $pdo->prepare("INSERT INTO product (name_product, author, min_age, description, price, category_id_category) VALUES (?, ?, ?, ?, ?, ?)");
            $resSql->execute([$ftitle, $fauthor, $fage, $desc, $fprice, $fcateIdcate]);

            echo json_encode(['success' => true, 'id_product' => $pdo->lastInsertId()]);
        } else echo json_encode(['success' => false]);
        break;



    case 'update':
        if (isset($method['ftitle'], $method['fauthor'], $method['fage'], $method['fdesc'], $method['fprice'], $method['fcateIdcate'], $method['id'])) {

            $ftitle = $method['ftitle'];
            $fauthor = $method['fauthor'];
            $fage = $method['fage'];
            $desc = $method['fdesc'];
            $fprice = $method['fprice'];
            $fcateIdcate = $method['fcateIdcate'];



            $sql = "UPDATE product SET name_product = '{$ftitle}', author = '{$fauthor}', min_age = '{$fage}', description = '{$desc}', price = '{$fprice}', category_id_category = '{$fcateIdcate}' WHERE id_product ={$method['id']}";
            $id = db($sql);

            $resSql = $pdo->prepare("UPDATE product SET name_product = :name, author = :author, min_age = :min_age, description = :desc, price = :price, category_id_category = :cat_id WHERE id_product = :id");
            $resSql->bindValue("name", $method['ftitle']);
            $resSql->bindValue("author", $method['fauthor']);
            $resSql->bindValue("min_age", $method['fage']);
            $resSql->bindValue("desc", $method['fdesc']);
            $resSql->bindValue("price", $method['fprice']);
            $resSql->bindValue("cat_id", $method['fcateIdcate']);
            $resSql->bindValue("id", $method['id']);
            $resSql->execute();

            echo json_encode(['success' => true]);
        } else echo json_encode(['success' => false]);
        break;


    case 'delete':
        if (isset($method['id'])) {
            $resSql = $pdo->prepare("DELETE FROM product WHERE id_product = ?");
            $resSql->execute([$method['id']]);
            echo json_encode(['success' => true]);
        } else echo json_encode(['success' => false]);
        break;

    default:

        break;
}
