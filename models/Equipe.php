<?php

// gestion de la table équipe

class Equipe{

    private string $table = "equipe";
    private ?object $connection = null;

    public int $id;
    public string $libelle;
    public string $description;

    public function __construct(object $db){

        if ($this->connection === null) {
            $this->connection = $db;
        }

    }

    // fonction pour avoir toutes équipes
    public function getTeam(){

        $get_team = $this->connection->prepare("SELECT libelle, description FROM $this->table");
        $get_team->execute();
        return $get_team;

    }

    // fonction pour vérifier si l'id existe
    public function verifyId(){
        $verify_id = $this->connection->prepare("SELECT libelle FROM $this->table WHERE id = ? ");
        $verify_id->execute([$this->id]);
        return $verify_id->rowCount();
    }

    // fonction pour store une équipe

    public function storeTeam(){
        $store_team = $this->connection->prepare("INSERT INTO $this->table (libelle, description) VALUE(:libelle, :description)");
        $store_team->execute([
            ":libelle" => $this->libelle,
            ":description" => $this->description
        ]);

        if ($store_team) {
            return true;
        }else{
            return false;
        }
    }

    // fonction pour update la team 
    public function updateTeam(){
        $update_team = $this->connection->prepare("UPDATE $this->table SET libelle = ?, description = ? WHERE id = ?");
        $update_team->execute([
            $this->libelle,
            $this->description,
            $this->id
        ]);

        if ($update_team) {
            return true;
        }else{
            return false;
        }

    }

    // fonction pour delete la team
    public function deleteTeam(){
        $delete_team = $this->connection->prepare("DELETE FROM $this->table WHERE id = ?");
        $delete_team->execute([$this->id]);

        if ($delete_team) {
            return true;
        }else{
            return false;
        }
    }

}