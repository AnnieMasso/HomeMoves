<?php

// entetes

header("Access-Control-Allow-Origin: localhost");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once '../../configuration/Database.php';
require_once '../../models/utilisateur.php';

$database = new Database();
$db = $database->Connexion();

$utilisateur = new Utilisateur($db);
$getUser = $utilisateur->getUser();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($getUser->rowCount() > 0) {
        $data = [];
        $data[] = $getUser->fetchAll();

        echo json_encode($data);
        var_dump($data);
    }
    else{
        echo json_encode(["message" => "Aucun utilisateur a été trouvé"]);
    }
}
else{
    echo json_encode(["message"=>"Méthode non permise"]);
}