<?php

// require
require_once('../../configuration/Database.php');
require_once('../../models/Paiement.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $database = new Database();
    $db = $database->Connexion();

    $paiement = new Paiement($db);
    

    $données = json_decode(file_get_contents("php://input"));
    $paiement->id = $données->id;
    $paiements = $paiement->getPaymentById();
    if ($paiements->rowCount() > 0) {
        $data = [];
        $data [] = $paiements->fetchAll();

        echo json_encode($data);
    }else{
        echo json_encode(['Message' => "cet id n'existe pas"]);
    }
}else{
    echo json_encode(["Message"=> "Méthode non authorisée"]);
}