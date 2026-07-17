<?php

// require
require_once('../../configuration/Database.php');
require_once('../../models/Paiement.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $database = new Database();
    $db = $database->Connexion();

    $paiement = new Paiement($db);
    
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->date_paiement) && !empty($data->montant_paiement) && !empty($data->mode_paiement) && !empty($data->id_demenagement)) {
        $paiement->date_paiement = $data->date_paiement;
        $paiement->montant_paiement = $data->montant_paiement;
        $paiement->mode_paiement = $data->mode_paiement;
        $paiement->id_demenagement = $data->id_demenagement;

        $paiement_store = $paiement->storePayment();
        if ($paiement_store) {
            echo json_encode(['Message' => "paiement store avec succès"]);
        }else{
        echo json_encode(['Message' => "error"]);
        }

    }else{
        echo json_encode(['Message' => "veuillez remplir tous les champs"]);
    }

}else{
    echo json_encode(['Message' => "methode non permise"]);
}