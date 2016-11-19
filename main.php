<?php


require_once "conf/autoload.php";

session_start();
use app\model\Epreuve as epreuve;

app\utils\ConnectionFactory::setConfig("conf/config.ini");
header('Content-Type: text/html; charset=UTF-8');


$router = new app\utils\Router();
/*
* Ikram
*/
$router->addRoute('/defaut/organisateurinsc/',  '\app\control\DefautControl', 'GetOrganisateurInscForm');
$router->addRoute('/defaut/saveorganisateur/',  '\app\control\DefautControl', 'SaveOrganisateur');
$router->addRoute('/defaut/participantinsc/',  '\app\control\DefautControl', 'GetParticipantInscForm');
$router->addRoute('/defaut/saveparticipant/',  '\app\control\DefautControl', 'SaveParticipant');
$router->addRoute('/defaut/login/',  '\app\control\DefautControl', 'Login');
$router->addRoute('/defaut/logout/',  '\app\control\DefautControl', 'Logout');
$router->addRoute('/defaut/checklogin/',  '\app\control\DefautControl', 'CheckLogin');
$router->addRoute('/defaut/perso/',  '\app\control\DefautControl', 'EspacePerso');
$router->addRoute('/organisation/addresultat/',  '\app\control\OrganisationControl', 'getfile');
$router->addRoute('/organisation/upload_file/',  '\app\control\OrganisationControl', 'Savefile');
$router->addRoute('/organisation/download_file/',  '\app\control\OrganisationControl', 'downloadFile');
$router->addRoute('/defaut/index/',  '\app\control\DefautControl', 'indexPage');
$router->addRoute('/defaut/inscription_choix/',  '\app\control\DefautControl', 'InscriptionChoix');
/*
* Chakib
*/
$router->addRoute('/organisation/ajouter_epreuve/',  '\app\control\OrganisationControl', 'addEpreuve');
$router->addRoute('/organisation/add_epreuve/',  '\app\control\OrganisationControl', 'insertEpreuve');
$router->addRoute('/organisation/modifier_epreuve/',  '\app\control\OrganisationControl', 'updateEpreuve');
$router->addRoute('/organisation/update_epreuve/',  '\app\control\OrganisationControl', 'saveEpreuve');
$router->addRoute('/organisation/supprimer_epreuve/',  '\app\control\OrganisationControl', 'deleteEpreuve');
$router->addRoute('/organisation/ajouter_image/',  '\app\control\OrganisationControl', 'addPicture');
$router->addRoute('/organisation/add_image/',  '\app\control\OrganisationControl', 'insertPicture');
$router->addRoute('/participation/liste_evenements/',  '\app\control\ParticipationControl', 'listAllEvent');
$router->addRoute('/participation/visualiser_evenement/',  '\app\control\ParticipationControl', 'viewEvent');
$router->addRoute('/participation/liste_epreuves/',  '\app\control\ParticipationControl', 'listAllEpreuve');
$router->addRoute('/participation/visualiser_epreuve/',  '\app\control\ParticipationControl', 'viewEpreuve');
$router->addRoute('/organisation/validerEvenement/',  '\app\control\OrganisationControl', 'validerEvenement');
$router->addRoute('/organisation/ouvrir_inscription/',  '\app\control\OrganisationControl', 'ouvrirInscriptionEvenement');
$router->addRoute('/organisation/fermer_inscription/',  '\app\control\OrganisationControl', 'fermerInscriptionEvenement');
/*
* author : antoine
*/
$router->addRoute('/organisation/allEvent/'           , '\app\control\ParticipationControl', 'listAll');
$router->addRoute('/app/view/'                        , '\app\control\OrganisationControl' , 'viewEvenement');
$router->addRoute('/organisation/creerEvenement/'     , '\app\control\OrganisationControl' , 'creerEvenement');
$router->addRoute('/organisation/nouvelEvenement/'    , '\app\control\OrganisationControl' , 'addEvent');
$router->addRoute('/organisation/modifier_evenement/' , '\app\control\OrganisationControl' , 'updateEvenement');
$router->addRoute('/organisation/save_evenement/'     , '\app\control\OrganisationControl' , 'saveEvenement');
$router->addRoute('/organisation/supprimer_evenement/', '\app\control\OrganisationControl' , 'deleteEvenement');
$router->addRoute('/organisation/view/'               ,  '\app\control\OrganisationControl', 'listAllEpreuve');
$router->addRoute('/organisation/visualiser_epreuve/' ,  '\app\control\OrganisationControl', 'viewEpreuve');
$router->addRoute('/participation/participer_epreuve/', '\app\control\ParticipationControl', 'getParticipationForm');
$router->addRoute('/participation/save_participation/', '\app\control\ParticipationControl', 'saveParticipation');
$router->addRoute('/participation/view_participation/', '\app\control\ParticipationControl', 'viewParticipation');
$router->addRoute('/participation/paiement/'          , '\app\control\ParticipationControl', 'paiement');
$router->addRoute('/participation/rechercher_resultat/', '\app\control\ParticipationControl', 'viewEpreuveParticipant');
$router->addRoute('/participation/view_resultat/'     , '\app\control\ParticipationControl', 'viewResultat');
$router->addRoute('/participation/view_epreuve_participant/'     , '\app\control\ParticipationControl', 'viewEpreuveParticipant');
$router->addRoute('/participation/view_resultat_dossard/', '\app\control\ParticipationControl', 'viewParticipantDossard');
/*
* author : Cam lien 
*/
$router->addRoute('/defaut/a_propos/',  '\app\control\DefautControl', 'aproposPage');
$router->addRoute('/defaut/contact/',  '\app\control\DefautControl', 'contactPage');
$http_req = new app\utils\HttpRequest();

$router->dispatch($http_req);	