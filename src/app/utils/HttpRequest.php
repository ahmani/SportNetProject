<?php

namespace app\utils;

use app\utils\Router;

require_once "AbstractHttpRequest.php";


class HttpRequest extends AbstractHttpRequest
{
	public function __construct()
		{
			$this->script_name = $_SERVER['SCRIPT_NAME'];
			$this->path_info = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : "";
			$this->query = $_SERVER['QUERY_STRING'];
			$this->method = $_SERVER['REQUEST_METHOD'];
			$this->get = $_GET;
			$this->post = $_POST;
		}

	public function getRoot()
		{
			$path = $_SERVER['SCRIPT_NAME'];
			$explode = explode("/", $path);
			return $explode[1];

		}

	public function getController()
	{
		$url = Router::$routes[$this->path_info];
		$actrl = $url[0];
		if($action){
			return $ctrl;
		}
		return false;
	}

	public function getAction()
	{
		$url = Router::$routes[$this->path_info];
		$action = $url[1];
		if($action){
			return $action;
		}
		return false;
	}
}
