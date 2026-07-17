<?php

require_once('../../models/Vehicule.php');
require_once('../../configuration/Database.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $database = new Database();
    $db = $database->Connexion();

    $vehicule= new Vehicule($db);

    $data = json_decode(file_get_contents('php://input'));

    if (!empty($data->id)) {
        $vehicule->id = $data->id;

        $verify_id = $vehicule->verifyId();
        if ($verify_id > 0) {
            $vehicule_deleted = $vehicule->deleteVehicule();
            if ($vehicule_deleted) {
                echo json_encode(['Message' => "vehicule  deleted avec succès"]);
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
    echo json_encode(['Message' => "methode non authorisée"]);
}