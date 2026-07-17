<?php

// require
require_once('../../configuration/Database.php');
require_once('../../models/Equipe.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $database = new Database();
    $db = $database->Connexion();

    $Equipe = new Equipe($db);
    $teams = $Equipe->getTeam();
    if ($teams->rowCount() > 0) {
        $data = [];
        $data [] = $teams->fetchAll();

        echo json_encode($data);
    }else{
        echo json_encode(['Message' => "Aucune équipe n'a encore été enregistrée"]);
    }
}else{
    echo json_encode(["Messge"=> "Méthode non authorisée"]);
}