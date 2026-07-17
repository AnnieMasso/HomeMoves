<?php

// require
require_once('../../configuration/Database.php');
require_once('../../models/Vehicule.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $database = new Database();
    $db = $database->Connexion();

    $vehicule = new Vehicule($db);
    
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->type_vehicule) && !empty($data->capacite)) {
        $vehicule->type_vehicule = htmlspecialchars($data->type_vehicule);
        $vehicule->capacite = htmlspecialchars($data->capacite);

        $vehicule_store = $vehicule->storeVehicule();
        if ($vehicule_store) {
            echo json_encode(['Message' => "vehicule store avec succès"]);
        }else{
        echo json_encode(['Message' => "error"]);
        }

    }else{
        echo json_encode(['Message' => "veuillez remplir tous les champs"]);
    }

}else{
    echo json_encode(['Message' => "methode non permise"]);
}