<?php
require_once('../utils/db_connect.php');
require_once('../utils/function.php');
// Upload file

if (isset($_FILES['file']['name'])) {

    // Nom du fichier
    $filename = $_FILES['file']['name'];

    // Destination
    $location = '../assets/' . $filename;
    $filepath = pathinfo($location, PATHINFO_EXTENSION);
    $filepath = strtolower($filepath);




    // Extensions
    $valid_extensions = ['jpg', 'jpeg', 'png'];

    //  Vérification extension du fichier
    if (in_array($filepath, $valid_extensions)) {

        //  Vérification de l'upload
        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
            $sql = "UPDATE product SET image = '{$location}' WHERE id_product = {$_POST['id']}";
            db($sql);

            // success

        }  // else false
    } // else false
}
