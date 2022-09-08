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
        $resSql = $pdo->query("SELECT * FROM genre");

        while($genre = $resSql->fetch(PDO::FETCH_ASSOC)) $genres[] = $genre;
        
        echo json_encode(["success" => true, "genres" => $genres]); //!Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;

    case 'select_id':
        if (isset($method['id'])) {
            $resSql = $pdo->prepare("SELECT * FROM genre WHERE id_genre = ?");
            $resSql->execute([$method['id']]);
            $genre = $resSql->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'genre' => $genre]);
        } else echo json_encode(['success' => false]); //! else send success false
        break;

    case 'insert':
        if (isset($method['ftitle'])) {
            $resSql = $pdo->prepare("INSERT INTO genre (label) VALUES (?)");
            $resSql->execute([$method['ftitle']]);
            echo json_encode(['success' => true, 'id_genre' => $pdo->lastInsertId()]);
        } else echo json_encode(['success' => false]); //! Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;

    case 'update':
        if (isset($method['ftitle'], $method['id'])) {
            $resSql = $pdo->prepare("UPDATE genre SET label = :label WHERE id_genre = :id");
            $resSql->bindValue("label", $method['ftitle']);
            $resSql->bindValue("id", $method['id']);
            $resSql->execute();
            echo json_encode(['success' => true, 'label' => $method['ftitle']]);
        } else echo json_encode(['success' => false]); //!Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;




        
    case 'delete':
        if (isset($method['id'])) {
            $resSql = $pdo->prepare("DELETE FROM genre WHERE id_genre = ?");
            $resSql->execute([$method['id']]);
            echo json_encode(['success' => true]);
        } else echo json_encode(['success' => false]); //!Retourne une chaîne de caractères contenant la représentation JSON de la valeur value.
        break;

    default:

        break;
}
