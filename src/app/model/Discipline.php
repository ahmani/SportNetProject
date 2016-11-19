<?php

namespace app\model;

use app\utils\ConnectionFactory as connection;

class Discipline extends AbstractModel{
  public $id;
  public $nom;
  public $description;

  function __construct(){
    $this->db = connection::makeConnection();
  }

  protected function update(){
    $requete = "UPDATE discipline SET
    nom = :nom,
    description = :description
    WHERE id = $this->id";
    $requete_prep = $this->db->prepare($requete);
    $requete_prep->bindParam(':nom', $this->nom, \PDO::PARAM_STR, 100);
    $requete_prep->bindParam(':description', $this->description, \PDO::PARAM_STR, 1000);
    $res = $requete_prep->execute();
    return $res;
  }

    protected function insert(){
      $requete = "INSERT INTO discipline(nom, description) VALUES (:nom, :description)";
      $requete_prep = $this->db->prepare($requete);
      $requete_prep->bindParam(':nom', $this->nom, \PDO::PARAM_STR, 100);
      $requete_prep->bindParam(':description', $this->description, \PDO::PARAM_STR, 1000);
      if($requete_prep->execute()){
        $id = $this->db->LastInsertId();
        $this->id = $id;
        if(isset($id)){
          return $id;
        }else{
          return -1;
        }
      }
    }

    public function save(){
      if(isset($this->id)){
        $res = $this->update();
      }else{
        $id = $this->insert();
        $res = isset($id);
      }
      return $res;
  }

    public function delete(){
      if(!isset($this->id)){
        echo'erreur delete';
        return 0;
      }else{
        $requete = "DELETE FROM discipline WHERE ID = :id";
        $requete_prep = $this->db->prepare($requete);
        $requete_prep = bindParam(':id', $this->id, \PDO::PARAM_INT);
        $nb_lignes = $requete_prep->execute();
        return $nb_lignes;
      }
    }

    static public function findById($id){
      $db = connection::makeConnection();
      $requete = "SELECT * FROM discipline WHERE id=:id";
      $requete_prep = $db->prepare($requete);
      $requete_prep->bindParam(':id', $id, \PDO::PARAM_INT);
      if ($requete_prep->execute()){
        $ligne = $requete_prep->fetch(\PDO::FETCH_OBJ);
        $disc = new Discipline();
        $disc->id = $ligne->id;
        $disc->nom = $ligne->nom;
        $disc->description = $ligne->description;
        return $disc;
      }else{
        echo "erreur findById";
        return false;
      }
    }

    static public function findAll(){
      $db = connection::makeConnection();
      $requete = "SELECT * FROM discipline";
      $resultat = $db->query($requete);
      if($resultat){
        while ($ligne = $resultat->fetch(\PDO::FETCH_OBJ)){
          $disc = new Discipline();
          $disc->id = $ligne->id;
          $disc->nom = $ligne->nom;
          $disc->description = $ligne->description;
          $tab[] = $disc;
        }
      }else{
        echo "erreur findAll";
      }
      return $tab;
    }

  }
