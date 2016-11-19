<?php

namespace app\model;

use app\utils\ConnectionFactory as connection;

class Commentaire extends AbstractModel{

  private $id_commentaire;
  public $commentaire;
  public $id_participant;
  public $id_evenement;
  public $date_depot;

  function __construct(){
    $this->db = connection::makeConnection();
  }

  protected function update(){
    $requete = "UPDATE commentaire SET
      id_commentaire = :id_commentaire,
      commentaire = :commentaire,
      id_participant = :id_participant,
      id_evenement = :id_evenement,
      date_depot = :date_depot
      WHERE id_commentaire = $this->id_commentaire";

    $requete_prep = $this->db->prepare($requete);
    $requete_prep->bindParam(':id_commentaire', $this->id_commentaire, \PDO::PARAM_INT);
    $requete_prep->bindParam(':commentaire', $this->commentaire, \PDO::PARAM_STR);
    $requete_prep->bindParam(':id_participant', $this->id_participant, \PDO::PARAM_INT);
    $requete_prep->bindParam(':id_evenement', $this->id_evenement, \PDO::PARAM_INT);
    $requete_prep->bindParam(':date_depot', $this->date_depot, \PDO::PARAM_STR, 30);

    $res = $requete_prep->execute();

    return $res;
  }

  protected function insert(){
    $requete = "INSERT INTO commentaire VALUES ('', :id_commentaire, :commentaire, :id_participant, :id_evenement, :date_depot)";
    $requete_prep = $this->db->prepare($requete);
    $requete_prep->bindParam(':id_commentaire', $this->id_commentaire, \PDO::PARAM_INT);
    $requete_prep->bindParam(':commentaire', $this->commentaire, \PDO::PARAM_STR);
    $requete_prep->bindParam(':id_participant', $this->id_participant, \PDO::PARAM_INT);
    $requete_prep->bindParam(':id_evenement', $this->id_evenement, \PDO::PARAM_INT);
    $requete_prep->bindParam(':date_depot', $this->date_depot, \PDO::PARAM_STR, 30);

    if($requete_prep->execute()){
      $id_commentaire = $this->db->LastInsertId();
      $this->id_commentaire = $id_commentaire;
      if(isset($id_commentaire)){
        return $id_commentaire;
      }else{
        return -1;
      }
    }
  }

  public function save(){
    if(isset($this->id_commentaire)){
      $res = $this->update();
    }else{
      $id_commentaire = $this->insert();
      $res = isset($id_commentaire);
    }
    return $res;
  }


  public function delete(){
    if(!isset($this->id_commentaire)){
      echo'erreur delete';
      return 0;
    }else{
      $requete = "DELETE FROM commentaire WHERE id_commentaire = :id";
      $requete_prep = $this->db->prepare($requete);
      $requete_prep->bindParam(':id', $this->id_commentaire, \PDO::PARAM_INT);
      $nb_lignes = $requete_prep->execute();
      var_dump(nb_lignes);
      return nb_lignes; // nombre de lignes que la requete va supprimer
    }
  }

  public function getCommentaire(){
    $requete = "SELECT nom from commentaire WHERE id_commentaire = :id";
    $requete_prep = $this->db->prepare($requete);
    $requete_prep->bindParam(':id', $this->id_commentaire, \PDO::PARAM_INT);
    if($requete_prep->execute()){
      $ligne = $requete_prep->fetch(\PDO::FETCH_OBJ);
      $ligne = $ligne->commentaire;
    }
    $commentaire = Commentaire::findById($ligne);
    return $commentaire;
  }

  static public function findById($id_commentaire){
    $db = connection::makeConnection();
    $requete = "SELECT * FROM commentaire WHERE id_commentaire=:id";
    $requete_prep = $db->prepare($requete);
    $requete_prep->bindParam(':id', $id_organisateur, \PDO::PARAM_INT);
    if ($requete_prep->execute()){
      $ligne = $requete_prep->fetch(\PDO::FETCH_OBJ);
      $commentaire = new Commentaire();
      $commentaire->id_commentaire = $ligne->id_commentaire;
      $commentaire->commentaire = $ligne->commentaire;
      $commentaire->id_participant = $ligne->id_participant;
      $commentaire->id_evenement = $ligne->id_evenement;
      $commentaire->date_depot = $ligne->date_depot;
      return $commentaire;
    }else{
      echo "erreur findById";
      return false;
    }
  }

  static public function findAll(){
    $db = connection::makeConnection();
    $requete = "SELECT * FROM commentaire";
    $resultat = $db->query($requete);
    if($resultat){
      while ($ligne = $resultat->fetch(\PDO::FETCH_OBJ)){
        $commentaire = new Commentaire();
        $commentaire->id_commentaire = $ligne->id_commentaire;
        $commentaire->commentaire = $ligne->commentaire;
        $commentaire->id_participant = $ligne->id_participant;
        $commentaire->id_evenement = $ligne->id_evenement;
        $commentaire->date_depot = $ligne->date_depot;
        $tab[] = $commentaire;
      }
    }else{
      echo "erreur findAll";
    }
    return $tab;
  }

}
