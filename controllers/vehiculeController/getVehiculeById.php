<?php
require_once('../../models/Vehicule.php');
require_once('../../configuration/Database.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $database = new Database();
    $db = $database->Connexion();

    $vehicule = new Vehicule($db);
    $data = json_decode(file_get_contents('php://input'));
    $vehicule->id = $data->id;
    $vehicule_specifique = $vehicule->verifyId();

    if (!empty($data->id)) {

        // $getVehiculeById = $vehicule->verifyId();
        if ($vehicule_specifique->rowCount() > 0) {
            $data = [];
            $data [] = $vehicule_specifique->fetchAll();

            echo json_encode($data);
        }else{
            echo json_encode(['message', 'cet id n existe pas']);
        }
    }else{
        echo json_encode(['message','l identifiant est vide, veuillez le renseigner']);
    }
}else{
    echo json_encode(['message', 'methode non authorisée']);
}