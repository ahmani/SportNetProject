<?php

namespace app\view;
use app\model\Discipline;

class OrganisationView  extends AbstractView{

    public function __construct($data){
        parent::__construct($data);
    }

    /*protected function renderAll(){

        $http_req = new \app\utils\HttpRequest();
        $chaine="<h1>Liste des épreuves : </h1><br/>";
        foreach ($this->data as $value) {
           $chaine .= "<a href=".$http_req->script_name."/organisation/visualiser_epreuve/?id=".$value->id.">".$value->nom."</a>
                        <br/>";
        }
        $chaine .= "<a href=".$http_req->script_name."/organisation/ajouter_epreuve/?id=".$_GET['id'].">Ajouter épreuve</a>";

        return $chaine;
    }*/

    protected function renderNewEvent()
    {
        $http_req = new \app\utils\HttpRequest();
        $tabdisc = Discipline::findAll();

        $renderList = "<select name='listDisc' size='1'>";

        foreach ($tabdisc as $disc) {
          $renderList .= '<option value="'.$disc->id.'">'.$disc->nom.'</option>';
        }

        $renderList .= "</select>";
        $render =
        '<form method="post" class="formulair" action="'.$http_req->script_name.'/organisation/nouvelEvenement/">
        <p><label>Nom de l\'evenement: </label><input type="text" name="nom" /></p>
        <p><label>Description: </label></p>
        <p><textarea name="description" rows = 10 cols = 40></textarea></p>
        <p><label>Lieu: </label><input type ="text" name="lieu"/></p>
        <p><label>Date début(aaaa/mm/jj): </label><input type ="date" name="date_debut"/></p>
        <p><label>Date fin(aaaa/mm/jj): </label><input type ="date" name="date_fin"/></p>
        <p><label>Discipline:'.$renderList.'</label></p>
        <input type="submit" value="Envoyer" class="btn btn-blue" />
        </form>';

        return $render;
    }

    protected function renderAddEpreuve()
    {

        $http_req = new \app\utils\HttpRequest();

        $form= '
        <form method="post" class="formulair" action="'.$http_req->script_name.'/organisation/add_epreuve/">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" />
            </div>
            <div>
                <label for="description">Description : </label>
                <textarea rows="4" cols="50" id="description" name="description"></textarea>
            </div>
            <div>
                <label for="date">Date de l\'épreuve : </label>
                <input type="date" id="date" name="date" />
            </div>
            <div>
                <label for="date">Tarif : </label>
                <input type="text" id="tarif" name="tarif" />
            </div>
            <div>
                <label for="date_limit_insc">Date limite d\'inscription : </label>
                <input type="date" id="date_limit_insc" name="date_limit_insc" />
            </div>
            <div>
                <input type="hidden"name="id_evenement" value="'.$_GET['id'].'">
                <input type="submit" name="submit" value="Valider" class="btn btn-blue" />
            </div>
        </form> 
        ';
        return $form;
    }

    /*protected function renderViewEpreuve()
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
            </p>
            <p>
                <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/modifier_epreuve/?id='.$this->data->id.'">Modifier</a>
                <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/supprimer_epreuve/?id='.$this->data->id.'">Supprimer</a>
            </p>
        </fieldset>

        <div class="actions">
            <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/ajouter_epreuve/'.'">Ajouter nouvelle épreuve</a>
        </div>
        ';

        return $form;
    }*/

    protected function renderUpdateEpreuve()
    {

        $http_req = new \app\utils\HttpRequest();

        $form= '
        <form method="post" class="formulair" action="'.$http_req->script_name.'/organisation/update_epreuve/">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" name="nom" value="'.$this->data->nom.'" />
            </div>
            <div>
                <label for="description">Description : </label>
                <textarea cols="40" rows="5" name="description">'.$this->data->description.'</textarea>
            </div>
            <div>
                <label for="date">Date de l\'épreuve : </label>
                <input type="date" name="date" value="'.$this->data->date.'" />
            </div>
            <div>
                <label for="date">Tarif : </label>
                <input type="text" name="tarif" value="'.$this->data->tarif.'" />
            </div>
            <div>
                <label for="date_limit_insc">Date limite d\'inscription : </label>
                <input type="date" name="date_limit_insc" value="'.$this->data->date_limit_insc.'" />
            </div>
            <div>
                <input type="submit" name="submit" value="Enregistrer" class="btn btn-blue" />
            </div>
        </form>
        ';

        return $form;
    }
        protected function renderAddPicture()
    {

        $http_req = new \app\utils\HttpRequest();

        $form= '
        <form method="post" class="formulair" action="'.$http_req->script_name.'/organisation/add_image/" enctype="multipart/form-data">
            <div>
                <label for="upfile">Choisir une image :</label>
                <input type="file" id="upfile" name="upfile" />
            </div>
            <div>
                <input type="text" name="id" hidden value="'.$this->data->id.'" />
                <input type="submit" name="submit" value="Valider" class="btn btn-blue" />
            </div>
        </form>
        ';
        return $form;     
    }
    public function renderViewEvenement(){
        $http_req = new \app\utils\HttpRequest();
        $render= '
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
                <label for="lieu">lieu : </label>
                <span name="lieu">'.$this->data->lieu.'</span>
            </p>
            <p>
                <label for="discipline">Discipline : </label>
                <span name="discipline">'.$this->data->id_discipline.'</span>
            </p>
            <p>
                <label for="date_debut">Date de début de l\'evenement : </label>
                <span name="date_debut">'.$this->data->date_debut.'</span>
            </p>
            <p>
                <label for="date_fin">Date de fin de l\'evenement : </label>
                <span name="date_fin">'.$this->data->date_fin.'</span>
            </p>';

            if (isset($_SESSION['profil']) && $_SESSION['profil'] == 'organisateur')
            {
                 if ($this->data->etat != "created" && $this->data->etat != "valid_close")
            {
                $render .= '<p>
                    <label for="lien_inscription">Lien pour s\'inscrire : </label>
                    <span name="lien_inscription">http://'.$_SERVER['HTTP_HOST'].$http_req->script_name.'/participation/liste_epreuves/?id='.$this->data->id_evenement.'</span>
                </p>';
            }
                    $render .='<p>
                        <label for="etat">Etat de l\'evenement : </label>
                        <span name="date_fin">'.$this->data->etat.'</span>
                    </p>
                    <p>
                    <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/validerEvenement/?id='.$this->data->id_evenement.'">Valider</a>
                        <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/modifier_evenement/?id='.$this->data->id_evenement.'">Modifier</a>
                        <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/supprimer_evenement/?id='.$this->data->id_evenement.'">Supprimer</a>
                        <a class="btn btn-blue" href="'.$http_req->script_name.'/participation/liste_epreuves/?id='.$this->data->id_evenement.'">Gérer les épreuves</a>
                    </p>
                    <p>
                        <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/ouvrir_inscription/?id='.$this->data->id_evenement.'">Ouvrir les inscriptions</a>
                        <a class="btn btn-blue" href="'.$http_req->script_name.'/organisation/fermer_inscription/?id='.$this->data->id_evenement.'">Fermer les inscriptions</a>
                    </p>
                </fieldset>
                ';
            } else {
                $render .= '</fieldset>';
            }
        return $render;
    }

    protected function renderUpdateEvenement()
    {

           $http_req = new \app\utils\HttpRequest();
      $tabdisc = Discipline::findAll();

      $renderList = '<select name="listDisc" size="1">';

      foreach ($tabdisc as $disc) {
        $renderList .= '<option value="'.$disc->id.'">'.$disc->nom.'</option>';
      }
      $renderList .= '</select>';
        $form= '
        <form method="post" class="formulair" action="'.$http_req->script_name.'/organisation/save_evenement/">
            <input type="hidden" name="id_evenement" value="'.$this->data->id_evenement.'"/>
            <div>
                <label for="nom">Nom :</label>
                <input type="text" name="nom" value="'.$this->data->nom.'" />
            </div>
            <div>
                <label for="description">Description : </label>
                <textarea cols="40" rows="5" name="description">'.$this->data->description.'</textarea>
            </div>
            <div>
                <label for="lieu">Lieu : </label>
                <input type="text" name="lieu" value="'.$this->data->lieu.'" />
            </div>
            <div>
                <label for="date">Date de début de l\'evenement : </label>
                <input type="date" name="date_debut" value="'.$this->data->date_debut.'" />
            </div>
            <div>
                <label for="date">Date de fin de l\'evenement : </label>
                <input type="date" name="date_fin" value="'.$this->data->date_fin.'" />
            </div>

            <div>
                <label for="discipline">Discipline : </label>
                '.$renderList.'
            </div>
            <div>
                <input type="submit" name="submit" value="Enregistrer" class="btn btn-blue" />
            </div>
        </form>
        ';

        return $form;
    }
       /*
    * author : ikram
    */

    public function RenderGetFile()
    {
        $http_req = new \app\utils\HttpRequest();
        $form = '
           <form enctype="multipart/form-data"  class="formulair" method="post" action="'.$http_req->script_name.'/organisation/upload_file/?id='.$_GET['id'].'">
            <div>
                <label>Le fichier à uploader</label>
                <input type="file" name="results" />
            </div>
            <div>    
                <input type="submit" name="valider" value="valider" class="btn btn-blue" />
            </div>
           </form> 
        ';return $form;
    }
    public function renderUploadedFile()
    {
        $form =  "<div class='alert soft'>Vos résultats ont été entregistrés avec succès.</div> 
                  <div class='actions'><a href='' class='btn btn-blue'><< Voir les résultats</a></div>
            ";

        return $form;

    }
    public function render($selector)
    {

        switch($selector){

            /*case 'all':
                $main = $this->renderAll();
                break;*/

            case 'addEpreuve':
                $main = $this->renderAddEpreuve();
                break;

            case 'viewEpreuve':
                $main = $this->renderViewEpreuve();
                break;

            case 'updateEpreuve':
                $main = $this->renderUpdateEpreuve();
                break;

            case 'newEvenement':
                $main = $this->renderNewEvent();
                break;
            case 'viewEvenement':
                $main = $this->renderViewEvenement();
                break;
            case 'updateEvenement':
                $main = $this->renderUpdateEvenement();
                break;
            case 'uploadFile':
                $main = $this->RenderGetFile();
                break;
            case 'addPicture':
                $main = $this->renderAddPicture();
                break;
            case 'fileuploaded':
                $main = $this->renderUploadedFile();
                break;
            /*default:
                $main = $this->renderAll();
                break;*/
        }

        $exp= explode('main', $this->script_name);

        $style_file = $exp[0].'/html/style.css';
        
        if(isset($_SESSION['user_login']))
        {
            $classes = "col-lg-9 offset-lg-1 offset-sm-2 col-sm-12 col-md-12 offset-md-2";
        }else{
            $classes = "col-lg-10 offset-sm-1 col-sm-8 col-md-12 offset-md-2 offset-lg-3";
        }

        $header = $this->renderHeader();
        $sidebar   = $this->renderSidebar();


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
EOT;

    echo $html;

    }
}
