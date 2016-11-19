<?php

namespace app\view;

use app\model\Epreuve;

class ParticipationView  extends AbstractView{

    public function __construct($data){
        parent::__construct($data);
    }

    protected function renderAll(){
      $http_req = new \app\utils\HttpRequest();
      $render = '<table><th>Evènement</th><th>Lieu</th><th>Date</th><th></th>';
      $tab = $this->data;
      if(count($tab) > 0)
      {
          if(isset($tab['erreur']))
            {
              $render .= '<tr><td colspan="3">'.$tab['erreur'].'</td></tr>';
            }
          else
          {
              foreach($tab as  $value)
              {
                $link = $this->script_name."/app/view/?id=".$value->id_evenement;
                $render .= "<tr><td><a href=\"$link\">".$value->nom."</a></td>
                              <td>".$value->lieu."</td>
                              <td>".$value->date_debut."</td>
                              ";
                  if(isset($_SESSION['profil']) && $_SESSION['profil'] == "organisateur")
                  {
                      $render .= "<td><a href=".$http_req->script_name."/app/view/?id=".$value->id_evenement.">Modifier</a></td>";
                  }
                  elseif((isset($_SESSION['profil']) && $_SESSION['profil'] != "organisateur") || !isset($_SESSION['profil']))
                  {
                      $render .= "<td><a href=".$http_req->script_name."/participation/liste_epreuves/?id=".$value->id_evenement.">Je participe</a></td>";
                  }

                $render .=  '</tr>';
                }
          }
        
      }
      $render .= '</table>';
      return $render;
    }
    protected function renderAllEpreuves()
    {
        $http_req = new \app\utils\HttpRequest();
        if($_GET['id'])
        {
          $id= $_GET['id'];
        }else
        {
          $id= $this->data[0]->id_evenement;
        }
        $chaine="<h2>Liste des épreuves : </h2>";
        $chaine .= '<form method="post" action="'.$http_req->script_name.'/participation/participer_epreuve/">
                  <table><th></th><th>Epreuve</th><th>Tarif</th><th>Date</th>';
        foreach ($this->data as $key => $value) {
           $chaine .= "<tr>
              <td><input type='checkbox' name= 'epreuves[]' value='".$value->id."'/></td>
              <td><a href=".$http_req->script_name."/participation/visualiser_epreuve/?id=".$value->id.">".$value->nom."</a></td>
              <td>".$value->tarif."</td>
              <td>".$value->date."</td>
           </tr>"; 
        }
        $chaine .= '</table><div class="actions">';
            if(isset($_SESSION['profil']) && $_SESSION['profil'] == 'organisateur')
            {
                $chaine .='<a href="'.$http_req->script_name.'/organisation/ajouter_epreuve/?id='.$id.'" class="btn btn-blue">Ajouter nouvelle épreuve</a>';
            }
            if(!empty($this->data) && (!isset($_SESSION['profil'])) && ((isset($_SESSION['profil']) && $_SESSION['profil'] != 'organisateur')))
            {
                $chaine .= '<input type="submit" name="submit" value="Je m\'inscris" class="btn btn-blue" />';
            }
        
        $chaine .= '</div></form>';
        return $chaine;
    }

    /*protected function renderViewEvent()
    {
        $http_req = new \app\utils\HttpRequest();

        $form= '
        <fieldset>
            <p>
                <label for="nom">Nom :</label>
                <span name="nom">'.$this->data->nom.'</span>
            </p>
            <p>
                <label for="description">Description : </label>
                <span name="description">'.$this->data->description.'</span>
            </p>
            <p>
                <label for="lieu">Lieu : </label>
                <span name="lieu">'.$this->data->lieu.'</span>
            </p>
            <p>
                <label for="date_debut">Date de début : </label>
                <span name="date_debut">'.$this->data->date_debut.'</span>
            </p>
            <p>
                <label for="date_fin">Date de fin : </label>
                <span name="date_fin">'.$this->data->date_fin.'</span>
            </p>
            <p>
                <label for="etat">Etat : </label>
                <span name="etat">'.$this->data->etat.'</span>
            </p>
            <p>
                <a href="'.$http_req->script_name.'/participation/liste_epreuves/?id='.$this->data->id_evenement.'">[    Afficher la liste des épreuves    ]</a>
            </p>
        </fieldset>
        ';

        return $form;
    }*/

    protected function renderViewEpreuve(){

        $http_req = new \app\utils\HttpRequest();
        $form= '<div class="text-right">';
        if(isset($_SESSION['profil']) && $_SESSION['profil'] == "organisateur")
              {
                  $form .= '<a class="btn btn-blue right" href="'.$http_req->script_name.'/organisation/ajouter_epreuve/?id='.$this->data->id_evenement.'">Ajouter nouvelle épreuve</a>
                   ';
              }
        $form .='
       </div> <fieldset>
            <p>
                <label for="nom">Nom :</label>
                <span name="nom">'.$this->data->nom.'</span>
            </p>
            <p>
                <label for="description">Description : </label>
                <span name="description">'.$this->data->description.'</span>
            </p>
            <p>
                <label for="date">Date de l\'épreuve : </label>
                <span name="date">'.$this->data->date.'</span>
            </p>
            <p>
                <label for="date">Tarif : </label>
                <span name="tarif">'.$this->data->tarif.' euro</span>
            </p>
            <p>
                <label for="date_limit_insc">Date limite d\'inscription : </label>
                <span name="date_limit_insc">'.$this->data->date_limit_insc.'</span>
            </p>';
              if(isset($_SESSION['profil']) && $_SESSION['profil'] == "organisateur")
              {
                $form .= '<p>
                    <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/modifier_epreuve/?id='.$this->data->id.'">Modifier</a>
                    <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/supprimer_epreuve/?id='.$this->data->id.'">Supprimer</a>
                    <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/ajouter_image/?id='.$this->data->id.'">Ajouter une image</a>
                </p>
                <p>
                    <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/addresultat/?id='.$this->data->id.'">Ajouter des résultats</a>
                    <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/download_file/?id='.$this->data->id.'">Télécharger liste des inscrits</a>
                </p>';
              }
            

        $form .= '</fieldset>

        
        ';

        return $form;
    }
        protected function renderParticipationForm(){
      $http_req = new \app\utils\HttpRequest();
     // $id_epreuve = $_GET['id'];
      $id_participant = (isset($this->data->id_participant)) ? $this->data->id_participant : '';
      $nom = (isset($this->data->nom)) ? $this->data->nom : '';
      $prenom = (isset($this->data->prenom)) ? $this->data->prenom : '';
      $email = (isset($this->data->email)) ? $this->data->email : '';
      $sexe = (isset($this->data->sexe)) ? $this->data->sexe : '';
      $date_naissance = (isset($this->data->date_naissance)) ? $this->data->date_naissance : '';
      $login = (isset($this->data->login)) ? $this->data->login : '';
      $checked_h = ($sexe == 'homme') ? "checked" : "";
      $checked_f = ($sexe == 'femme') ? "checked" : "";

      $form = '
          <form method="post" class="formulair" action="'.$http_req->script_name.'/participation/save_participation/">
          <div>
              <label for="nom">Nom :</label>
              <input type="text" name="nom" id="nom" value="'.$nom.'"/>
          </div>
          <div>
              <label for="prenom">Prénom : </label>
               <input type="text" name="prenom" id="prenom" value="'.$prenom.'"/>
          </div>
          <div>
              <label for="email">Email : </label>
               <input type="email" name="email" id="email" value="'.$email.'"/>
          </div>
          <div>
              <label>Sexe : </label>
               <label for="homme">Homme</label><input type="radio" name="sexe" id="homme" value="homme"  '.$checked_h.'/>
               <label for="femme">Femme</label><input type="radio" name="sexe" id="femme" value="femme" '.$checked_f.' />
          </div>
          <div>
              <label for="date_naissance">Date de naissance : </label>
               <input type="date" name="date_naissance" id="date_naissance" value="'.$date_naissance.'" />
          </div>
          <div>
              <label for="login">Login : </label>
               <input type="text" name="login" id="login" value="'.$login.'" />
          </div>
          <div>
              <label for="password">Mot de passe : </label>
               <input type="password" name="password" id="password" />
          </div>
          <div>
              <input type="hidden" name="id_participant" value="'.$id_participant.'">
              <input type="hidden" name="id_epreuve" value="">
              <input type="submit" name="submit" value="Procéder au paiement " class="btn btn-blue" />
          </div>
      </form>
      ';
      return $form;
    }

    protected function renderPaiementForm(){
      $http_req = new \app\utils\HttpRequest();
      $form='<form class="formulair" method="post" action="'.$http_req->script_name.'/participation/view_participation/?id='.$this->data['id_inscription'].'">
  <fieldset>
    <legend>Vos épreuves </legend>
    <p>Vous avez choisi de vous inscrire aux épreuves suivantes :</p>
    ';
    $form .= '<ul>';
    foreach ($this->data['epreuves'] as $key => $value) {
      $form .= '<li><a href="'.$http_req->script_name.'/participation/visualiser_epreuve/?id='.$key.'">'.$value.'</a></li>';
    }
    $form .= '</ul>';
  $form .= '</fieldset>
  <fieldset>
    <legend>Informations CB</legend>
    <ul>
      <li>
          <legend>Type de carte bancaire</legend>
              <input id=visa name=type_de_carte type=radio>
              <label for=visa>VISA</label>
              <input id=mastercard name=type_de_carte type=radio>
              <label for=mastercard>Mastercard</label>
      </li>
      <li>
        <label for=numero_de_carte>N° de carte</label>
        <input id=numero_de_carte name=numero_de_carte type=text>
      </li>
      <li>
        <label for=securite>Code sécurité</label>
        <input id=securite name=securite type=text>
      </li>
      <li>
        <label for=nom_porteur>Nom du porteur</label>
        <input id=nom_porteur name=nom_porteur type=text placeholder="Même nom que sur la carte">
      </li>
    </ul>
  </fieldset>

  <fieldset>
    <input type="submit" class="btn btn-blue" value="Valider">
  </fieldset>
</form>';
    return $form;
    }
    public function renderTabEpreuve(){
      $http_req = new \app\utils\HttpRequest();
      $render ='<h3>Epreuves</h3>';
       $render .= '<table><th>Epreuve</th><th>Tarif</th><th>Date</th><th></th>';
      foreach($this->data[0] as $value){

          $render .= "<tr>
                          <td><a href=".$http_req->script_name."/participation/visualiser_epreuve/?id=".$value->id.">".$value->nom."</a></td>
                          <td>".$value->tarif."</td>
                          <td>".$value->date."</td>
                          <td><a href=".$http_req->script_name."/participation/view_resultat/?id=".$value->id.">Résultats</a></td>
                      </tr>"; 


      }
      $render.='</table>';
      return $render;
    }

    public function renderViewParticipation(){
      $render = '
      <p>Vous êtes desormais inscrit à cette epreuve</p>
      <p>Votre numero de dossard est le '.$this->data->id_inscription.'</p>
        ';
      return $render;
    }

    public function renderTabResultat(){
      $http_req = new \app\utils\HttpRequest();


      $id_epreuve = (isset($this->data[0]->id_epreuve) ? $this->data[0]->id_epreuve : "");
      $render = '<form method ="post" action="'.$http_req->script_name.'/participation/view_resultat_dossard/?id='.$id_epreuve.'">
                <label for=num_dossard>Entrez un numero de dossard</label>
                <input id=num_dossard name=num_dossard type=text>
                <button type=submit>Valider</button>
                </form>
                <table>
                  <th>Classement</th>
                  <th>n° dossard</th>
                  <th>Score</th>
                ';
            if(isset($this->data["erreur"]))
            {
              $render .= '<tr>'.$this->data["erreur"].'</tr>';
            }else
            {
              foreach($this->data as $value){
              $render .= '<tr>
                            <td>'.$value->classement.'</td>
                            <td>'.$value->num_dossard.'</td>
                            <td>'.$value->score.'</td>
                          </tr>';
              }
            }
      
      $render.='</table>';
      return $render;
    }

    public function renderTabResultatDossard(){
      $http_req = new \app\utils\HttpRequest();
       $id_epreuve = (isset($this->data[0]->id_epreuve)) ? $this->data[0]->id_epreuve : "";
       $render = '<form method ="post" action="'.$http_req->script_name.'/participation/view_resultat_dossard/?id='.$id_epreuve.'">
                <label for=num_dossard>Entrez un numero de dossard</label>
                <input id=num_dossard name=num_dossard type=text>
                <button type=submit>Valider</button>
                </form>
                  <table>
                  <th>Classement</th>
                  <th>n° dossard</th>
                  <th>Score</th>
                  ';  
      if(isset($this->data["erreur"]))
            {
              $render .= '<tr>'.$this->data["erreur"].'</tr>';
            }else
            {
                $render .= '<tr>
                                    <td>'.$this->data->classement.'</td>
                                    <td>'.$this->data->num_dossard.'</td>
                                    <td>'.$this->data->score.'</td>
                          </tr>';
            }
      
                  

                $render .= '</table>';
      return $render;
    }

    public function render($selector){
        switch($selector){

        case 'all':
            $main = $this->renderAll();
            break;
        case 'allEpreuves':
            $main = $this->renderAllEpreuves();
            break;

        case 'viewEvent':
            $main = $this->renderViewEvent();
            break;

        case 'viewEpreuve':
            $main = $this->renderViewEpreuve();
            break;
        case 'participationForm':
            $main = $this->renderParticipationForm();
            break;
        case 'paiementForm':
            $main = $this->renderPaiementForm();
            break;
        case 'viewParticipation':
            $main = $this->renderViewParticipation();
            break;
         case 'chercherResultat':
            $main = $this->renderRechercheResultat();
            break;
        case 'tabEpreuve':
            $main = $this->renderTabEpreuve();
            break;
        case 'tabResultat';
            $main = $this->renderTabResultat();
            break;
        case 'tabResultatDossard':
            $main = $this->renderTabResultatDossard();
        default:
            $main = $this->renderAll();
            break;
        }
        
        $exp= explode('main', $this->script_name);

        $style_file = $exp[0].'/html/style.css';
        
        $header = $this->renderHeader();
        $sidebar   = $this->renderSidebar();

        $img = "";        
        $http_req = new \app\utils\HttpRequest();
        if($http_req->path_info == '/defaut/index/')
        {
            $img = '<div class="row col-lg-16 banniere">
                          <img src="'.$exp[0].'/html/img/banniere_event_sportif.jpg" />  
                    </div>';
        }
         if(isset($_SESSION['user_login']))
        {
            $classes = "col-lg-9 offset-lg-1 offset-sm-2 col-sm-12 col-md-12 offset-md-2";
        }else{
            $classes = "col-lg-10 offset-sm-1 col-sm-8 col-md-12 offset-md-2 offset-lg-3";
        }    
        $html = <<<EOT
        <!DOCTYPE html>
        <html>
            <head>
            <title>SportNet</title>
            <link rel="stylesheet" href="${exp[0]}/html/css/styles.css" type="text/css" />
            <link rel="stylesheet" href="${exp[0]}/html/css/boites.css" type="text/css" />
            <link rel="stylesheet" href="${exp[0]}/html/css/responsive.css" type="text/css" />
            <script src="${exp[0]}html/js/jquery-3.1.1.js"></script>
            <script src="${exp[0]}html/js/script.js"></script>
            <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <meta name="viewport" content="width=device-width" />
            <meta charset="UTF-8">
            <link href="http://fonts.googleapis.com/css?family=Bitter" rel="stylesheet" type="text/css">
        </head>
        <body>
            <div class="container">
            ${header}
            ${img}
            ${sidebar}
            <div class="${classes} content" >  ${main} </article>
            </div>
        </body>
        </html>
EOT;

    echo $html;

    }


}
