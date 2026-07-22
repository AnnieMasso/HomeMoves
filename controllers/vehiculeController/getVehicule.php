<?php

// require
require_once('../../configuration/Database.php');
require_once('../../models/Vehicule.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $database = new Database();
    $db = $database->Connexion();

    $Vehicule = new Vehicule($db);
    $vehicules = $Vehicule->getVehicule();
    if ($vehicules->rowCount() > 0) {
        $data = [];
        $data [] = $vehicules->fetchAll();

        echo json_encode($data);
    }else{
        echo json_encode(['Message' => "Aucun véhicule n'a encore été enregistré"]);
    }
}else{
    echo json_encode(["Message"=> "Méthode non authorisée"]);
}