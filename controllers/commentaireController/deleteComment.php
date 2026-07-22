<?php

require_once('../../configuration/Database.php');
require_once('../../models/Commentaire.php');

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {

    try {
        //code...

    
    $database = new Database();
    $db = $database->Connexion();

    $comment = new Commentaire($db);

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->id)) {
        $comment->id = $data->id;
        $comment_deleted = $comment->deleteComment();

        if ($comment_deleted) {
            echo json_encode(["message" =>"comment supprimé avec succès"]);
        }else{
            echo json_encode(["message" =>"echec lors de la suppression du comment"]);
        }
    }else{
        echo json_encode(["message" =>"veuillez indiquer un id"]);
    }

        } catch (\Throwable $th) {
        echo $th->getLine(). ' et '. $th->getMessage();
    }

}else{
    echo json_encode(["message" =>"méthode non permise"]);
}