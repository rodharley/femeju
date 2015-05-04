<?php

//verificando o controlador e a acao
if(isset($_SERVER['REDIRECT_URL'])){
$arrayControls = explode("-",$_SERVER['REDIRECT_URL']);
if(count($arrayControls) == 2){
define('_CONTROLLER', substr(strrchr($arrayControls[0],"/"),1));
define ('_ACTION', $arrayControls[1]);
}else{
define('_CONTROLLER','portal_home');
define ('_ACTION', 'index');
}
}else{
define('_CONTROLLER','portal_home');
define ('_ACTION', 'index');
}
?>