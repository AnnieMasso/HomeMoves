<?php
// fichier de connexion à la base de données 

class Database{
    private string $hote = 'localhost';
    private string $dbname = "bdhomemovers";
    private string $username = "Carelle";
    private string $password = "anniemasso@";
    
    public function Connexion(){
        $connection = null;

        try {
            $connection = new PDO("mysql:host=$this->hote;dbname=$this->dbname", $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
        

    }
}