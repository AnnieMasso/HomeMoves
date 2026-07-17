<?php

// entetes

header("Access-Control-Allow-Origin: localhost");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once '../../configuration/Database.php';
require_once '../../models/Demenagement.php';

$database = new Database();
$db = $database->Connexion();

if ($db === null) {
    die('connexion null');
}

$move = new Demenagement($db);
$getMoves = $move->getMoves();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($getMoves->rowCount() > 0) {
        $data = [];
        $data[] = $getMoves->fetchAll();

        echo json_encode($data);
        var_dump($data);
    }
    else{
        echo json_encode(["message" => "Aucun move a été trouvé"]);
    }
}
else{
    echo json_encode(["message"=>"Méthode non permise"]);
}