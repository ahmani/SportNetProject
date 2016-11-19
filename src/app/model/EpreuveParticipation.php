<?php
/*
*
* author : ikram
*/

namespace app\model;

use app\utils\ConnectionFactory as Con;
use app\model\Inscription ;
use app\model\Organisateur;

Class EpreuveParticipation extends AbstractModel{

	public $id_epreuve,$id_inscription,$num_dossard,$classement,$score,$action;

	Public function __construct()
	{
		$this->db = Con::makeConnection();
	}	

    	public function insert()
    	{

    		$requete = 'INSERT INTO epreuve_participation (id_epreuve, id_inscription, num_dossard ,classement, score)VALUES(:id_epreuve,:id_inscription,:num_dossard,:classement,:score)';

            $requete_prep = $this->db->prepare( $requete );

        $requete_prep->bindParam( ':id_epreuve', $this->id_epreuve, \PDO::PARAM_INT );
        $requete_prep->bindParam( ':id_inscription', $this->id_inscription, \PDO::PARAM_INT );
            $requete_prep->bindParam( ':num_dossard', $this->num_dossard, \PDO::PARAM_INT );
            $requete_prep->bindParam( ':classement', $this->classement, \PDO::PARAM_INT );
        $requete_prep->bindParam( ':score', $this->score, \PDO::PARAM_STR, 255  );

        if ($requete_prep->execute()){
               return true;
        }
                return false;
    	}
    
    public function update()
    {
    	$requete = "UPDATE epreuve_participation SET id_epreuve=:id_epreuve,id_inscription=:id_inscription,num_dossard=:num_dossard,classement=:classement,score=:score where id_epreuve=:id_epreuve and id_inscription=:id_inscription";

        $requete_prep = $this->db->prepare( $requete );

    	$requete_prep->bindParam( ':id_epreuve', $this->id_epreuve, \PDO::PARAM_INT );
        $requete_prep->bindParam( ':id_inscription', $this->id_inscription, \PDO::PARAM_INT );
        $requete_prep->bindParam( ':num_dossard', $this->num_dossard, \PDO::PARAM_INT );
        $requete_prep->bindParam( ':classement', $this->classement, \PDO::PARAM_INT );
        $requete_prep->bindParam( ':score', $this->score, \PDO::PARAM_STR, 255  );

		$bool =  $requete_prep->execute();

        return $bool;

    }
    
    public function save()
    {
    	if($this->action == "insert")
    	{
            $return = $this->insert();
    	}
      elseif($this->action == 'update')
    	{
    		$return = $this->update();
    	}
        return $return ;
    }
    
    public function delete()
    {
    	$requete = "DELETE * FROM epreuve_participation WHERE id_epreuve=:id_epreuve and id_inscription:id_inscription";

        $requete_prep = $this->db->prepare( $requete );
    	$requete_prep->bindParam( ':id_epreuve', $this->id_epreuve, PDO::PARAM_INT );
        $requete_prep->bindParam( ':id_inscription', $this->id_inscription, PDO::PARAM_INT );


    	$bool =  $requete_prep->execute();

		if (!$bool)
			    throw new Exception('Erreur de suppression');
    }
    
    static public function findById($id_epreuve,$id_inscription)
     {
     	$requete = "SELECT * FROM epreuve_participation WHERE id_epreuve=:id_epreuve and id_inscription=:id_inscription";

        $db = Con::makeConnection();
        $requete_prep = $db->prepare( $requete );
     	$requete_prep->bindParam( ':id_epreuve', $id_epreuve, \PDO::PARAM_INT );
        $requete_prep->bindParam( ':id_inscription', $id_inscription, \PDO::PARAM_INT );

        if ( $requete_prep->execute() )
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {
                $abstract = new EpreuveParticipation();
                $abstract->id_epreuve = $ligne->id_epreuve;
                $abstract->id_inscription = $ligne->id_inscription;
                $abstract->classement = $ligne->classement;
                $abstract->score = $ligne->score;
                $abstract->num_dossard = $ligne->num_dossard;
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
            $requete = "SELECT * FROM epreuve_participation ";
             $requete_prep = $db->prepare( $requete );

       if ( $requete_prep->execute() )
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {  
                $abstract = new EpreuveParticipation();
                $abstract->id_epreuve = $ligne->id_epreuve;
                $abstract->id_inscription = $ligne->id_inscription;
                $abstract->classement = $ligne->classement;
                $abstract->score = $ligne->score;
                $abstract->num_dossard = $ligne->num_dossard;
                $tab[] = $abstract;
            }
            return $tab;
   }

   /*
   * author : ikram
   */
   static public function getInscriptionFromDossad($id_epreuve,$num_dossard)
   {
        $tab = array();
        $db = Con::makeConnection();
            $requete = "SELECT id_inscription FROM epreuve_participation where id_epreuve=:id_epreuve
                        and num_dossard=:num_dossard";
            $requete_prep = $db->prepare( $requete );
            $requete_prep->bindParam( ':id_epreuve', $id_epreuve, \PDO::PARAM_INT );
            $requete_prep->bindParam( ':num_dossard', $num_dossard, \PDO::PARAM_INT );
            if ( $requete_prep->execute() )
            $id_inscription =  $requete_prep->fetch( \PDO::FETCH_COLUMN );
            if(isset($id_inscription))
                return $id_inscription;
   }

    /*
   * author : ikram
   */
   static public function getInscriptionsByEpreuve($id_epreuve)
   {
        $tab = array();
        $db = Con::makeConnection();
            $requete = "SELECT id_inscription FROM epreuve_participation where id_epreuve=:id_epreuve";
            $requete_prep = $db->prepare( $requete );
            $requete_prep->bindParam( ':id_epreuve', $id_epreuve, \PDO::PARAM_INT );
            if ( $requete_prep->execute() )
               {
                    while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
                    {  
                        $tab[] = $ligne->id_inscription;
                    }
                    return $tab;
                }
            
   }

   static public function getAllEpreuves()
   {
        $tab = array();
        $db = Con::makeConnection();

        //$id_inscription = Inscription::findByParticipant($id_participant);
            $requete = "SELECT id_epreuve FROM epreuve_participation where classement IS NOT NULL  and score IS NOT NULL ";
            $requete_prep = $db->prepare( $requete );
            //$requete_prep->bindParam( ':id_inscription', $id_inscription, \PDO::PARAM_INT );
            if ( $requete_prep->execute() )
               {
                    while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
                    {  
                        $epreuve = Epreuve::findById($ligne->id_epreuve);
                        $tab[] = $epreuve;
                    }
                    return $tab;
                }
            
   }

   static public function getEpreuvesByOrganisateur()
   {
        $tab = array();
        $db = Con::makeConnection();

        $events = Organisateur::getAllEventByOrganisateur();
        foreach ($events as $value) {
          $evenement = new evenement();
          $evenement->id_evenement = $value->id_evenement;
          $epreuves = $evenement->getEpreuves();
          $tab[] = $epreuves; 
        }
        return $tab;
        /*$id_inscription = Inscription::findByParticipant($id_participant);
            $requete = "SELECT id_epreuve FROM epreuve_participation where id_inscription=:id_inscription";
            $requete_prep = $db->prepare( $requete );
            $requete_prep->bindParam( ':id_inscription', $id_inscription, \PDO::PARAM_INT );
            if ( $requete_prep->execute() )
               {
                    while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
                    {  
                        $tab[] = $ligne->id_epreuve;
                    }
                    return $tab;
                }*/
            
   }
   static public function findByEpreuve($id_epreuve){
     $tab = array();
     $db = Con::makeConnection();
     $requete = "SELECT * from epreuve_participation where id_epreuve=:id_epreuve";
     $requete_prep = $db->prepare($requete);
     $requete_prep->bindParam(':id_epreuve', $id_epreuve, \PDO::PARAM_INT);

     if ($requete_prep->execute()){
        while ($ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ )){
          $tab[] = $ligne;
        }
      }
      return $tab;
    }

    static public function findByDossard($num_dossard){
      $db = Con::makeConnection();
      $requete = "SELECT * from epreuve_participation where num_dossard=:num_dossard";
      $requete_prep = $db->prepare($requete);
      $requete_prep->bindParam(':num_dossard', $num_dossard, \PDO::PARAM_INT);
      if ( $requete_prep->execute() )
          while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
          {
              $abstract = new EpreuveParticipation();
              $abstract->id_epreuve = $ligne->id_epreuve;
              $abstract->id_inscription = $ligne->id_inscription;
              $abstract->classement = $ligne->classement;
              $abstract->score = $ligne->score;
              $abstract->num_dossard = $ligne->num_dossard;
          }
          if(isset($abstract))
              return $abstract;
          else
              return false;
      }
}