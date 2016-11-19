<?php
/*
*
* author : ikram
*/
namespace app\view;

class DefautView  extends AbstractView{
    
    public function __construct($data){
        parent::__construct($data);
    }

    protected function renderAll(){
        
    }

    protected function renderOrganisateurInsc()
    {
        $http_req = new \app\utils\HttpRequest();
        $id_organisateur = (isset($this->data->id_organisateur)) ? $this->data->id_organisateur : '';
        $nom = (isset($this->data->nom)) ? $this->data->nom : '';
        $prenom = (isset($this->data->prenom)) ? $this->data->prenom : '';
        $email = (isset($this->data->email)) ? $this->data->email : '';
        $telephone = (isset($this->data->telephone)) ? $this->data->telephone : '';
        $site_url = (isset($this->data->url_site)) ? $this->data->url_site : '';
        $login = (isset($this->data->login)) ? $this->data->login : '';
        $form = '
            <form class="formulair" id="organisateurform" method="post" action="'.$http_req->script_name.'/defaut/saveorganisateur/">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" value="'.$nom.'" />
            </div>
            <div>
                <label for="prenom">Prénom : </label>
                 <input type="text" name="prenom" id="prenom" value="'.$prenom.'" />
            </div>
            <div>
                <label for="email">Email : </label>
                 <input type="email" name="email" id="email" value="'.$email.'" />
            </div>
            <div>
                <label for="telephone">Téléphone : </label>
                 <input type="text" name="telephone" id="telephone" value="'.$telephone.'" />
            </div>
            <div>
                <label for="site_url">Url du site : </label>
                 <input type="text" name="site_url" id="site_url" value="'.$site_url.'" />
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
                <input type="hidden" name="id_organisateur" value="'.$id_organisateur.'">
                <input type="submit" name="submit" value="Valider" class="btn btn-blue" />
            </div>
        </form>
        ';
        return $form;
    }

        protected function renderParticipantInsc()
    {
        $http_req = new \app\utils\HttpRequest();

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
            <form class="formulair" id="participantform" method="post" action="'.$http_req->script_name.'/defaut/saveparticipant/">
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
                <input type="submit" name="submit" value="Valider" class="btn btn-blue" />
            </div>
        </form>
        ';
        return $form;
    }
    /*
    * author : Cam Lien
    */
    protected function render_a_propos()
    {
        $http_req = new \app\utils\HttpRequest();
        $apropostext = '
            <h1>A propos</h1>
            <p>Notre  société, domiciliée à la périphérie de Nancy (54), assure la promotion et la gestion d’épreuves sportives.
            Notre application SportNet a été développée a cet effet : elle permet aux internautes d\'être au courant de tous les événements sportifs, d\'avoir 
            des informations concernant ceux-ci, et de participer aux différentes épreuves proposées facilement.
            </p>
        ';
        return $apropostext;
    }

    /*
    * author : Cam Lien
    */
    protected function render_contact()
    {
        $http_req = new \app\utils\HttpRequest();
        $contactext = '
            <h1>Contact</h1>
            <p>
                SportNet contact <br>
                Adresse : 304 rue Jeanne d\'Arc <br>
                E-mail : sportnet@sport.com <br>
                Tel : 00 11 22 33 44
            </p>
        ';
        return $contactext;
    }

    protected function renderLogin(){

        $http_req = new \app\utils\HttpRequest();

        $form= '
        <form method="post" class="formulair" action="'.$http_req->script_name.'/defaut/checklogin/">
            <div>
                <label for="login">Nom d\'utilisateur :</label>
                <input type="text" name="login" />
            </div>
            <div>
                <label for="pass">Mot de passe : </label>
                <input type="password" name="password" id="pass" />
            </div>
            <div>
                <input type="submit" name="submit" value="Valider" class="btn btn-blue" />
            </div>
        </form>
        ';
        return $form;
        
    } 

    protected function RenderOrganisateurPerso()
    {
                $http_req = new \app\utils\HttpRequest();
                $form = '<fieldset>
                <legend>Espace Personnel</legend>
                    <div>
                        <p>Nom : '.$this->data->nom.'</p>
                    </div>
                    <div>
                        <p>Prénom : '.$this->data->prenom.'</p>
                    </div>
                    <div>
                        <p>Email : '.$this->data->email.'</p>
                    </div>
                    <div>
                        <p>Téléphone : '.$this->data->telephone.'</p>
                    </div>
                    <div>
                        <p>Site url : '.$this->data->url_site.'</p>
                    </div>
                    <div>
                        <p>Login : '.$this->data->login.'</p>
                    </div>
                    <div>
                       <a href="'.$http_req->script_name.'/defaut/organisateurinsc/" class="btn btn-blue">Modifier</a>
                    </div></fieldset>
                ';
                return $form;
    }
    protected function RenderChoixInsc()
    {
        $form = '<div class="toggle-choix text-center">
                        
                        <input type="radio" name="choix" value="participant" id="participant"/>
                        <label for="participant">Participant</label>
                        
                        <input type="radio" name="choix" value="organisateur" id="organisateur"/>
                        <label for="organisateur">Organisateur</label>
                </div>';
        $form .= $this->renderParticipantInsc();
        $form .= $this->renderOrganisateurInsc();
        return $form;

    }   
    protected function RenderErreur()
    {
        $http_req = new \app\utils\HttpRequest();
        $form = '<div class="alert soft">Le login que vous avez choisit est déja utilisé</div>
                <div class="actions"><a class="btn btn-blue" href="'.$http_req->script_name.'/defaut/inscription_choix/">Réessayer</a></div>';
        return $form;
    }

    protected function renderParticipantPerso()
    {
               $http_req = new \app\utils\HttpRequest();
        $form = '
            <form class="formulair" method="post" action="'.$http_req->script_name.'/defaut/saveparticipant/">
            <div>
                <p>Nom : '.$this->data->nom.'</p>
            </div>
            <div>
                <p>Prénom : '.$this->data->prenom.'</p>
            </div>
            <div>
                <p>Email : '.$this->data->email.'</p>
            </div>
            <div>
                <p>Sexe : '.$this->data->sexe.'</p>
            </div>
            <div>
                <p>Date de naissance : '.$this->data->date_naissance.'</p>
            </div>
            <div>
                <p>Login : '.$this->data->login.'</p>
            </div>
            <div>
                <a href="'.$http_req->script_name.'/defaut/participantinsc/" class="btn btn-blue">Modifier</a>
            </div>
        </form>
        ';
        return $form;
    }

    public function render($selector){
        switch($selector){
        
        /*case 'organisateurinsc':
            $main = $this->renderOrganisateurInsc();
            break;
        case 'participantinsc':
            $main = $this->renderParticipantInsc();
            break;*/
        case 'login':
            $main = $this->renderLogin();
            break;
        case 'participantperso':
            $main = $this->renderParticipantPerso();
            break;
        case 'organisateurperso':
            $main = $this->RenderOrganisateurPerso();
            break;
        case 'apropos':
            $main = $this->render_a_propos();
            break;
        case 'contact':
            $main = $this->render_contact();
            break;
        case 'all':
            $main = $this->renderAll();
            break;
        case 'choix_insc':
            $main = $this->RenderChoixInsc();
              break; 
        case 'rendererreur':
            $main = $this->RenderErreur();
              break; 
        default:
            $main = $this->renderAll();
            break;
        }
        $exp= explode('main', $this->script_name);

        $style_file = $exp[0].'/html/style.css';
        
        $header = $this->renderHeader();
        $sidebar   = $this->renderSidebar();
        //$footer = $this->renderFooter();
       if(isset($_SESSION['user_login']))
        {
            $classes = "col-lg-9 offset-lg-1 offset-sm-2 col-sm-12 col-md-12 offset-md-2";
        }else{
            $classes = "col-lg-10 offset-sm-1 col-sm-12 col-md-12 offset-md-2 offset-lg-3";
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
            ${sidebar}
            <div class="${classes} content" >  ${main} </article>
            </div>
        </body>
</html>
EOT;

    echo $html;
        
    }

    
}
