<?php

namespace app\control;

use app\model\Evenement;
use app\model\Epreuve as epreuve;
use app\model\Inscription as inscription;
use app\model\Participant as participant;
use app\model\EpreuveParticipation as epreuveparticipation;
use app\view\OrganisationView as OrganisationView;
use app\view\ParticipationView;
use app\utils\Authentification as Auth;
use app\model\Photo;
use app\model\Organisateur;
class OrganisationControl{

	private $request=null;

	public function __construct(\app\utils\HttpRequest $http_req){
		$this->request = $http_req ;
	}

	public function listAllEpreuve()
	{
		$id = $_GET['id'];
        $pages = epreuve::findAll($id);
        $view = new ParticipationView($pages);
        $view->render('allEpreuves');
    }

    public function addEpreuve()
    {
    	$epreuve = new epreuve();
    	$view = new OrganisationView($epreuve);
    	$view->render('addEpreuve');
    }

    public function insertEpreuve()
    {
    	$post = $this->request->post;

        $epreuve = new epreuve();
        $epreuve->nom = filter_var( $post['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->description = filter_var( $post['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->date = filter_var( $post['date'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->tarif = filter_var( $post['tarif'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->date_limit_insc = filter_var( $post['date_limit_insc'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->id_evenement = filter_var( $post['id_evenement'], FILTER_SANITIZE_SPECIAL_CHARS);

        $return = $epreuve->save();

        if(isset($return))
        {
            header('Location:'.$this->request->script_name.'/participation/visualiser_epreuve/?id='.$return);
        }
    }

    public function viewEpreuve()
    {
    	$id = $_GET['id'];
    	$view = new OrganisationView(epreuve::findById($id));
    	$view->render('viewEpreuve');
    }

    public function updateEpreuve()
    {
    	$id = $_GET['id'];
    	$view = new OrganisationView(epreuve::findById($id));
    	$view->render('updateEpreuve');
    }

    public function saveEpreuve()
    {
        $post = $this->request->post;

        $epreuve = new epreuve();
        $epreuve->nom = filter_var( $post['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->description = filter_var( $post['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->date = filter_var( $post['date'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->tarif = filter_var( $post['tarif'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->date_limit_insc = filter_var( $post['date_limit_insc'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve->id_evenement = filter_var( $_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        $return = $epreuve->save();

        if($return)
        {
            header('Location:'.$this->request->script_name.'/participation/visualiser_epreuve/?id='.$return);
        }
    }

    public function deleteEpreuve()
    {
        $id = filter_var( $_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $epreuve = epreuve::findById($id);

        $return = $epreuve->delete();

        if($return)
        {
            header('Location:'.$this->request->script_name.'/organisation/liste_epreuves/?id='.$epreuve->id_evenement);
        }
        else {
        	print('Erreur de suppression');
        }
			}

	public function creerEvenement(){
		$event = new epreuve();
		$ov = new OrganisationView($event);
		$ov->render('newEvenement');
	}

	public function viewEvenement(){
		$nom = $_GET['id'];
		$view = new OrganisationView(Evenement::findById($nom));
		$view->render('viewEvenement');
	}

	public function addEvent(){
		$auth = new Auth();
		if($auth->logged_in){
			$event = new Evenement();
			$event->nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
			$event->description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
			$event->lieu = filter_var($_POST['lieu'], FILTER_SANITIZE_SPECIAL_CHARS);
			$event->date_debut = filter_var($_POST['date_debut'], FILTER_SANITIZE_SPECIAL_CHARS);
			$event->date_fin = filter_var($_POST['date_fin'], FILTER_SANITIZE_SPECIAL_CHARS);
			$event->etat = "created";
			$event->id_discipline = filter_var($_POST['listDisc'], FILTER_SANITIZE_SPECIAL_CHARS);
            $event->id_organisateur = Organisateur::getOrganisateurByLogin($auth->user_login)->id_organisateur;
			$return = $event->save();
			if($return)
			{
					header('Location:'.$this->request->script_name.'/app/view/?id='.$return);
			}
		}
	}
	public function updateEvenement(){
		$auth = new Auth();
		if($auth->logged_in){
			$organisateur = Organisateur::getOrganisateurByLogin($auth->user_login);
			if($auth->user_login == $organisateur->login){
				$id = $_GET['id'];
				$view = new OrganisationView(evenement::findById($id));
				$view->render('updateEvenement');
			}
		}
	}
	public function deleteEvenement(){
		$auth = new Auth();
		if($auth->logged_in){
			$organisateur = Organisateur::getOrganisateurByLogin($auth->user_login);
			if($auth->user_login == $organisateur->login){
				$id = filter_var( $_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
				$evenement = evenement::findById($id);
				$return = $evenement->delete();

				if($return){
						header('Location:'.$this->request->script_name.'/organisation/allEvent/');
				}else{
					print('Erreur de suppression');
				}
			}
		}
	}
    public function saveEvenement()
    {
            $auth = new Auth();
            $post = $this->request->post;
            $event = new Evenement();
                        $event->id_evenement = $post['id_evenement'];
            $event->nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
            $event->description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
            $event->lieu = filter_var($_POST['lieu'], FILTER_SANITIZE_SPECIAL_CHARS);
            $event->date_debut = filter_var($_POST['date_debut'], FILTER_SANITIZE_SPECIAL_CHARS);
            $event->date_fin = filter_var($_POST['date_fin'], FILTER_SANITIZE_SPECIAL_CHARS);
            $event->etat = "en cours";
            $event->id_organisateur = Organisateur::getOrganisateurByLogin($auth->user_login)->id_organisateur;
            $event->id_discipline = filter_var($_POST['listDisc'], FILTER_SANITIZE_SPECIAL_CHARS);

            $return = $event->save();
            if($return)
            {
                    header('Location:'.$this->request->script_name.'/app/view/?id='.$return);
            }
    }
    //Valider evenement (voir aussi renderViewEvenement sur OrganisationView)
    public function validerEvenement()
    {
        $auth = new Auth();
        if($auth->logged_in){
            $organisateur = Organisateur::getOrganisateurByLogin($auth->user_login);
            if($auth->user_login == $organisateur->login){
                $evenement = new Evenement();
                $evenement->etat = "valid_open";
                $evenement->id_evenement = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
                $return = $evenement->gererEtatEvenement();

                if($return)
                {
                    header('Location:'.$this->request->script_name.'/app/view/?id='.$return);
                }
            }
        }
    }

    //Ouvrir les inscriptions
    public function ouvrirInscriptionEvenement()
    {
        $auth = new Auth();
        if($auth->logged_in){
            $organisateur = Organisateur::getOrganisateurByLogin($auth->user_login);
            if($auth->user_login == $organisateur->login){
                $evenement = new Evenement();
                $evenement->etat = "valid_open";
                $evenement->id_evenement = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
                $return = $evenement->gererEtatEvenement();
                if($return)
                {
                    header('Location:'.$this->request->script_name.'/app/view/?id='.$return);
                }
            }
        }
    }
     public function fermerInscriptionEvenement()
    {
        $auth = new Auth();
        if($auth->logged_in){
            $organisateur = Organisateur::getOrganisateurByLogin($auth->user_login);
            if($auth->user_login == $organisateur->login){
                $evenement = new Evenement();
                $evenement->etat = "valide_close";
                $evenement->id_evenement = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
                $return = $evenement->gererEtatEvenement();
                if($return)
                {
                    header('Location:'.$this->request->script_name.'/app/view/?id='.$return);
                }
            }
        }
    }
    /*
     * author : ikram
     */
    public function getfile()
    {
        $epreuve = new epreuve();
        $ov = new OrganisationView($epreuve);
        $ov->render('uploadFile');
    }
    /*
     * author : ikram
    */
    public function savefile()
            {
        $id_epreuve = $_GET['id'];
        $handle = fopen($_FILES["results"]["tmp_name"],"r");
        $ep = new epreuveparticipation();

         while ($data = fgetcsv($handle,1000,",","'"))
         {
            foreach ($data as $value) {
                $explode = explode(';', $value);
                $id_inscription = $ep->getInscriptionFromDossad($id_epreuve,$explode[1]);
                $ep->action = "update";
                $ep->id_inscription = $id_inscription;
                $ep->id_epreuve = $id_epreuve;
                $ep->classement = $explode[0];
                $ep->num_dossard = $explode[1];
                $ep->score =  $explode[2];
                $saved = $ep->save();
            }
         }
         if($saved)
         {
            $ov = new OrganisationView($ep);
            $ov->render('fileuploaded');
         }
     }
     /*
     * author : ikram
     */
        public function downloadFile(){
        $id = $_GET['id'];

        header("Content-disposition: filename=liste_inscription.csv");
        header("Content-Type: text/csv; charset=UTF-8");
        $entete = array("Nom", "Prenom","Email","Sexe","DateNaissance","DateInscription","NumDossard");
        $lignes = array();
        $ep = new EpreuveParticipation();
        $array = $ep->getInscriptionsByEpreuve($id);
            foreach ($array as $value) {
                $inscription = new inscription();
                $insc = $inscription::findById($value);
                $num = $ep::findById($id,$insc->id_inscription);
                $participant = new participant();
                $participant = $participant::findById($insc->id_participant);
                $lignes[] = array($participant->nom, $participant->prenom,$participant->email,$participant->sexe,
                                $participant->date_naissance,$insc->date_inscription,$num->num_dossard);
            }

        $separateur = ";";

        echo implode($separateur, $entete)."\r\n";

        foreach ($lignes as $ligne) {
            echo implode($separateur, $ligne)."\r\n";
        }
        }
    public function addPicture()
    {
        $view = new OrganisationView(Epreuve::findById($_GET['id']));
        $view->render('addPicture');
    }

     public function insertPicture()
    {
        $post = $this->request->post;

        $photo = new Photo();

        try {
            if (
                !isset($_FILES['upfile']['error']) ||
                is_array($_FILES['upfile']['error'])
            ) {
                echo "<p>Paramètres incorrects</p>";
                echo "<a href='".$this->request->script_name."/participation/visualiser_epreuve/?id=".$_GET['id']."'>[   Retour   ] </a>";exit;
            }

            switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "Veuillez choisir un fichier";
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo "Vous avez dépasser la taille maximale";
                default:
                    echo "Erreur inconnue";
            }

            if ($_FILES['upfile']['size'] > 1000000) {
                echo "<p>Vous avez dépasser la taille maximale</p>";
                echo "<a href='".$this->request->script_name."/participation/visualiser_epreuve/?id=".$_GET['id']."'>[   Retour   ] </a>";exit;
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            if (false === $ext = array_search(
                finfo_file($finfo, $_FILES['upfile']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )) {
                echo "<p>format incorrect</p>";
                echo "<a href='".$this->request->script_name."/participation/visualiser_epreuve/?id=".$_GET['id']."'>[   Retour   ] </a>";exit;
            }

            $file_name;
            if (!move_uploaded_file(
                $_FILES['upfile']['tmp_name'],
                sprintf('./uploads/%s.%s',
                    $file_name = sha1_file($_FILES['upfile']['tmp_name']),
                    $ext)
                    )
                )
            {
                echo "Votre image n\'a pas été enregistrer";
                echo "<a href='".$this->request->script_name."/participation/visualiser_epreuve/?id=".$_GET['id']."'>[   Retour   ] </a>";exit;
            } 

            $file_name = $file_name.'.'.$ext;
            $photo = new Photo();
            $photo->file = $file_name;
            //changer $_GET par $post
            $photo->id_epreuve = $post['id'];
            //faire un $return pour retourner l'id de l'épreuve et rediriger vers ce dernier après insertion
            $return = $photo->save();

            if (isset($return)) {
                header('Location:'.$this->request->script_name.'/participation/visualiser_epreuve/?id='.$return);    
            }
            

        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }
    }
}
