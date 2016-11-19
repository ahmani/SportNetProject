<?php

namespace app\model;

use app\utils\ConnectionFactory as Con;

Class Inscription extends AbstractModel{

	public $id_inscription, $date_inscription, $id_participant;

	Public function __construct()
	{
		$this->db = Con::makeConnection();
	}	

	public function insert()
	{
		$requete = 'INSERT INTO inscription VALUES("", :date_inscription, :id_participant)';

        $requete_prep = $this->db->prepare($requete);
        
		$requete_prep->bindParam( ':date_inscription', $this->date_inscription, \PDO::PARAM_STR, 254 );
		$requete_prep->bindParam( ':id_participant', $this->id_participant, \PDO::PARAM_INT );
        
		if ( $requete_prep->execute() )
           $this->id_inscription =$this->db->LastInsertId();

        if(isset($this->id_inscription))
            return $this->id_inscription;
        else
            return false;
	}
    
    public function update()
    {
    	$requete = "UPDATE inscription SET date_inscription=:date_inscription where id_inscription=:id_inscription";

        $requete_prep = $this->db->prepare( $requete );

    	$requete_prep->bindParam( ':date_inscription', $this->date_inscription, \PDO::PARAM_STR, 50 );
		$requete_prep->bindParam( ':id_inscription', $this->id_inscription, \PDO::PARAM_INT );

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
    	$requete = "DELETE * FROM inscription WHERE id_inscription=:id_inscription";

        $requete_prep = $this->db->prepare( $requete );
    	$requete_prep->bindParam( ':id_inscription', $id_inscription, PDO::PARAM_INT );


    	$bool =  $requete_prep->execute();

		if (!$bool)
			throw new Exception('Erreur de suppression');
    }
    
    static public function findById($id)
    {
     	$requete = "SELECT * FROM inscription WHERE id_inscription=:id_inscription";

        $db = Con::makeConnection();
        $requete_prep = $db->prepare( $requete );
     	$requete_prep->bindParam( ':id_inscription', $id, \PDO::PARAM_INT );


        if ( $requete_prep->execute() )
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {
                $abstract = new inscription();
                $abstract->id_inscription = $ligne->id_inscription;
                $abstract->date_inscription = $ligne->date_inscription;
                $abstract->id_participant = $ligne->id_participant;
            }
            if(isset($abstract))
                return $abstract;
            else
                return false;
    }

    static public function findByParticipant($id_participant)
    {
        $requete = "SELECT id_inscription FROM inscription WHERE id_participant=:id_participant";

        $db = Con::makeConnection();
        $requete_prep = $db->prepare( $requete );
        $requete_prep->bindParam( ':id_participant', $id_participant, \PDO::PARAM_INT );

        if ( $requete_prep->execute() )
            $ligne =  $requete_prep->fetch( \PDO::FETCH_COLUMN );
            if(isset($ligne))
                return $ligne;
            else
                return false;
    }
    
   static public function findAll()
   {
        $tab = array();
        $db = Con::makeConnection();
            $requete = "SELECT * FROM inscription ";
             $requete_prep = $db->prepare( $requete );

       if ( $requete_prep->execute() )
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {  
                $abstract = new inscription();
                $abstract->id_inscription = $ligne->id_inscription;
                $abstract->date_inscription = $ligne->date_inscription;
                $abstract->id_participant = $ligne->id_participant;
                $tab[] = $abstract;
            }
            return $tab;
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