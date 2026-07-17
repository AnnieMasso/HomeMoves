<?php

require_once('../../configuration/Database.php');
require_once('../../models/Demenagement.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->Connexion();

    $move = new Demenagement($db);

    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->lieu_local) && !empty($data->type_local)&& !empty($data->destination)&& !empty($data->id_user)) {

        try {
            $move->lieu_local = htmlspecialchars($data->lieu_local);
            $move->id_user = htmlspecialchars($data->id_user);
            $move->type_local = htmlspecialchars($data->type_local);
            $move->destination = htmlspecialchars($data->destination);


            $result = $move->storeMoves();

            if ($result) {
                echo json_encode(["Message" => "move crée avec succès"]);
            }
            else{
                echo json_encode(['Message' => "Erreur lors de l'ajout du move"]);
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo 'ok';
            echo $th->getLine();
            echo 'ok';
            echo $th->getCode();
        }
        
    }
    else{
        echo json_encode(["message" => "les données ne sont pas complètes"]);
    }
    
}
else{
    echo json_encode(["Message"=>"Méthode non authorisée"]);
}