<?php

// gestion de la table équipe

class Commentaire{

    private string $table = "commentaire";
    private ?object $connection = null;

    public int $id;
    public string $date;
    public string $message;
    public string $id_user;

    public function __construct(object $db){

        if ($this->connection === null) {
            $this->connection = $db;
        }

    }

    // fonction pour avoir toutes équipes
    public function getComment(){

        $get_commentaire = $this->connection->prepare("SELECT id_user, message, date FROM $this->table");
        $get_commentaire->execute();
        return $get_commentaire;

    }

    // fonction pour vérifier si l'id existe
    public function verifyId(){
        $verify_id = $this->connection->prepare("SELECT date FROM $this->table WHERE id = ? ");
        $verify_id->execute([$this->id]);
        return $verify_id->rowCount();
    }

    // fonction pour store une équipe

    public function storeComment(){
        $store_commentaire = $this->connection->prepare("INSERT INTO $this->table (date, message, id_user) VALUE(:date, :message, :id_user)");
        $store_commentaire->execute([
            ":date" => $this->date,
            ":message" => $this->message,
            ":id_user" => $this->id_user,
        ]);

        if ($store_commentaire) {
            return true;
        }else{
            return false;
        }
    }

    // fonction pour update la commentaire 
    // public function updatecommentaire(){
    //     $update_commentaire = $this->connection->prepare("UPDATE $this->table SET date = ? WHERE id = ?");
    //     $update_commentaire->execute([
    //         $this->date,
    //         $this->id
    //     ]);

    //     if ($update_commentaire) {
    //         return true;
    //     }else{
    //         return false;
    //     }

    // }

    // fonction pour delete la commentaire
    public function deleteComment(){
        $delete_commentaire = $this->connection->prepare("DELETE FROM $this->table WHERE id = ?");
        $delete_commentaire->execute([$this->id]);

        if ($delete_commentaire) {
            return true;
        }else{
            return false;
        }
    }

}