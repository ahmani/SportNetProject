<?php
namespace app\control;

use app\model\Evenement;
use app\view\ParticipationView;
use app\model\Epreuve;
use app\utils\Authentification as auth;
use app\model\Organisateur;
use app\model\Participant;
use app\model\Inscription;
use app\model\EpreuveParticipation;

class ParticipationControl {
  private $request=null;

  public function __construct(\app\utils\HttpRequest $http_req){
    $this->request = $http_req ;
  }

  public function listAll()
  {
    $auth = new auth();
        if($auth->profil == "organisateur")
        {
            $tabEvenement = Organisateur::getAllEventByOrganisateur(); 
        }else
        {
            $tabEvenement = Evenement::findAllValid();
        }
        if(empty($tabEvenement))
        { 
            $tabEvenement['erreur'] = "Vous n'avez d'événement pour l'instant.";
        }

      $pv = new \app\view\ParticipationView($tabEvenement);
      print($pv->render('all'));
  }

    public function listAllEpreuve()
	  {
    		$id = $_GET['id'];
    		$event = Evenement::findById($id);
        $view = new ParticipationView($event->getEpreuves());
        $view->render('allEpreuves');
    }

    public function viewEvent()
    {
    	$id = $_GET['id'];
    	$view = new ParticipationView(Evenement::findById($id));
    	$view->render('viewEvent');
    }

    public function viewEpreuve()
    {
    	$id = $_GET['id'];
    	$view = new ParticipationView(Epreuve::findById($id));
    	$view->render('viewEpreuve');
    }

        public function getParticipationForm(){
          $data = $this->request->post;
          $_SESSION['epreuves'] = $data['epreuves'];
      $auth = new auth();
      if($auth->logged_in)
      {
          $participant =  Participant::getParticipantByLogin($auth->user_login);
      }else
      {
          $participant = new Participant();
      }

      $view = new ParticipationView($participant);
      $view->render('participationForm');
    }

    public function saveParticipation(){
      $post = $this->request->post;
      //Enregistrer le participant
        $participant = new Participant();
        if(isset($post['id_participant']))
                            $participant->id_participant = $post['id_participant'];
        $participant->nom = filter_var( $post['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->prenom = filter_var( $post['prenom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->email = filter_var( $post['email'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->sexe = filter_var( $post['sexe'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->date_naissance = filter_var( $post['date_naissance'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->preferences = null;
        $participant->login = filter_var( $post['login'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->password = $post['password'];
        $participant->save();

        $rightNow = getDate();
        $date = $rightNow['year']."-".$rightNow['mon']."-".$rightNow['mday'];
        $inscription = new Inscription();
        if(isset($post['id_participant']))
        {
            $inscription->id_participant = filter_var($post['id_participant'], FILTER_SANITIZE_SPECIAL_CHARS);
        }else{
            $inscription->id_participant = $participant->id_participant;
        }
        
        $inscription->date_inscription = $date;


      if($inscription->save()){
        $tab = array();
        if(isset($_SESSION['epreuves']))
        {
            foreach ($_SESSION['epreuves'] as $key => $value) {
              $ep = new EpreuveParticipation();
              $ep->action = "insert";
              $ep->id_inscription = $inscription->id_inscription;
              $ep->id_epreuve = $value;
              $ep->num_dossard = $ep->id_inscription;
              $epreuve[$value] = Epreuve::findById($value)->nom;
              $tab = array('id_inscription' => $inscription->id_inscription, 'epreuves' => $epreuve);
              $ep->save();
            }
        }
          $view = new ParticipationView($tab);
          $view->render('paiementForm');
        
      }
    }

    public function viewParticipation(){
      $id = $_GET['id'];
      $inscription = Inscription::findById($id);
      $view = new ParticipationView($inscription);
      $view->render('viewParticipation');
    }

    public function viewEpreuveParticipant(){
      $auth = new auth();
      if($auth->profil == "organisateur"){
          $tab = EpreuveParticipation::getEpreuvesByOrganisateur();
         
      }else{
          $tab = EpreuveParticipation::getAllEpreuves();
      }
        
      $view = new ParticipationView($tab);
      $view->render('tabEpreuve');
    }

    public function viewResultat(){
      $id_epreuve = $_GET['id'];
      $view = new ParticipationView(EpreuveParticipation::findByEpreuve($id_epreuve));
      $view->render('tabResultat');
    }

    public function viewParticipantDossard(){
      $num_dossard = $_POST['num_dossard'];
      $ep = EpreuveParticipation::findByDossard($num_dossard);
      if(!$ep)
      {
        $ep = array('erreur' => 'Ce numéro ne correspond a aucun participant');
      }
      $view = new ParticipationView($ep);
      $view->render('tabResultatDossard');
    }
}
