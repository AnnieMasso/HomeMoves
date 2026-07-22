<?php

require_once('../../configuration/Database.php');
require_once('../../models/Vehicule.php');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $database = new Database();
    $db = $database->Connexion();

    $vehicule = new Vehicule($db);

    $data = json_decode(file_get_contents('php://input'));
    if (!empty($data->id) && !empty($data->type_vehicule) && !empty($data->capacite)) {
        $vehicule->id = $data->id;
        $vehicule->type_vehicule = htmlspecialchars($data->type_vehicule);
        $vehicule->capacite = htmlspecialchars($data->capacite);
        $verify_id = $vehicule->verifyId()->rowCount();

        if ($verify_id > 0) {

            $vehicule_updated = $vehicule->updateVehicule();
            if ($vehicule_updated) {
                echo json_encode(['Message' => "vehicule updated avec succès"]);
            }else{
                echo json_encode(['Message' => "error"]);
            }
        }else{
            echo json_encode(['Message' => "l'id n'existe pas"]);
        }
    }else{
        echo json_encode(['Message' => "données incomplètes"]);
    }
}else{
    echo json_encode(['Message' => "méthode non authorisée"]);
}