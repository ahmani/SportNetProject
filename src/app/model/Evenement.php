<?php

namespace app\model;

use app\utils\ConnectionFactory as connection;
use app\utils\Authentification as Auth;
use app\model\Organisateur;
class Evenement extends AbstractModel{
  public $id_evenement;
  public $nom;
  public $description;
  public $lieu;
  public $date_debut;
  public $date_fin;
  public $etat;
  public $id_discipline;
  public $id_organisateur;

  function __construct(){
    $this->db = connection::makeConnection();
  }

  protected function update(){

    $requete = "UPDATE evenement
                SET nom = :nom,
                    description = :description,
                    lieu = :lieu,
                    date_debut = :date_d,
                    date_fin = :date_f,
                    etat = :etat,
                    id_discipline = :id_disc
              WHERE id_evenement = :id";
    $requete_prep = $this->db->prepare($requete);
    $requete_prep->bindParam(':nom', $this->nom, \PDO::PARAM_STR, 100);
    $requete_prep->bindParam(':description', $this->description, \PDO::PARAM_STR, 1000);
    $requete_prep->bindParam(':lieu', $this->lieu, \PDO::PARAM_STR, 1000);
    $requete_prep->bindParam(':date_d', $this->date_debut, \PDO::PARAM_STR);
    $requete_prep->bindParam(':date_f', $this->date_fin, \PDO::PARAM_STR);
    $requete_prep->bindParam(':etat', $this->etat, \PDO::PARAM_STR, 15);
    $requete_prep->bindParam('id_disc', $this->id_discipline, \PDO::PARAM_INT, 15);
    $requete_prep->bindParam(':id', $this->id_evenement, \PDO::PARAM_INT);

    if($requete_prep->execute()){
      if(isset($this->id_evenement)){
        return $this->id_evenement;
      }else{
        return -1;
      }
    }
  }

  protected function insert(){
    $requete = "INSERT INTO evenement (nom, description, lieu, date_debut, date_fin, etat, id_organisateur, id_discipline)
                VALUES (:nom, :description, :lieu, :date_d, :date_f, :etat, :id_org, :id_disc)";

    $requete_prep = $this->db->prepare($requete);

    $requete_prep->bindParam(':nom', $this->nom, \PDO::PARAM_STR, 100);
    $requete_prep->bindParam(':description', $this->description, \PDO::PARAM_STR, 1000);
    $requete_prep->bindParam(':lieu', $this->lieu, \PDO::PARAM_STR, 1000);
    $requete_prep->bindParam(':date_d', $this->date_debut, \PDO::PARAM_STR);
    $requete_prep->bindParam(':date_f', $this->date_fin, \PDO::PARAM_STR);
    $requete_prep->bindParam(':etat', $this->etat, \PDO::PARAM_STR, 15);
    $requete_prep->bindParam(':id_org', $this->id_organisateur, \PDO::PARAM_INT);
    $requete_prep->bindParam(':id_disc', $this->id_discipline, \PDO::PARAM_INT);

    if($requete_prep->execute()){
      $id = $this->db->LastInsertId();
      $this->id_evenement = $id;
      if(isset($id)){
        return $id;
      }else{
        return -1;
      }
    }
  }

  public function save(){
    if(isset($this->id_evenement)){
      $res = $this->update();
    }else{
      $id = $this->insert();
      $res = $id;
    }
    return $res;
}

  public function delete(){
    if(!isset($this->id_evenement)){
      echo'erreur delete';
      return 0;
    }else{
      $requete = "DELETE FROM evenement WHERE id_evenement = :id_evenement";
      $requete_prep = $this->db->prepare($requete);
      $requete_prep->bindParam(':id_evenement', $this->id_evenement, \PDO::PARAM_INT);
      $nb_lignes = $requete_prep->execute();
      return $nb_lignes;
    }
  }

  static public function findById($id){
    $db = connection::makeConnection();
    $requete = "SELECT * FROM evenement WHERE id_evenement=:id";
    $requete_prep = $db->prepare($requete);
    $requete_prep->bindParam(':id', $id, \PDO::PARAM_INT);

    if ($requete_prep->execute()){
      
      while($ligne = $requete_prep->fetch(\PDO::FETCH_OBJ))
      {
        $event = new evenement();
      $event->id_evenement = $ligne->id_evenement;
      $event->nom = $ligne->nom;
      $event->description = $ligne->description;
      $event->lieu = $ligne->lieu;
      $event->date_debut = $ligne->date_debut;
      $event->date_fin = $ligne->date_fin;
      $event->etat = $ligne->etat;
      $event->id_discipline = $ligne->id_discipline;
      $event->id_organisateur = $ligne->id_organisateur;
      }
      return $event;
      
    }else{
      echo "erreur findById";
      return false;
    }
  }

  static public function findByName($nom){
      $requete = "SELECT * FROM evenement WHERE nom=:nom";

      $db = Connection::makeConnection();
      $requete_prep = $db->prepare( $requete );
      $requete_prep->bindParam( ':nom', $nom, \PDO::PARAM_INT );

      if ( $requete_prep->execute() ){
          while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ )){
              $evenement = new Evenement();
              $evenement->id_evenement = $ligne->id_evenement;
              $evenement->nom = $ligne->nom;
              $evenement->description = $ligne->description;
              $evenement->lieu = $ligne->lieu;
              $evenement->date_debut = $ligne->date_debut;
              $evenement->date_fin = $ligne->date_fin;
              $evenement->etat = $ligne->etat;
              $evenement->id_organisateur = $ligne->id_organisateur;
              $evenement->id_discipline = $ligne->id_discipline;
          }
      }
      return $evenement;
    }

   //Afficher les événements valides
    static public function findAllValid() {
          $etat = "created";
          $db = connection::makeConnection();
          $requete = "SELECT * FROM evenement WHERE etat <> :etat";
          $requete_prep = $db->prepare( $requete );
          $requete_prep->bindParam( ':etat', $etat, \PDO::PARAM_INT );
          
          if($requete_prep->execute()){
            while ($ligne = $requete_prep->fetch(\PDO::FETCH_OBJ)){
              $event = new Evenement();
              $event->id_evenement = $ligne->id_evenement;
              $event->nom = $ligne->nom;
              $event->description = $ligne->description;
              $event->lieu = $ligne->lieu;
              $event->date_debut = $ligne->date_debut;
              $event->date_fin = $ligne->date_fin;
              $event->etat = $ligne->etat;
              $event->id_discipline = $ligne->id_discipline;
              $event->id_organisateur = $ligne->id_organisateur;
              $tab[] = $event;
            }
          }else{
            echo "erreur findAll";
          }
          return $tab;
    }

    public function gererEtatEvenement(){

    $requete = "UPDATE evenement SET etat = :etat WHERE id_evenement = :id_evenement";
    $requete_prep = $this->db->prepare($requete);
    $requete_prep->bindParam(':etat', $this->etat, \PDO::PARAM_STR, 15);
    $requete_prep->bindParam(':id_evenement', $this->id_evenement, \PDO::PARAM_INT);

    if($requete_prep->execute()){
      return $this->id_evenement;
    }else{
      return -1;
    }
  }
  public function getEpreuves()
  {
    
    $tab = array();
    $db = connection::makeConnection();
    $requete = "SELECT * from epreuve where id_evenement = :id";
    $requete_prep = $db->prepare( $requete );
    $requete_prep->bindParam( ':id', $this->id_evenement, \PDO::PARAM_INT );

    if ( $requete_prep->execute() )
      while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
      {  
          $abstract = new epreuve();
          $abstract->id = $ligne->id_epreuve;
          $abstract->nom = $ligne->nom;
          $abstract->description = $ligne->description;
          $abstract->date = $ligne->date;
          $abstract->tarif = $ligne->tarif;
          $abstract->date_limit_insc = $ligne->date_limit_insc;
          $abstract->id_evenement = $ligne->id_evenement;
          $tab[] = $abstract;
      }
      return $tab;
  }


}
