<?php

// gestion de la table équipe

class Paiement{

    private string $table = "paiement";
    private ?object $connection = null;

    public int $id;
    public string $date_paiement;
    public int $montant_paiement;
    public string $mode_paiement;
    public int $id_demenagement;

    public function __construct(object $db){

        if ($this->connection === null) {
            $this->connection = $db;
        }

    }

    // fonction pour avoir tous les paiements
    public function getPayment(){

        $get_payment = $this->connection->prepare("SELECT * FROM $this->table");
        $get_payment->execute();
        return $get_payment;

    }

    // fonction pour vérifier si l'id existe
    // public function verifyId(){
    //     $verify_id = $this->connection->prepare("SELECT * FROM $this->table WHERE id = ? ");
    //     $verify_id->execute([$this->id]);
    //     return $verify_id->rowCount();
    // }

    // fonction pour store une équipe

    public function storePayment(){
        $store_payment = $this->connection->prepare("INSERT INTO $this->table (date_paiement, montant_paiement, mode_paiement, id_demenagement) VALUE(:date_paiement, :montant_paiement, :mode_paiement, :id_demenagement)");
        $store_payment->execute([
            ":date_paiement" => $this->date_paiement,
            ":montant_paiement" => $this->montant_paiement,
            ":mode_paiement" => $this->mode_paiement,
            ":id_demenagement" => $this->id_demenagement,
        ]);

        if ($store_payment) {
            return true;
        }else{
            return false;
        }
    }

    // fonction pour update la payment 
    // public function updatepayment(){
    //     $update_payment = $this->connection->prepare("UPDATE $this->table SET date_paiement = ? WHERE id = ?");
    //     $update_payment->execute([
    //         $this->date_paiement,
    //         $this->id
    //     ]);

    //     if ($update_payment) {
    //         return true;
    //     }else{
    //         return false;
    //     }

    // }

    // fonction pour delete la payment
    public function getPaymentById(){

        $get_payment_by_id = $this->connection->prepare("SELECT * FROM $this->table WHERE id = ?");
        $get_payment_by_id->execute([$this->id]);
        return $get_payment_by_id;

    }

}