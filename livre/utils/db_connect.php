<?php
$servername = "mysql:host=localhost;charset=utf8;dbname=book_shop";
$username = "root";
$password = "";


// Create connection
$pdo = new pdo($servername, $username, $password,[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);


function db(string $request, array $params = array()) {
    global $pdo;
    //! Creation du steatement (preparation de la requete)
    $statement = $pdo->prepare($request);

    //! Si modification en bdd on prepare le bind
    //! En même temps je nettoie le value.
    if(!empty($params)) {
        foreach($params as $key => $value) {
            $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
        }
    }
    //! J'execute la requête
    $statement->execute();
    
    return $statement;
}

function selectAll($bdd,$tab,$condition){
    $sql = "SELECT * FROM $tab $condition";
    $req = $bdd->prepare($sql);
    $req->execute();
    $entite = $req->fetchAll(PDO::FETCH_ASSOC);
    return $entite;
}

// $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); // dbConnectTOTO

 //Check connection
//  if ($db->connect_error) {
//      die("Connection failed: " . $db->connect_error);
//  }
// echo "Connected successfully";


//Deuxieme bloc
// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully";
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }
