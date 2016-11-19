<?php

namespace app\model;

use app\utils\ConnectionFactory as Con;

Class Epreuve extends AbstractModel{

	public $id,$nom,$description,$date,$tarif,$date_limit_insc,$id_evenement;

	Public function __construct()
	{
		$this->db = Con::makeConnection();
	}	

	public function insert()
	{

		$requete = 'INSERT INTO epreuve VALUES("",:nom,:description,:date,:tarif,:date_limit_insc,:id_evenement)';

        $requete_prep = $this->db->prepare( $requete );
        
		$requete_prep->bindParam( ':nom', $this->nom, \PDO::PARAM_STR, 255 );
		$requete_prep->bindParam( ':description', $this->description, \PDO::PARAM_STR, 255 );
        $requete_prep->bindParam( ':date', $this->date, \PDO::PARAM_STR, 255 );
        $requete_prep->bindParam( ':tarif', $this->tarif, \PDO::PARAM_STR, 255 );
		$requete_prep->bindParam( ':date_limit_insc', $this->date_limit_insc, \PDO::PARAM_STR, 255 );
		$requete_prep->bindParam( ':id_evenement', $this->id_evenement, \PDO::PARAM_INT );
        
		if ( $requete_prep->execute() )
           $this->id =$this->db->LastInsertId();

        if(isset($this->id))
            return $this->id;
        else
            return false;
	}
    
    public function update()
    {
    	$requete = "UPDATE epreuve SET nom:nom,description:description,date:date,tarif:tarif,date_limit_insc:date_limit_insc,id_evenement:id_evenement where id=:id";

        $requete_prep = $this->db->prepare( $requete );

    	$requete_prep->bindParam( ':nom', $this->nom, \PDO::PARAM_STR, 255 );
        $requete_prep->bindParam( ':description', $this->description, \PDO::PARAM_STR, 255 );
        $requete_prep->bindParam( ':date', $this->date, \PDO::PARAM_STR, 255 );
        $requete_prep->bindParam( ':tarif', $this->tarif, \PDO::PARAM_STR, 255 );
        $requete_prep->bindParam( ':date_limit_insc', $this->date_limit_insc, \PDO::PARAM_STR, 255 );
        $requete_prep->bindParam( ':id_evenement', $this->id_evenement, \PDO::PARAM_INT );

		$requete_prep->bindParam( ':id', $this->id, \PDO::PARAM_INT );

		$bool =  $requete_prep->execute();

        return $bool;

    }
    
    public function save()
    {
    	if(isset($this->id))
    	{
    		$return = $this->update();
    	}else
    	{
    		$return = $this->insert();
    	}
        return $return ;
    }
    
    public function delete()
    {
    	$requete = "DELETE FROM epreuve WHERE id_epreuve=:id_epreuve";

        $requete_prep = $this->db->prepare( $requete );
    	$requete_prep->bindParam( ':id_epreuve', $this->id, \PDO::PARAM_INT );
    	$bool =  $requete_prep->execute();
		return $bool;

    }
    
    static public function findById($id)
     {
     	$requete = "SELECT * FROM epreuve WHERE id_epreuve=:id";

        $db = Con::makeConnection();
        $requete_prep = $db->prepare( $requete );
     	$requete_prep->bindParam( ':id', $id, \PDO::PARAM_INT );

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
            }
            if(isset($abstract)) {
                return $abstract;
            }
            else
                return false;
    }

   static public function findAll($id)
   {
        $tab = array();
        $db = Con::makeConnection();
            $requete = "SELECT * FROM epreuve where id_evenement = :id";
            $requete_prep = $db->prepare( $requete );
            $requete_prep->bindParam( ':id', $id, \PDO::PARAM_INT );

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
   public function getEvent()
   {
        $db = Con::makeConnection();
        $requete = "SELECT id_evenement FROM epreuve where id_epreuve = :id_epreuve";
        $requete_prep = $db->prepare( $requete );
        $requete_prep->bindParam( ':id_epreuve', $this->id, \PDO::PARAM_INT );

        if ( $requete_prep->execute() )
        {
            $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ );
            var_dump($this->id);
            return $ligne->id_evenement;
        }      
   }
   static public function getImages($id)
    {
        $db = Con::makeConnection();
        $requete = "SELECT p.file FROM epreuve e, photo p WHERE e.id_epreuve = p.id_epreuve and e.id_epreuve = :id";
        $requete_prep = $db->prepare( $requete );
        $requete_prep->bindParam( ':id', $id, \PDO::PARAM_INT );

        if ( $requete_prep->execute() )
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            { 
                $tab[] = $ligne;
            }
            
            if (isset($tab))
                return $tab;
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