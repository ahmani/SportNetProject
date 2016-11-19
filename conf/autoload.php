<?php
function mon_autoload($s){
  $res = "";
  for($i = 0; $i < strlen($s); $i++){
    if($s[$i] == '\\'){
      $s[$i] = '/';
    }
  }
  $res.=$s;
  $res.=".php";
  require_once "src/".$res;
}
spl_autoload_register('mon_autoload');
