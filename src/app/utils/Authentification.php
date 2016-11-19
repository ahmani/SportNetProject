<?php
namespace app\utils;

use app\model\Participant;
use app\model\Organisateur;

class Authentification extends AbstractAuthentification {
    public $profil;

  public function __construct () {
    if (isset ($_SESSION['user_login'])) {
        $this->user_login = $_SESSION['user_login'];
        $this->logged_in = true;
        $this->profil = $_SESSION['profil'];
    }
    else {
        $this->user_login = null;
        $this->logged_in = false;
        $this->profil = null;
    }
  }

  public function login($login, $password) {
      $participant = Participant::getParticipantByLogin($login);
      $organisateur = Organisateur::getOrganisateurByLogin($login);
      if ($participant) {
          if (password_verify($password,$participant->password)) {
              $this->user_login = $login;
              $this->logged_in = TRUE;
              $this->profil = "participant";
              $_SESSION['user_login'] = $login;
              $_SESSION['profil'] = "participant";
              
          }else {
              echo "Mauvais mot de passe";
          }
      }
      elseif ($organisateur) {
          if (password_verify($password,$organisateur->password)) {
              $this->user_login = $login;
              $this->logged_in = TRUE;
              $this->profil = "organisateur";
              $_SESSION['user_login'] = $login;
              $_SESSION['profil'] = "organisateur";
          }else {
              echo "Mauvais mot de passe";
          }
      }
      else{
          $resultat = "Utilisateur inexistant";
          echo $resultat;
      }
  }
    public function logout () {
        unset ($_SESSION['user_login']);
        unset ($_SESSION['profil']);
        $this->user_login = null;
        $this->profil = null;
        $this->logged_in = false;
    }

    /*public function createUser ($login, $pass, $level) {
      $user = new User();
      $user->login = $login;
      $user->pass = password_hash($pass, PASSWORD_DEFAULT);
      $user->level = $level;
      $user->save();
    }*/
}
