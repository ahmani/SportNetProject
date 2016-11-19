<?php

namespace app\model;

use app\utils\ConnectionFactory as Con;
use app\utils\Authentification as Auth;


Class Participant extends AbstractModel{

    public $id_participant, $nom, $prenom, $sexe,$email, $date_naissance, $preferences,$login,$password,$action;

    Public function __construct()
    {
        $this->db = Con::makeConnection();
    }   

    public function insert()
    {
        $requete = 'INSERT INTO participant VALUES("", :nom, :prenom, :email, :sexe, :date_naissance,:preferences, :login,:password )';

        $requete_prep = $this->db->prepare($requete);
        
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $requete_prep->bindParam( ':nom', $this->nom, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':prenom', $this->prenom, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':email', $this->email, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':sexe', $this->sexe, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':date_naissance', $this->date_naissance, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':preferences', $this->preferences, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':login', $this->login, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':password', $password, \PDO::PARAM_STR, 254 );

        if ( $requete_prep->execute() )
        {
           $this->id_participant =$this->db->LastInsertId();
            $this->action = "insert";
        }

        if(isset($this->id_participant))
            return $this->id_participant;
        else
            return false;
    }
    
    public function update()
    {
        if($this->password != "")
        {
            $requete = "UPDATE participant 
                        SET nom=:nom, 
                            prenom=:prenom, 
                            email= :email, 
                            sexe=:sexe, 
                            date_naissance=:date_naissance, 
                            preferences= :preferences, 
                            login = :login, 
                            password = :password 
                            where id_participant=:id_participant";
            $requete_prep = $this->db->prepare( $requete );
            $password = password_hash($this->password, PASSWORD_DEFAULT);
        }else
        {
            $requete = "UPDATE participant 
                        SET nom=:nom, 
                        prenom=:prenom, 
                        email= :email, 
                        sexe=:sexe, 
                        date_naissance=:date_naissance, 
                        preferences= :preferences, 
                        login = :login
                        where id_participant=:id_participant";
             $requete_prep = $this->db->prepare( $requete );
        }

        $requete_prep->bindParam( ':nom', $this->nom, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':prenom', $this->prenom, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':email', $this->email, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':sexe', $this->sexe, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':date_naissance', $this->date_naissance, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':preferences', $this->preferences, \PDO::PARAM_STR, 254 );
        $requete_prep->bindParam( ':id_participant', $this->id_participant, \PDO::PARAM_INT );
        $requete_prep->bindParam( ':login', $this->login, \PDO::PARAM_STR, 254 );

            $bool =  $requete_prep->execute();
            if($bool)
                $this->action = "update";
        return $bool;
    }

    public function save()
    {
            if($this->id_participant != ""){
              $res = $this->update();
            }else{
              $id_participant = $this->insert();
              $res = isset($id_participant);
            }
        return $res ;
    }
    
    public function delete()
    {
        $requete = "DELETE * FROM participant WHERE id_participant=:id_participant";

        $requete_prep = $this->db->prepare( $requete );
        $requete_prep->bindParam( ':id_participant', $id_participant, PDO::PARAM_INT );


        $bool =  $requete_prep->execute();

        if (!$bool)
                throw new Exception('Erreur de suppression');
    }
    
    static public function findById($id_participant)
    {
        $requete = "SELECT * FROM participant WHERE id_participant=:id_participant";

        $db = Con::makeConnection();
        $requete_prep = $db->prepare( $requete );
        $requete_prep->bindParam( ':id_participant', $id_participant, \PDO::PARAM_INT );


        if ( $requete_prep->execute() )
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {
                $abstract = new participant();
                $abstract->id_participant = $ligne->id_participant;
                $abstract->nom = $ligne->nom;
                $abstract->prenom = $ligne->prenom;
                $abstract->email = $ligne->email;
                $abstract->sexe = $ligne->sexe;
                $abstract->date_naissance = $ligne->date_naissance;
                $abstract->preferences = $ligne->preferences;
                $abstract->login = $ligne->login;
            }
            if(isset($abstract))
                return $abstract;
            else
                return false;
    }
    
   static public function findAll()
   {
        $tab = array();
        $db = Con::makeConnection();
            $requete = "SELECT * FROM participant ";
             $requete_prep = $db->prepare( $requete );

       if ( $requete_prep->execute() )
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {  
                $abstract = new participant();
                $abstract->id_participant = $ligne->id_participant;
                $abstract->nom = $ligne->nom;
                $abstract->prenom = $ligne->prenom;
                $abstract->email = $ligne->email;
                $abstract->sexe = $ligne->date;
                $abstract->date_naissance = $ligne->date_naissance;
                $abstract->preferences = $ligne->preferences;
                $abstract->login = $ligne->login;
                $tab[] = $abstract;
            }
            return $tab;
   }
    static public function getParticipantByLogin($login)
    {
        $requete = "SELECT * FROM participant WHERE login=:login";

        $db = Con::makeConnection();
        $requete_prep = $db->prepare( $requete );
        $requete_prep->bindParam( ':login', $login, \PDO::PARAM_INT );

        if ( $requete_prep->execute() )
        {
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {
                $participant = new participant();
                $participant->id_participant = $ligne->id_participant;
                $participant->nom = $ligne->nom;
                $participant->prenom = $ligne->prenom;
                $participant->email = $ligne->email;
                $participant->sexe = $ligne->sexe;
                $participant->date_naissance = $ligne->date_naissance;
                $participant->preferences = $ligne->preferences;
                $participant->login = $ligne->login;
                $participant->password = $ligne->password;
            }
        }
            
        if(isset($participant))
            return $participant;
        else
            return false;
           
    }
   /*static public function getAuthor()
   {
        $tab = array();
        $db = Con::makeConnection();
    
        if (!empty($_SESSION["user"])) {
            $requete = "SELECT * FROM user where id = :author";
            $requete_prep = $db->prepare( $requete );
            $requete_prep->bindParam( ':author', $_SESSION["user"]->id, \PDO::PARAM_INT );

            if ( $requete_prep->execute() )
            {
                $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ );
                return $ligne;
            }      
        }          
   }*/
}