<?php

namespace Models;
use PDO;

class Label extends DbConnect {
     
    /**
     * Primary key
     * @var string
     */
    private $nom;

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    public function selectAll() {

        // Variable contenant la requête SQL sous la forme d'une chaîne de caractères
        $query = "SELECT nom FROM labels;";

        // Je récupère un objet de type PDOStatement => requête préparée
        $result = $this->pdo->prepare($query);

        // Exécution de la requête préparée - $result recupère le jeu de résultat
        $result->execute();

        $datas = $result->fetchAll();

        return $datas;

    }

    public function select() {

        $query = "SELECT nom FROM labels WHERE nom = :nom;";
        $result = $this->pdo->prepare($query);
        
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        $result->execute();
        
        $datas = $result->fetch();

        if($datas) {
            $this->nom = $datas['nom'];
        }

        return $datas;
    }

    public function insert() {

        $query = "INSERT INTO labels (nom) VALUES(:nom);";
        $result = $this->pdo->prepare($query);

        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        if(!$result->execute()) {
            var_dump($result->errorInfo());
            return false;
        }
            
        return $this;

    }

    public function update() {

    }

    public function delete() {
        
        $query = "DELETE FROM labels WHERE nom = :nom;";
        $result = $this->pdo->prepare($query);

        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);
        
        $result->execute();
    }












}