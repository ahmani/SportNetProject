<?php

namespace app\view;

abstract class AbstractView {


    protected $app_root = null;    /* répertoire racine de l'application */
    protected $script_name = null; /* le chemin vers le script */
    protected $data = null ;       /* une page ou un tableau de page */

    /* Constructeur
    *
    * Prend en paramète une variable (un objet page ou un tableau de page)
    *
    * - Stock la variable dans l'attribut $data
    * - Recupérer la racine de l'application depuis un objet HttpRequest,
    *   pour construire les URL des liens  et des actions des formulaire
    *   et le nom du scripte pour les stocker and les attributs
    *   $app_root et $script_name
    *
    */
    public function __construct($data){
        $this->data = $data;

        $http = new \app\utils\HttpRequest();
        $this->script_name  = $http->script_name;
        $this->app_root     = $http->getRoot();
    }

    public function __get($attr_name) {
        if (property_exists( $this, $attr_name))
            return $this->$attr_name;
        $emess = __CLASS__ . ": unknown member $attr_name (__get)";
        throw new \Exception($emess);
    }

    public function __set($attr_name, $attr_val) {
        if (property_exists($this , $attr_name))
            $this->$attr_name=$attr_val;
        else{
            $emess = __CLASS__ . ": unknown member $attr_name (__set)";
            throw new \Exception($emess);
        }
    }

    public function __toString(){
        $prop = get_object_vars ($this);
        $str = "";
        foreach ($prop as $name => $val){
            if( !is_array($val) )
                $str .= "$name : $val <br> ";
            else
                $str .= "$name :". print_r($val, TRUE)."<br>";
        }
        return $str;
    }


    /*
     *  Crée le fragment HTML de l'entête
     *
     */
    protected function renderHeader(){
        $exp= explode('main', $this->script_name);

            $html ='<header class="main-menu">
                        <div class="col-sm-16 col-md-16 nav-toggle">';
                                if(isset($_SESSION['user_login']))
                                {
                                    $html .= '<p class="bjr">Bonjour '.$_SESSION['user_login'];
                                    $html .= '<a class="btn deco" href="'.$this->script_name.'/defaut/logout/">Déconnexion</a></p>';
                                }else
                                {
                                    $html .= '<a href="'.$this->script_name.'/defaut/login/" class="btn btn-blue" id="connexion">Connexion</a>
                                              <a href="'.$this->script_name.'/defaut/inscription_choix/" id="inscription" class="btn btn-blue">Inscription</a>';
                                }
                                $html .= '<a href="#" class="resp-menu"><i class="fa fa-bars"></i></a>
                        </div>
                    <div class="row col-lg-16 header-div">
                        <div class="col-lg-3 offset-lg-3 col-sm-16 offset-sm-0 offset-md-0 col-md-16 logo">
                            <a href="'.$this->script_name.'/defaut/index/"><img alt="logo" src="'.$exp[0].'/html/img/sportnet_logo.png"></a>
                        </div>
                        <div class="col-lg-4 offset-lg-4 col-sm-4 right-menu">
                            
                            <div class="row">';
                                if(isset($_SESSION['user_login']))
                                {
                                    $html .= '<p class="bjr">Bonjour '.$_SESSION['user_login'];
                                    $html .= '<a class="btn deco" href="'.$this->script_name.'/defaut/logout/">Déconnexion</a></p>';
                                }else
                                {
                                    $html .= '<a href="'.$this->script_name.'/defaut/login/" class="btn btn-blue">Connexion</a>
                                            <a href="'.$this->script_name.'/defaut/inscription_choix/" class="btn btn-blue">Inscription</a>';
                                }
                            $html .='</div>
                            <!--<div class="row recherche">
                                <input type="text" name="recherche" id="recherche">
                            </div>-->
                        </div>
                    </div>
                    <nav class="row col-lg-16 main-nav">
                        <ul>
                            <li class="col-lg-3"><a href="'.$this->script_name.'/defaut/index/">Accueil</a></li>
                            <li class="col-lg-3"><a href="'.$this->script_name.'/defaut/a_propos/">A propos</a></li>
                            <li class="col-lg-3"><a href="'.$this->script_name.'/organisation/allEvent/">Liste des évenements</a></li>
                            <li class="col-lg-3"><a href="#">Résultats</a></li>
                            <li class="col-lg-3"><a href="'.$this->script_name.'/defaut/contact/">Contact</a></li>
                        </ul>
                    </nav>

                    <nav class="col-sm-14 col-md-14 resp-nav offset-lg-1">
                        <ul>
                            <li><a href="'.$this->script_name.'/defaut/index/"></a>Accueil</li>
                            <li><a href="'.$this->script_name.'/defaut/a_propos/"></a>A propos</li>
                            <li><a href="'.$this->script_name.'/organisation/allEvent/"></a>Liste des évenements</li>
                            <li><a href="#"></a>Résultats</li>
                            <li><a href="'.$this->script_name.'/defaut/contact/"></a>Contact</li>
                        </ul>
                    </nav>
                </header>';
        return $html;
    }

    /*
     * Crée le fragment HTML du bas de la page
     *
     */
    protected function renderFooter(){
        $html = 'Sportnet la super app créée en Licence Pro &copy; 2016';
        return $html;
    }


    /*
     * Crée le fragment HTML dumenu
     *
     */
    protected function renderSidebar(){
        if(isset($_SESSION['user_login']))
        {
            $html= 
        '<div class="sidebar offset-lg-1 col-lg-4 col-sm-10 offset-sm-3 col-md-10 offset-md-3">
            <ul>';
            if(isset($_SESSION['profil']) && $_SESSION['profil'] == 'organisateur')
            {
                $html .= '<li class="has-sub-menu closed">Gestion des évenements
                        <ul class="sub-menu">
                            <li><a href="'.$this->script_name.'/organisation/allEvent/">Liste des évenements</a></li>
                            <li><a href="'.$this->script_name.'/organisation/creerEvenement/">Créer un évenement</a></li>
                        </ul>
                </li>';
            }
                

                $html .= '<li><a href="'.$this->script_name.'/defaut/perso/">Mon compte</a></li>
                <li class="has-sub-menu closed"><a href="#">Résultats</a>
                        <ul class="sub-menu">
                            <li><a href="'.$this->script_name.'/participation/rechercher_resultat/">Consulter les résultats généraux</a></li>';
                             if(isset($_SESSION['profil']) && $_SESSION['profil'] == 'organisateur')
                             {
                                $html .= '<li><a href="'.$this->script_name.'/organisation/allEvent/">Ajouter les résultats</a></li>';
                             }
                     $html .= '       
                        </ul>
                </li>
                <li><a href="'.$this->script_name.'/defaut/logout/">Déconnexion</a></li>
            </ul>
        </div>
        ';
        return $html;
        }
        //$html .= (!isset($_SESSION['user_login']) ? '<li><a href="'.$this->script_name.'/admin/login/">Connexion</a></li>' : "");

        

    }


    /*
     * Affiche une page HTML complète.
     *
     * A definir dans les classe concrètes
     *
     */
    abstract public function render($selector);



}
