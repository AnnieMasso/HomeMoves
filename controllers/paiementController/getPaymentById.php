<?php

// require
require_once('../../configuration/Database.php');
require_once('../../models/Paiement.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $database = new Database();
    $db = $database->Connexion();

    $Paiement = new Paiement($db);
    

    $données = json_decode(file_get_contents("php://input"));
    $id_paiement = $données->id;
    $paiements = $Paiement->getPayment();
    if ($paiements->rowCount() > 0) {
        $data = [];
        $data [] = $paiements->fetchAll();

        echo json_encode($data);
    }else{
        echo json_encode(['Message' => "Aucune paiement n'a encore été enregistrée"]);
    }
}else{
    echo json_encode(["Messge"=> "Méthode non authorisée"]);
}