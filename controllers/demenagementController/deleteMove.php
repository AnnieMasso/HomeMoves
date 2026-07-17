<?php

require_once('../../configuration/Database.php');
require_once('../../models/Demenagement.php');

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {

    try {
        //code...

    
    $database = new Database();
    $db = $database->Connexion();

    $move = new Demenagement($db);

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->id)) {
        $move->id = $data->id;
        $move_deleted = $move->deleteMove();

        if ($move_deleted) {
            echo json_encode(["message" =>"move supprimé avec succès"]);
        }else{
            echo json_encode(["message" =>"echec lors de la suppression du move"]);
        }
    }else{
        echo json_encode(["message" =>"veuillez indiquer un id"]);
    }

        } catch (\Throwable $th) {
        echo $th->getMessage(). ' à la ligne '. $th->getLine();
    }

}else{
    echo json_encode(["message" =>"méthode non permise"]);
}