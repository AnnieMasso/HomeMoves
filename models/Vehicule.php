<?php

// gestion des données de la table véhicule

class Vehicule{

    private $table = "vehicule";
    private ?object $connection = null;

    public int $id;
    public string $type_vehicule;
    public int $capacite;

    public function __construct(object $db)
    {
        if ($this->connection === null) {
            $this->connection = $db;
        }
    }

    // fonction pour obtenir tous les véhicules
    public function getVehicule(){

        $get_vehicule = $this->connection->prepare("SELECT type_vehicule, capacite FROM $this->table");
        $get_vehicule->execute();
        return $get_vehicule;

    }

    // fonction pour vérifier si l'id exixte
    public function verifyId(){
        $verify_id = $this->connection->prepare("SELECT type_vehicule FROM $this->table WHERE id = ? ");
        $verify_id->execute([$this->id]);
        return $verify_id->rowCount();
    }

    // fonction pour store le getVehicule
        public function storeVehicule(){
        $store_vehicule = $this->connection->prepare("INSERT INTO $this->table (type_vehicule, capacite) VALUE(:type_vehicule, :capacite)");
        $store_vehicule->execute([
            ":type_vehicule" => $this->type_vehicule,
            ":capacite" => $this->capacite
        ]);

        if ($store_vehicule) {
            return true;
        }else{
            return false;
        }
    }

    // fonction pour update le vehicule
    public function updateVehicule(){
        $update_vehicule = $this->connection->prepare("UPDATE $this->table SET type_vehicule = ?, capacite = ? WHERE id = ?");
        $update_vehicule->execute([
            $this->type_vehicule,
            $this->capacite,
            $this->id
        ]);

        if ($update_vehicule) {
            return true;
        }else{
            return false;
        }

    }

    // fonction pour delete la vehicule
    public function deleteVehicule(){
        $delete_vehicule = $this->connection->prepare("DELETE FROM $this->table WHERE id = ?");
        $delete_vehicule->execute([$this->id]);

        if ($delete_vehicule) {
            return true;
        }else{
            return false;
        }
    }

}