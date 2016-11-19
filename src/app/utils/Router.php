<?php
namespace app\utils;

//use wikiapp\model\Page as Pag; 
//use wikiapp\control\WikiController as controller; 

require_once "AbstractRouter.php"; 

Class Router extends AbstractRouter
{

  public function addRoute($url, $ctrl, $mth)
  {
    self::$routes[$url] = array($ctrl,$mth);
  
  }

  public function dispatch(HttpRequest $http_request)
  {
    if($http_request->path_info != '' )
    {
          $control = new self::$routes[$http_request->path_info][0]($http_request);
          $c = self::$routes[$http_request->path_info][1];
          $method = $control->$c();
    }
    else
    {
      $http_req = new HttpRequest();
      $ctrl = new controller($http_req);
      $ctrl->listAll();
    }
  }
}