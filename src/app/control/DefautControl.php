<?php

namespace app\control;

use app\model\Organisateur as organisateur;
use app\model\Participant as participant;
use app\model\Evenement;
use app\view\ParticipationView;


use app\view\DefautView as defautview;
use app\utils\Authentification as Auth;


class DefautControl
{
    private $request=null; 
    
    public function __construct(\app\utils\HttpRequest $http_req){
        $this->request = $http_req ;
    }
    /*
    * author : Ikram
    */
    public function GetOrganisateurInscForm()
    {
        $auth = new Auth();
        if($auth->logged_in)
        {
            $organisateur =  organisateur::getOrganisateurByLogin($auth->user_login);
        }else
        {
            $organisateur = new organisateur();
        }
        $view = new defautview($organisateur);
        $view->render('organisateurinsc');
    }
        /*
    * author : Cam Lien
    */
    public function aproposPage()
    {
        $view = new defautview($this->request);
        $view->render('apropos');
    }
    /*
    * author : Cam Lien
    */
    public function contactPage()
    {
        $view = new defautview($this->request);
        $view->render('contact');
    }
    /*
    * author : Ikram
    */
    public function SaveOrganisateur()
    {
        $post = $this->request->post;
        if(organisateur::getOrganisateurByLogin($post['login']))
            {
                $view = new defautview($this->request);
                $view->render('rendererreur');
            }
            else
            {
                 $organisateur = new organisateur();
                    if(isset($post['id_organisateur']))
                    $organisateur->id_organisateur = $post['id_organisateur'];
                    $organisateur->nom = filter_var( $post['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $organisateur->prenom = filter_var( $post['prenom'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $organisateur->email = filter_var( $post['email'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $organisateur->telephone = filter_var( $post['telephone'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $organisateur->url_site = $post['site_url'];
                    $organisateur->login = filter_var( $post['login'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $organisateur->password = $post['password'];
                    if($organisateur->save())
                        {
                            if($organisateur->action == "insert")
                                header('Location:'.$this->request->script_name.'/defaut/login/');
                            elseif ($organisateur->action == "update") {
                                header('Location:'.$this->request->script_name.'/defaut/perso/');
                            }
                        }
            }
    }
    /*
    * author : Ikram
    */
    public function GetParticipantInscForm()
    {
        $auth = new Auth();
        if($auth->logged_in)
        {
            $participant =  participant::getParticipantByLogin($auth->user_login);
        }else
        {
            $participant = new participant();
        }
        $view = new defautview($participant);
        $view->render('participantinsc');
    }
    /*
    * author : Ikram
    */
    public function SaveParticipant()
    {

        $post = $this->request->post;
        $participant = new participant();
        $participant->id_participant = filter_var( $post['id_participant'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->nom = filter_var( $post['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->prenom = filter_var( $post['prenom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->email = filter_var( $post['email'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->sexe = filter_var( $post['sexe'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->date_naissance = filter_var( $post['date_naissance'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->preferences = null;
        $participant->login = filter_var( $post['login'], FILTER_SANITIZE_SPECIAL_CHARS);
        $participant->password = $post['password'];
         if($participant->save())
            {
                if($participant->action == "insert")
                    header('Location:'.$this->request->script_name.'/defaut/login/');
                elseif ($participant->action == "update") {
                    header('Location:'.$this->request->script_name.'/defaut/perso/');
                }
            }
    }
    /*
    * author : Ikram
    */
    public function login()
    {
        $participant = new participant();
        $view = new defautview($participant);
        $view->render('login');
    }
    /*
    * author : Ikram
    */
    public function Logout()
    {
        $auth = new Auth();

        if($auth->logged_in) {
            $auth->logout();
        }
            $view = new defautview($auth); 
            $view->render('login');
    }
    /*
    * author : Ikram
    */
    public function CheckLogin()
    {
        $post = $this->request->post;
        $login = filter_var( $post['login'], FILTER_SANITIZE_SPECIAL_CHARS);
        $pass = filter_var( $post['password'], FILTER_SANITIZE_SPECIAL_CHARS);

        $auth = new Auth($post['login']);

        $user = $auth->login($login,$pass);
        if($auth->logged_in)
        {
            header('Location:'.$this->request->script_name.'/defaut/perso/');
        }else
        {
            header('Location:'.$this->request->script_name.'/defaut/login/');
        }
    }
    /*
    * author : Ikram
    */
    public function EspacePerso()
    {
        $auth = new Auth();
        if($auth->profil == "participant")
        {
            $participant = participant::getParticipantByLogin($auth->user_login);
            $view = new defautview($participant);
            $view->render('participantperso');
        }elseif ($auth->profil == "organisateur") {
            $organisateur = organisateur::getOrganisateurByLogin($auth->user_login);
            $view = new defautview($organisateur);
            $view->render('organisateurperso');
        }
    }
    /*
    * author : Ikram
    */
    public function indexPage()
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

    public function InscriptionChoix()
    {
        $view = new defautview($this->request);
        $view->render('choix_insc');
    }
}