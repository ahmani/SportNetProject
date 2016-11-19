<?php
/*
*
* author : ikram
*/

namespace app\model;

use app\utils\ConnectionFactory as Con;

Class Photo extends AbstractModel{

	public $id, $file, $id_epreuve;

	Public function __construct()
	{
		$this->db = Con::makeConnection();
	}	

	public function insert()
	{

		$requete = 'INSERT INTO photo VALUES("",:file,:id_epreuve)';

        $requete_prep = $this->db->prepare( $requete );
        
		$requete_prep->bindParam( ':file', $this->file, \PDO::PARAM_STR, 255 );
		$requete_prep->bindParam( ':id_epreuve', $this->id_epreuve, \PDO::PARAM_INT );

        
		if ( $requete_prep->execute() )
           $this->id =$this->db->LastInsertId();


        if(isset($this->id))
            return $this->id;
        else
            return false;
	}
    
    public function update()
    {
    	$requete = "UPDATE epreuve SET file:file,id_epreuve:id_epreuve where id=:id";

        $requete_prep = $this->db->prepare( $requete );

        $requete_prep->bindParam( ':file', $this->file, \PDO::PARAM_STR, 255 );
        $requete_prep->bindParam( ':id_epreuve', $this->id_epreuve, \PDO::PARAM_INT );

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
    	$requete = "DELETE * FROM photo WHERE id=:id";

        $requete_prep = $this->db->prepare( $requete );
    	$requete_prep->bindParam( ':id', $id, PDO::PARAM_INT );


    	$bool =  $requete_prep->execute();

		if (!$bool)
			    throw new Exception('Erreur de suppression');

    }
    
    static public function getphotosByEpreuve($id_epreuve)
     {
     	$requete = "SELECT * FROM photo WHERE id_epreuve=:id_epreuve";

        $db = Con::makeConnection();
        $requete_prep = $db->prepare( $requete );
     	$requete_prep->bindParam( ':id_epreuve', $id_epreuve, \PDO::PARAM_INT );

        if ( $requete_prep->execute() )
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {
                $abstract = new epreuve();
                $abstract->file = $ligne->file;
                $tab[] = $abstract;
            }
            if(isset($abstract))
                return $abstract;
            else
                return false;
    }

   /*static public function findAll()
   {
        $tab = array();
        $db = Con::makeConnection();
            $requete = "SELECT * FROM epreuve ";
             $requete_prep = $db->prepare( $requete );

       if ( $requete_prep->execute() )
            while ( $ligne =  $requete_prep->fetch( \PDO::FETCH_OBJ ))
            {  
                $abstract = new epreuve();
                $abstract->id = $ligne->id;
                $abstract->title = $ligne->title;
                $abstract->text = $ligne->text;
                $abstract->date = $ligne->date;
                $abstract->author = $ligne->author;
                $tab[] = $abstract;
            }
            return $tab;
   }*/

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