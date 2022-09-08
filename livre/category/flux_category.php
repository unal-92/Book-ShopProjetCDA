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
        $resSql = $pdo->query("SELECT c.*, GROUP_CONCAT(g.label) AS genre FROM category c LEFT JOIN category_has_genre chg ON chg.category_id_category = c.id_category LEFT JOIN genre g ON g.id_genre = chg.genre_id_genre GROUP BY c.id_category");  //! concataine les genres, sut une seule case 
        // $categorys = resultAsArray($resSql);

        while($category = $resSql->fetch(PDO::FETCH_ASSOC)) $categories[] = $category;

        echo json_encode(["success" => true, "categories" => $categories]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;

    case 'select_id':
        if (isset($method['id'])) {
            $resSql = $pdo->prepare("SELECT * FROM category WHERE id_category = ?");
            $resSql->execute([$method['id']]);
            $category = $resSql->fetch(PDO::FETCH_ASSOC);

            $resSql = $pdo->prepare("SELECT genre_id_genre FROM category_has_genre WHERE category_id_category = ?");
            $resSql->execute([$method['id']]);

            $genres = [];
            while($genre = $resSql->fetch(PDO::FETCH_ASSOC)) $genres[] = $genre;

            echo json_encode(['success' => true, 'category' => $category, 'gender' => $genres]);
        } else echo json_encode(['success' => false]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;

    case 'insert':
        if (isset($method['ftitle'])) {
            $resSql = $pdo->prepare("INSERT INTO category (label) VALUES (?)");
            $resSql->execute([$method['ftitle']]);
            $id_category = $pdo->lastInsertId();
            if (isset($method['genders']))
                foreach ($method['genders'] as $id) {
                    $resSql = $pdo->prepare("INSERT INTO category_has_genre VALUES (?, ?)");
                    $resSql->execute([$id_category, $id]);
                }

            echo json_encode(['success' => true, 'id_category' => $id_category]);
        } else echo json_encode(['success' => false]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;

    case 'update':
        if (isset($method['ftitle'], $method['id'])) {
            $resSql = $pdo->prepare("UPDATE category SET label = :label WHERE id_category = :id");
            $resSql->bindValue("label", $method['ftitle']);
            $resSql->bindValue("id", $method['id']);
            $resSql->execute();
            
            $resSql = $pdo->prepare("SELECT genre_id_genre FROM category_has_genre WHERE category_id_category = ?");
            $resSql->execute([$method['id']]);
            
            $genres = [];
            while($genre = $resSql->fetch(PDO::FETCH_ASSOC)) $genres[] = $genre;
            
            $result = array(); // Déclaration d'un tableau vide
            foreach ($genres as $row) {
                array_push($result, $row["genre_id_genre"]);  // Push de chaque résultat dans le tableau déclaré plus tôt

            }
            $old_genders = array_diff($result, $method['genders']); //! compare le tableau array avec un ou plusieurs tableaux et retourne les valeurs du tableau array1 qui ne sont pas présentes dans les autres tableaux.

            $new_genders = array_diff($method['genders'], $result); //! compare le tableau array avec un ou plusieurs tableaux et retourne les valeurs du tableau array1 qui ne sont pas présentes dans les autres tableaux.


            foreach ($old_genders as $id) {
                $resSql = $pdo->prepare("DELETE FROM category_has_genre WHERE category_id_category = ? AND genre_id_genre = ?");
                $resSql->execute([$method['id'], $id]);
            }

            foreach ($new_genders as $id) {
                $resSql = $pdo->prepare("INSERT INTO category_has_genre VALUES (?, ?)");
                $resSql->execute([$method['id'], $id]);
            }
            echo json_encode(['success' => true]);
        } else echo json_encode(['success' => false]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.

        break;
    case 'delete':
        if (isset($method['id'])) {
            $resSql = $pdo->prepare("DELETE FROM category_has_genre WHERE category_id_category = ?");
            $resSql->execute([$method['id']]);

            $resSql = $pdo->prepare("DELETE FROM category WHERE id_category = ?");
            $resSql->execute([$method['id']]);
            echo json_encode(['success' => true]);
        } else echo json_encode(['success' => false]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;

    default:

        break;
}
