<?php

namespace app\model;

use app\utils\ConnectionFactory as Con;
use app\utils\Authentification as Auth;


class Organisateur extends AbstractModel{

  public $id_organisateur;
  public $nom;
  public $prenom;
  public $url_site;
  public $email;
  public $telephone;
  public $login;
  public $password;
  public $action;

  function __construct(){
    $this->db = Con::makeConnection();
  }

  protected function update(){
    if($this->password != "")
    {
          $requete = "UPDATE organisateur SET
            nom = :nom,
            prenom = :prenom,
            url_site = :url_site,
            email = :email,
            telephone = :telephone,
            login = :login,
            password = :password
            WHERE id_organisateur = $this->id_organisateur";
            $requete_prep = $this->db->prepare($requete);
            $password = password_hash($this->password, PASSWORD_DEFAULT);
            $requete_prep->bindParam(':password', $password, \PDO::PARAM_STR, 30);
    }else
    {
      $requete = "UPDATE organisateur SET
            nom = :nom,
            prenom = :prenom,
            url_site = :url_site,
            email = :email,
            telephone = :telephone,
            login = :login
            WHERE id_organisateur = $this->id_organisateur";
            $requete_prep = $this->db->prepare($requete);
    }

    $requete_prep->bindParam(':nom', $this->nom, \PDO::PARAM_STR, 30);
    $requete_prep->bindParam(':prenom', $this->prenom, \PDO::PARAM_STR, 30);
    $requete_prep->bindParam(':url_site', $this->url_site, \PDO::PARAM_STR);
    $requete_prep->bindParam(':email', $this->email, \PDO::PARAM_STR, 30);
    $requete_prep->bindParam(':telephone', $this->telephone, \PDO::PARAM_STR, 30);
    $requete_prep->bindParam(':login', $this->login, \PDO::PARAM_STR, 30);
    
    $res = $requete_prep->execute();
    if($res)
      $this->action = "update";
    return $res;
  }

  protected function insert(){
    
        $requete = "INSERT INTO organisateur VALUES ('', :nom, :prenom, :url_site, :email, :telephone, :login, :password)";
        $requete_prep = $this->db->prepare($requete);
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $requete_prep->bindParam(':nom', $this->nom, \PDO::PARAM_STR, 30);
        $requete_prep->bindParam(':prenom', $this->prenom, \PDO::PARAM_STR, 30);
        $requete_prep->bindParam(':url_site', $this->url_site, \PDO::PARAM_STR);
        $requete_prep->bindParam(':email', $this->email, \PDO::PARAM_STR, 30);
        $requete_prep->bindParam(':telephone', $this->telephone, \PDO::PARAM_STR, 30);
        $requete_prep->bindParam(':login', $this->login, \PDO::PARAM_STR, 30);
        $requete_prep->bindParam(':password', $password, \PDO::PARAM_STR, 30);

          if($requete_prep->execute()){
              $id_organisateur = $this->db->LastInsertId();
              $this->id_organisateur = $id_organisateur;
              $this->action = "insert";
                  if(isset($id_organisateur)){
                    return $id_organisateur;
                  }else{
                    return -1;
                  }
          }
  }

  public function save(){
    if($this->id_organisateur != ""){
      $res = $this->update();
    }else{
      $id_organisateur = $this->insert();
      $res = isset($id_organisateur);
    }
    return $res;
  }


  public function delete(){
    if(!isset($this->id_organisateur)){
      echo'erreur delete';
      return 0;
    }else{
      $requete = "DELETE FROM organisateur WHERE id_organisateur = :id";
      $requete_prep = $this->db->prepare($requete);
      $requete_prep->bindParam(':id', $this->id_organisateur, \PDO::PARAM_INT);
      $nb_lignes = $requete_prep->execute();
      var_dump(nb_lignes);
      return nb_lignes; // nombre de lignes que la requete va supprimer
    }
  }

  public function getNom(){
    $requete = "SELECT nom from organisateur WHERE id_organisateur = :id";
    $requete_prep = $this->db->prepare($requete);
    $requete_prep->bindParam(':id', $this->id_organisateur, \PDO::PARAM_INT);
    if($requete_prep->execute()){
      $ligne = $requete_prep->fetch(\PDO::FETCH_OBJ);
      $ligne = $ligne->organisateur;
    }
    $organisateur = Organisateur::findById($ligne);
    return $organisateur;
  }

  static public function findById($id_organisateur){
    $db = Con::makeConnection();
    $requete = "SELECT * FROM organisateur WHERE id_organisateur=:id";
    $requete_prep = $db->prepare($requete);
    $requete_prep->bindParam(':id', $id_organisateur, \PDO::PARAM_INT);
    if ($requete_prep->execute()){
      $ligne = $requete_prep->fetch(\PDO::FETCH_OBJ);
      $organisateur = new Organisateur();
      $organisateur->id_organisateur = $ligne->id_organisateur;
      $organisateur->nom = $ligne->nom;
      $organisateur->prenom = $ligne->prenom;
      $organisateur->url_site = $ligne->url_site;
      $organisateur->email = $ligne->email;
      $organisateur->telephone = $ligne->telephone;
      $organisateur->login = $ligne->login;
      $organisateur->password = $ligne->password;
      return $organisateur;
    }else{
      echo "erreur findById";
      return false;
    }
  }

  static public function findAll(){
    $db = Con::makeConnection();
    $requete = "SELECT * FROM organisateur";
    $resultat = $db->query($requete);
    if($resultat){
      while ($ligne = $resultat->fetch(\PDO::FETCH_OBJ)){
        $organisateur = new Organisateur();
        $organisateur->id = $ligne->id;
        $organisateur->nom = $ligne->nom;
        $organisateur->prenom = $ligne->prenom;
        $organisateur->url_site = $ligne->url_site;
        $organisateur->email = $ligne->email;
        $organisateur->telephone = $ligne->telephone;
        $organisateur->login = $ligne->login;
        $organisateur->password = $ligne->password;
        $tab[] = $organisateur;
      }
    }else{
      echo "erreur findAll";
    }
    return $tab;
  }
    static public function getOrganisateurByLogin($login)
    {
        $requete = "SELECT * FROM organisateur WHERE login=:login";

        $db = Con::makeConnection();
        $requete_prep = $db->prepare( $requete );
        $requete_prep->bindParam( ':login', $login, \PDO::PARAM_INT );

        if ( $requete_prep->execute() )
        {
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {
                $organisateur = new organisateur();
                $organisateur->id_organisateur = $ligne->id_organisateur;
                $organisateur->nom = $ligne->nom;
                $organisateur->prenom = $ligne->prenom;
                $organisateur->url_site = $ligne->url_site;
                $organisateur->email = $ligne->email;
                $organisateur->telephone = $ligne->telephone;
                $organisateur->login = $ligne->login;
                $organisateur->password = $ligne->password;
            }
        }
            
        if(isset($organisateur))
            return $organisateur;
        else
            return false;
           
    }

    /*
    * Author : ikram
    */
    static public function getAllEventByOrganisateur()
    {
        $auth = new Auth();
        $tab = array();
        $id = Organisateur::getOrganisateurByLogin($auth->user_login);
        $current = $id->id_organisateur;

        $db = Con::makeConnection();
        $requete = "SELECT * FROM evenement where id_organisateur=:id_organisateur";

        $requete_prep = $db->prepare( $requete );
        $requete_prep->bindParam( ':id_organisateur', $current, \PDO::PARAM_INT );

        if($requete_prep->execute() ){
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
          echo "erreur getAllEventByOrganisateur";
        }
        return $tab;
    }

}
